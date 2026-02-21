<?php
require_once 'service.class.php';

try {
    echo "--- Iniciando Pruebas de la Clase Servicio ---\n\n";

    // 1. Instanciar un servicio (Crear el objeto)
    $servicio1 = new Service(1, "Migración a la nube", "Mover archivos y sistemas a la nube", 50.00, "Servicio de infraestructura y cloud");

    // 2. Probar Getters
    echo "Id servicio: " . $servicio1->getId() . "\n";
    echo "Servicio creado: " . $servicio1->getNombre() . "\n";
    echo "Categoría: " . $servicio1->getCategoria() . "\n";
    echo "Precio base: " . $servicio1->getPrecioFormateado() . "\n";

    // 3. Probar Modificación (Setter)
    echo "\nActualizando precio...\n";
    $servicio1->setPrecio(55.50);
    echo "Nuevo precio: " . $servicio1->getPrecioFormateado() . "\n";

    // 4. Probar Validación (El momento de la verdad)
    echo "\nIntentando asignar un precio negativo (esto debería fallar):\n";
    $servicio1->setPrecio(-10.00); 

} catch (Exception $e) {
    // Si la clase detecta el error, saltará aquí
    echo "ERROR CAPTURADO CORRECTAMENTE: " . $e->getMessage() . "\n";
}

echo "\n--- Fin de las pruebas ---";
?>