<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Tabla de Alimentos</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="layout">

        <!-- SIDEBAR -->
        <div class="sidebar">

            <h2 style="margin-bottom:10px;">Panel</h2>

            <button onclick="mostrarSeccion('alimentos')" class="menu-btn">
                Alimentos
            </button>

            <button onclick="mostrarSeccion('otra')" class="menu-btn">
                Proveedores
            </button>

            <button onclick="mostrarSeccion('dashboard')" class="menu-btn">
                Dashboard
            </button>

        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="contenido">

            <!-- SECCION TABLA -->
            <div id="seccion-alimentos">

                <h1 style=" margin-bottom: 10px;">Tabla de Alimentos</h1>

                <div style="margin-bottom:20px; text-align:center;">
                    <input type="text" id="busqueda" placeholder="Buscar alimento por nombre..." style="
                        padding:10px;
                        width:300px;
                        border-radius:6px;
                        border:1px solid #ccc;
                        outline:none;
                    " onkeyup="cargarTabla(1)">
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Proveedor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaBody"></tbody>
                </table>

                <div id="paginacion" style="text-align:center; margin-top:20px;"></div>

                <div class="add-container">
                    <button class="btn agregar" id="btnAgregar">Agregar</button>
                </div>

            </div>

            <!-- Proveedores -->
            <div id="seccion-proveedores" style="display:none;">

                <h1 style=" margin-bottom: 10px;">Gestión de Proveedores</h1>

                <input type="text" id="busquedaProveedores" placeholder="Buscar proveedor por nombre..." style="
                        margin-bottom:20px;
                        padding:10px;
                        width:300px;
                        border-radius:6px;
                        border:1px solid #ccc;
                        outline:none;
                    " onkeyup="cargarProveedores(1)">

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaProveedores"></tbody>

                </table>

                <div id="paginacionProveedores" style="margin-top:20px; margin-bottom: 30px;"></div>

                <button class="btn agregar" onclick="abrirModalProveedor()">
                    Agregar
                </button>

            </div>

            <div id="seccion-dashboard" style="display:none;">

                <div class="dashboard-wrapper">

                    <h1>Dashboard</h1>

                    <div class="dashboard">

                        <div class="card">
                            <h3>Total Alimentos</h3>
                            <p id="totalAlimentos">0</p>
                        </div>

                        <div class="card">
                            <h3>Total Proveedores</h3>
                            <p id="totalProveedores">0</p>
                        </div>

                        <div class="card">
                            <h3>Precio Promedio</h3>
                            <p id="precioPromedio">0</p>
                        </div>

                    </div>

                    <h2 style="margin:20px;">Alimentos por tipo</h2>

                    <table>
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody id="tablaEstadisticas"></tbody>
                    </table>

                    <h2 style="margin:20px;">Gráficos</h2>

                    <div class="charts">
                        <canvas id="graficoTipos"></canvas>
                        <canvas id="graficoRelacion"></canvas>
                    </div>

                </div>
                <div class="card" style=" background:#fff;
                padding:50px;
                border-radius:10px;
                box-shadow:0px 2px 10px rgba(0,0,0,0.1);
                width: 500px;
                height: 300px;
                text-align:center;
                margin-top:30px;
                margin-left:500px;">
                    <h3>Productos por proveedor</h3>
                    <canvas id="graficoProveedores"></canvas>
                </div>
            </div>

        </div>




    </div>
    <!-- ======================
    MODAL 
 ======================== -->
    <div id="modalFormulario" class="modal">
        <div class="modal-contenido">

            <h2>Alimento</h2>

            <form id="formAlimento">

                <input type="hidden" name="id">

                <div class="grupo">
                    <label>Nombre</label>
                    <input type="text" name="name" required>
                </div>

                <div class="grupo">
                    <label>Tipo</label>
                    <input type="text" name="type" required>
                </div>

                <div class="grupo">
                    <label>Precio</label>
                    <input type="number" step="0.01" name="price" required>
                </div>

                <label>Proveedor</label>
                <select name="proveedor_id" id="proveedorSelect">
                    <option value="">Seleccione proveedor</option>
                </select>

                <div class="grupo">
                    <div class="acciones-form">
                        <button type="submit" class="btn agregar">Guardar</button>
                        <button type="button" class="btn eliminar" id="cancelar">Cancelar</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div id="modalProveedor" class="modal">

        <div class="modal-contenido">

            <h2>Proveedor</h2>

            <form id="formProveedor">

                <input type="hidden" name="id" id="idProveedor">
                <div class="grupo">

                    <label>Nombre</label>
                    <input type="text" name="name" required>
                </div>
                <div class="grupo">
                    <label>Empresa</label>
                    <input type="text" name="company" required>
                </div>
                <div class="grupo">
                    <label>Teléfono</label>
                    <input type="text" name="phone" required>
                </div>

                <div class="acciones-form">

                    <button type="submit" class="btn agregar">
                        Guardar
                    </button>

                    <button type="button" class="btn cancelar" onclick="cerrarModalProveedor()">
                        Cancelar
                    </button>

                </div>

            </form>

        </div>

    </div>

    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>