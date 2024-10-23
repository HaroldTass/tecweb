<?php
include_once 'database.php';

$id = $_POST['id'];

$query = "SELECT * FROM productos WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

$response = array();
if ($result->num_rows > 0) {
    $response = $result->fetch_assoc();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Producto no encontrado';
}

echo json_encode($response);
?>
