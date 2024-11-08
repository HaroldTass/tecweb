<?php
include_once 'database.php';

$name = $_POST['name'];
$response = array('exists' => false);

$query = "SELECT id FROM productos WHERE nombre = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('s', $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $response['exists'] = true;
}

echo json_encode($response);
?>