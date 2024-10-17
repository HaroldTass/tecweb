<?php
include_once __DIR__.'/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');
if (!empty($producto)) {
    // SE TRANSFORMA EL STRING DEL JSON A OBJETO
    $jsonOBJ = json_decode($producto);

    // SE VERIFICA SI EL PRODUCTO YA EXISTE EN LA BASE DE DATOS
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE nombre = ? AND eliminado = 0");
    $stmt->bind_param('s', $jsonOBJ->nombre);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingProduct = $result->fetch_assoc();

    if ($existingProduct) {
        // EL PRODUCTO YA EXISTE Y NO DEBE SER INSERTADO
        echo json_encode(['status' => 'error', 'message' => 'El producto ya existe.']);
    } else {
        // SE REALIZA LA INSERCIÓN DEL PRODUCTO EN LA BASE DE DATOS
        $stmt = $conexion->prepare("INSERT INTO productos (nombre, precio, unidades, modelo, marca, detalles, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            'sdissss',
            $jsonOBJ->nombre,
            $jsonOBJ->precio,
            $jsonOBJ->unidades,
            $jsonOBJ->modelo,
            $jsonOBJ->marca,
            $jsonOBJ->detalles,
            $jsonOBJ->imagen
        );
        $result = $stmt->execute();

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Producto insertado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar el producto.']);
        }
    }
}
?>
