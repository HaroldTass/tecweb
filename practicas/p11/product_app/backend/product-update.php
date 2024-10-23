<?php
include_once 'database.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$id = $data['id'];
$nombre = $data['nombre'];
$marca = $data['marca'];
$modelo = $data['modelo'];
$precio = $data['precio'];
$detalles = $data['detalles'];
$unidades = $data['unidades'];
$imagen = $data['imagen'];

$response = array();

// Verificar si el nombre del producto ya existe en otro registro
$checkQuery = "SELECT id FROM productos WHERE nombre = '$nombre' AND id != $id";
$checkResult = mysqli_query($conexion, $checkQuery);

if (mysqli_num_rows($checkResult) > 0) {
    // Si el nombre ya existe en otro registro, enviar un mensaje de error
    $response['status'] = 'error';
    $response['message'] = 'El nombre del producto ya existe. Por favor, elija otro nombre.';
    echo json_encode($response);
    exit();
}

// Si el nombre no existe, realizar la actualización
$query = "UPDATE productos SET nombre = '$nombre', marca = '$marca', modelo = '$modelo', precio = $precio, detalles = '$detalles', unidades = $unidades, imagen = '$imagen' WHERE id = $id";

$result = mysqli_query($conexion, $query);

if ($result) {
    $response['status'] = 'success';
    $response['message'] = 'Producto actualizado correctamente';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error al actualizar el producto';
}

echo json_encode($response);
?>
