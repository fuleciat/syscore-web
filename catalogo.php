<?php
// ============================================================
// catalogo.php - Catálogo dinámico SysCore Solutions
// Recupera los artículos desde el Servidor de BBDD (10.0.0.10)
// BD: almacen  |  Tabla: ARTICULO
// ASIR - Proyecto Intermodular ISO - Fran Ulecia
// ============================================================

// --- Datos de conexión al servidor de base de datos remoto ---
$db_host = "10.0.0.10";       // Servidor de Almacenamiento (BBDD)
$db_user = "webuser";         // Usuario con permiso SELECT
$db_pass = "WebPass2026";     // Contraseña del usuario web
$db_name = "almacen";         // Base de datos importada

// --- Conexión a MySQL ---
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SysCore Solutions - Catálogo (BBDD)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-white">

    <header>
        <div class="container nav-container">
            <div class="logo-container">
                <img src="imagenes/logo.png" alt="Logotipo SysCore Solutions" class="logo-img">
                <div class="logo"><span class="logo-sys">Sys</span>Core<br>Solutions</div>
            </div>
            <div class="menu-toggle">&#9776;</div>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="servicios.html">Servicios</a></li>
                    <li><a href="tienda.html">Tienda</a></li>
                    <li><a href="catalogo.php">Catálogo</a></li>
                    <li><a href="empresa.html">Empresa</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="page-section">
        <div class="container">
            <h2 class="section-title">Catálogo en tiempo real</h2>
            <p>Datos recuperados directamente desde nuestro servidor de base de datos corporativo.</p>

            <?php
            // --- Comprobación de la conexión ---
            if ($conn->connect_error) {
                echo '<p style="color:red;"><strong>Error de conexión con la base de datos:</strong> '
                     . htmlspecialchars($conn->connect_error) . '</p>';
            } else {
                // --- Consulta de los artículos ---
                $sql = "SELECT cod_articulo, nombre, precio_u, stock, licencia FROM ARTICULO ORDER BY cod_articulo";
                $resultado = $conn->query($sql);

                if ($resultado && $resultado->num_rows > 0) {
                    echo '<table class="tabla-catalogo" style="width:100%; border-collapse:collapse; margin-top:2rem;">';
                    echo '<thead><tr>'
                       . '<th style="text-align:left; padding:0.75rem; border-bottom:2px solid #ccc;">Código</th>'
                       . '<th style="text-align:left; padding:0.75rem; border-bottom:2px solid #ccc;">Artículo</th>'
                       . '<th style="text-align:right; padding:0.75rem; border-bottom:2px solid #ccc;">Precio</th>'
                       . '<th style="text-align:center; padding:0.75rem; border-bottom:2px solid #ccc;">Stock</th>'
                       . '<th style="text-align:center; padding:0.75rem; border-bottom:2px solid #ccc;">Licencia</th>'
                       . '</tr></thead><tbody>';

                    // --- Recorremos cada fila de la BBDD ---
                    while ($fila = $resultado->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td style="padding:0.6rem; border-bottom:1px solid #eee;">' . htmlspecialchars($fila['cod_articulo']) . '</td>';
                        echo '<td style="padding:0.6rem; border-bottom:1px solid #eee;">' . htmlspecialchars($fila['nombre']) . '</td>';
                        echo '<td style="padding:0.6rem; border-bottom:1px solid #eee; text-align:right;">' . number_format($fila['precio_u'], 2, ',', '.') . ' &euro;</td>';
                        echo '<td style="padding:0.6rem; border-bottom:1px solid #eee; text-align:center;">' . htmlspecialchars($fila['stock']) . '</td>';
                        echo '<td style="padding:0.6rem; border-bottom:1px solid #eee; text-align:center;">' . htmlspecialchars($fila['licencia']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<p>No se encontraron artículos en la base de datos.</p>';
                }
                $conn->close();
            }
            ?>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container footer-container">
            <div class="footer-brand">
                <div class="logo"><span class="logo-sys">Sys</span>Core Solutions</div>
                <p>Infraestructura tecnológica de alto rendimiento para empresas. Uptime del 99.9% garantizado.</p>
            </div>
            <nav class="footer-nav" aria-label="Navegación pie de página">
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="servicios.html">Servicios</a></li>
                    <li><a href="tienda.html">Tienda</a></li>
                    <li><a href="catalogo.php">Catálogo</a></li>
                    <li><a href="empresa.html">Empresa</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                </ul>
            </nav>
            <p class="footer-copy">&copy; 2025 SysCore Solutions. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>

</html>
