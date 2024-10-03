<?php
$nombre = $_POST['nombre'];
$marca  = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$detalles = $_POST['detalles'];
$unidades = $_POST['unidades'];
$imagen   = $_POST['imagen']; // Asumiendo que la ruta de la imagen se introduce directamente en el formulario

/** SE CREA EL OBJETO DE CONEXION */
@$link = new mysqli('localhost', 'root', 'Kamaleon_2002', 'marketzone');	

/** comprobar la conexión */
if ($link->connect_errno) 
{
    die('Falló la conexión: '.$link->connect_error.'<br/>');
    /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
}

/** Validar que el nombre, modelo y marca no existan ya en la BD */
$sql = "SELECT * FROM productos WHERE nombre='$nombre' AND marca='$marca' AND modelo='$modelo'";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    echo "Error: El producto ya existe en la base de datos.";
} else {
    /** Insertar datos en la BD con eliminado = 0 */
    $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado)
            VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen', 0)";

    if ($link->query($sql) === TRUE) {
        echo "Producto insertado con ID: ".$link->insert_id."<br>";
        echo "Nombre: $nombre<br>";
        echo "Marca: $marca<br>";
        echo "Modelo: $modelo<br>";
        echo "Precio: $precio<br>";
        echo "Detalles: $detalles<br>";
        echo "Unidades: $unidades<br>";
        echo "Ruta de la imagen: $imagen<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}

$link->close();
?>
