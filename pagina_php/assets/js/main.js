
const tabla = document.getElementById("tablaBody");
const modal = document.getElementById("modalFormulario");
const form = document.getElementById("formAlimento");
const btnAgregar = document.getElementById("btnAgregar");
const cancelar = document.getElementById("cancelar");

let editando = false;

/* ===========================
   CARGAR TABLA
=========================== */
let paginaActual = 1;

function cargarTabla(pagina = 1) {

    paginaActual = pagina;

    const textoBusqueda = document.getElementById("busqueda").value;

    fetch("obtener_datos.php?pagina=" + pagina + "&busqueda=" + textoBusqueda)
        .then(res => res.json())
        .then(response => {

            const data = response.datos;
            const totalPaginas = response.totalPaginas;

            tabla.innerHTML = "";

            if (data.length === 0) {
                tabla.innerHTML = `
                <tr>
                    <td colspan="5" style="text-align:center;">
                        No se encontraron resultados
                    </td>
                </tr>
            `;
            }

            data.forEach(item => {

                tabla.innerHTML += `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.name}</td>
                    <td>${item.type}</td>
                    <td>$ ${formatearPrecio(item.price)}</td>
                    <td>${item.company ?? "Sin proveedor"}</td>
                    <td>
                        <button class="btn editar"
                            onclick="abrirEditar(${item.id},
                            '${item.name}',
                            '${item.type}',
                            ${item.price},
                            ${item.proveedor_id})">
                            Editar
                        </button>

                        <button class="btn eliminar"
                            onclick="eliminar(${item.id})">
                            Eliminar
                        </button>
                    </td>
                </tr>
            `;
            });

            generarPaginacion(totalPaginas);

        });
}

/* ===========================
   ABRIR MODAL NUEVO
=========================== */
btnAgregar.addEventListener("click", () => {
    editando = false;
    form.reset();
    cargarProveedoresSelect();
    modal.style.display = "flex";

});

/* ===========================
   CERRAR MODAL
=========================== */
cancelar.addEventListener("click", () => {
    modal.style.display = "none";
});

/* ===========================
   ABRIR EDITAR
=========================== */
function abrirEditar(id, name, type, price, proveedor_id) {

    editando = true;

    form.id.value = id;
    form.name.value = name;
    form.type.value = type;
    form.price.value = price;

    cargarProveedoresSelect(proveedor_id);

    modal.style.display = "flex";

}

/* ===========================
   GUARDAR 
=========================== */
form.addEventListener("submit", function (e) {
    e.preventDefault();

    const datos = new FormData(form);

    let url = editando ? "editar.php" : "guardar.php";

    fetch(url, {
        method: "POST",
        body: datos
    })
        .then(res => res.text())
        .then(resp => {
            if (resp === "ok") {
                modal.style.display = "none";
                cargarTabla(paginaActual);;
            }
        });
});

/* ===========================
   ELIMINAR 
=========================== */
function eliminar(id) {

    if (confirm("¿Eliminar?")) {

        fetch("eliminar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + id
        })
            .then(res => res.text())
            .then(resp => {
                if (resp === "ok") {
                    cargarTabla(paginaActual);;
                }
            });

    }
}

function formatearPrecio(valor) {
    return new Intl.NumberFormat('es-CO').format(valor);
}

function generarPaginacion(totalPaginas) {

    const contenedor = document.getElementById("paginacion");
    contenedor.innerHTML = "";

    for (let i = 1; i <= totalPaginas; i++) {

        contenedor.innerHTML += `
            <button 
                onclick="cargarTabla(${i})"
                style="
                    margin:5px;
                    padding:6px 12px;
                    border-radius:5px;
                    border:none;
                    cursor:pointer;
                    background:${i === paginaActual ? '#5a189a' : '#ddd'};
                    color:${i === paginaActual ? 'white' : 'black'};
                ">
                ${i}
            </button>
        `;
    }
}

function mostrarSeccion(seccion) {

    document.getElementById("seccion-alimentos").style.display = "none";
    document.getElementById("seccion-proveedores").style.display = "none";
    document.getElementById("seccion-dashboard").style.display = "none";

    if (seccion === "alimentos") {
        document.getElementById("seccion-alimentos").style.display = "block";
    }

    if (seccion === "otra") {
        document.getElementById("seccion-proveedores").style.display = "block";
        cargarProveedores(1);
    }

    if (seccion === "dashboard") {
        document.getElementById("seccion-dashboard").style.display = "block";
        cargarDashboard();
    }

}

let paginaProveedor = 1;
let paginaProveedorActual = 1;
function cargarProveedores(pagina = 1) {

    paginaProveedorActual = pagina;

    const texto = document.getElementById("busquedaProveedores").value;

    fetch("obtener_proveedores.php?pagina=" + pagina + "&busqueda=" + texto)
        .then(res => res.json())
        .then(response => {

            const tabla = document.getElementById("tablaProveedores");

            tabla.innerHTML = "";

            if (response.datos.length === 0) {

                tabla.innerHTML = `
                <tr>
                    <td colspan="5" style="text-align:center;">
                        No se encontraron resultados
                    </td>
                </tr>
            `;

                return;
            }

            response.datos.forEach(item => {

                tabla.innerHTML += `
            <tr>
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.company}</td>
                <td>${item.phone}</td>
                <td>

                    <button class="btn editar"
                        onclick="editarProveedor(
                        ${item.id},
                        '${item.name}',
                        '${item.company}',
                        '${item.phone}')">
                        Editar
                    </button>

                    <button class="btn eliminar"
                        onclick="eliminarProveedor(${item.id})">
                        Eliminar
                    </button>

                </td>
            </tr>
            `;
            });

            generarPaginacionProveedores(response.totalPaginas);

        });

}

document.addEventListener("DOMContentLoaded", function () {

    cargarTabla(1);

});

let editandoProveedor = false;
const modalProveedor = document.getElementById("modalProveedor");
const formProveedor = document.getElementById("formProveedor");

function abrirModalProveedor() {

    editandoProveedor = false;
    formProveedor.reset();

    modalProveedor.style.display = "flex";

}

function cerrarModalProveedor() {

    modalProveedor.style.display = "none";

}

function editarProveedor(id, name, company, phone) {

    editandoProveedor = true;

    document.getElementById("idProveedor").value = id;
    formProveedor.name.value = name;
    formProveedor.company.value = company;
    formProveedor.phone.value = phone;

    modalProveedor.style.display = "flex";

}

formProveedor.addEventListener("submit", function (e) {

    e.preventDefault();

    const datos = new FormData(formProveedor);

    let url = editandoProveedor
        ? "editar_proveedor.php"
        : "guardar_proveedor.php";

    fetch(url, {
        method: "POST",
        body: datos
    })
        .then(res => res.text())
        .then(resp => {

            if (resp === "ok") {

                modalProveedor.style.display = "none";
                cargarProveedores(1);

            }

        });

});

function eliminarProveedor(id) {

    if (confirm("¿Eliminar proveedor?")) {

        fetch("eliminar_proveedor.php", {

            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + id

        })
            .then(res => res.text())
            .then(resp => {

                if (resp === "ok") {

                    cargarProveedores(1);

                }

            });

    }

}

function generarPaginacionProveedores(totalPaginas) {

    const contenedor = document.getElementById("paginacionProveedores");

    contenedor.innerHTML = "";

    for (let i = 1; i <= totalPaginas; i++) {

        contenedor.innerHTML += `
            <button 
                onclick="cargarProveedores(${i})"
                style="
                    margin:5px;
                    padding:6px 12px;
                    border-radius:5px;
                    border:none;
                    cursor:pointer;
                    background:${i === paginaProveedorActual ? '#5a189a' : '#ddd'};
                    color:${i === paginaProveedorActual ? 'white' : 'black'};
                ">
                ${i}
            </button>
        `;

    }

}

const coloresSistema = [
    "#5a189a",
    "#7b2cbf",
    "#9d4edd",
    "#c77dff",
    "#e0aaff"
];

let graficoTipos;
let graficoRelacion;
let graficoProveedores;

function cargarDashboard() {

    fetch("obtener_estadisticas.php")
        .then(res => res.json())
        .then(data => {

            document.getElementById("totalAlimentos").innerText = data.totalAlimentos;
            document.getElementById("totalProveedores").innerText = data.totalProveedores;
            document.getElementById("precioPromedio").innerText = "$ " + Number(data.precioPromedio).toFixed(2);

            /* TABLA POR TIPO */

            const tabla = document.getElementById("tablaEstadisticas");
            tabla.innerHTML = "";

            let labels = [];
            let valores = [];

            data.porTipo.forEach(item => {

                tabla.innerHTML += `
                <tr>
                    <td>${item.type}</td>
                    <td>${item.total}</td>
                </tr>
                `;

                labels.push(item.type);
                valores.push(item.total);

            });

            /* DESTRUIR GRAFICOS SI EXISTEN */

            if (graficoTipos) {
                graficoTipos.destroy();
            }

            if (graficoRelacion) {
                graficoRelacion.destroy();
            }

            if (graficoProveedores) {
                graficoProveedores.destroy();
            }

            /* =========================
               GRAFICO ALIMENTOS POR TIPO
            ========================= */

            const ctx1 = document.getElementById("graficoTipos");

            graficoTipos = new Chart(ctx1, {

                type: 'bar',

                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Alimentos por tipo',
                        data: valores,
                        backgroundColor: coloresSistema,
                        borderColor: "#5a189a",
                        borderWidth: 1
                    }]
                },

                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }

            });

            /* =========================
               GRAFICO RELACION
            ========================= */

            const ctx2 = document.getElementById("graficoRelacion");

            graficoRelacion = new Chart(ctx2, {

                type: 'pie',

                data: {
                    labels: ['Alimentos', 'Proveedores'],
                    datasets: [{
                        data: [data.totalAlimentos, data.totalProveedores],
                        backgroundColor: [
                            "#5a189a",
                            "#c77dff"
                        ]
                    }]
                },

                options: {
                    responsive: true
                }

            });

            /* =========================
               GRAFICO PRODUCTOS POR PROVEEDOR
            ========================= */

            let labelsProv = [];
            let valoresProv = [];

            data.porProveedor.forEach(item => {

                labelsProv.push(item.company);
                valoresProv.push(item.total);

            });

            const ctx3 = document.getElementById("graficoProveedores");

            graficoProveedores = new Chart(ctx3, {

                type: 'bar',

                data: {
                    labels: labelsProv,
                    datasets: [{
                        label: 'Productos por proveedor',
                        data: valoresProv,
                        backgroundColor: coloresSistema,
                        borderColor: "#5a189a",
                        borderWidth: 1
                    }]
                },

                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }

            });

        });

}

function cargarProveedoresSelect(seleccionado = null) {

    fetch("obtener_proveedores_select.php")
        .then(res => res.json())
        .then(data => {

            const select = document.getElementById("proveedorSelect");

            select.innerHTML = '<option value="">Seleccione proveedor</option>';

            data.forEach(prov => {

                let selected = prov.id == seleccionado ? "selected" : "";

                select.innerHTML += `
                <option value="${prov.id}" ${selected}>
                ${prov.company}
                </option>
                `;
            });
        });
}

document.getElementById("busqueda").addEventListener("keyup", function () {
    cargarTabla(1);
});