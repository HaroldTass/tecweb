<?php
/* MySQL Conexión */
$link = mysqli_connect('localhost', 'root', 'Kamaleon_2002', 'marketzone');
// Chequea conexión
if($link === false){
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

// Capturar datos desde el formulario
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$detalles = $_POST['detalles'];
$unidades = $_POST['unidades'];
$imagen = $_POST['imagen'];
$productId = $_POST['id'];

// Ejecutar la actualización del registro
$sql = "UPDATE productos SET 
    nombre='$nombre', 
    marca='$marca', 
    modelo='$modelo', 
    precio=$precio, 
    detalles='$detalles', 
    unidades=$unidades, 
    imagen='$imagen' 
    WHERE id=$productId";

if(mysqli_query($link, $sql)){
    echo "Producto actualizado.<br>";
    echo "<a href='get_productos_xhtml_v2.php'>Ver Productos XHTML</a><br>";
    echo "<a href='get_productos_vigentes_v2.php'>Ver Productos Vigentes</a>";
} else {
    echo "ERROR: No se ejecutó $sql. " . mysqli_error($link);
}

// Cierra la conexión
mysqli_close($link);
?>
