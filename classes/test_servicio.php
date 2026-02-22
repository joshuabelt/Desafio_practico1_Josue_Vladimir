<?php
require_once 'service.class.php';
require_once 'quote.class.php';

try {
    echo "--- INICIANDO PRUEBA DE COTIZADOR ---\n";

    // 1. Creamos algunos servicios de ejemplo (Simulando el catálogo)
    $s1 = new Service(1, "Desarrollo web", "Creación de páginas o aplicaciones web", 600, "Desarrollo de aplicaciones");
    $s2 = new Service(2, "Arquitectura Cloud", "Diseño y migración de servidores físicos a la nube", 1500, "Infraestructura y Cloud");
    $s3 = new Service(3, "Ciencia de datos", "Analísis de grandes volumenes de datos para predecir tendencias", 2000, "Datos e inteligencia artificial");

    // 2. Iniciamos una nueva cotización
    $miCotizacion = new Quote("Josué Beltrán");

    // 3. Agregamos servicios (Aquí probamos la lógica de acumulación)
    $miCotizacion->agregarItem($s1, 1); 
    $miCotizacion->agregarItem($s2, 1); 
    $miCotizacion->agregarItem($s3, 2); 

    // 4. Generamos el resultado final
    $resultado = $miCotizacion->generar();

    // 5. Mostramos los resultados en pantalla (Formato legible)
    echo "Código: " . $resultado['codigo'] . "\n";
    echo "Cliente: " . $resultado['cliente'] . "\n";
    echo "-----------------------------------\n";
    echo "Subtotal: $" . $resultado['subtotal'] . "\n";
    echo "Descuento aplicado: -$" . $resultado['descuento'] . "\n";
    echo "IVA (15%): $" . $resultado['iva'] . "\n";
    echo "TOTAL FINAL: $" . $resultado['total'] . "\n";
    echo "-----------------------------------\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}