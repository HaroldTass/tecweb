<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Función para hacer celdas editables
            function makeEditable(td) {
                td.contentEditable = true;
                td.addEventListener("blur", function() {
                    // Aquí puedes enviar los datos actualizados al servidor si es necesario
                    console.log("Updated value: ", td.textContent);
                });
            }
            
            let table = document.querySelector("table thead tr");
            let th = document.createElement("th");
            th.scope = "col";
            th.textContent = "Modificar";
            table.appendChild(th);

            let rows = document.querySelectorAll("table tbody tr");
            rows.forEach(function(row) {
                let td = document.createElement("td");
                td.textContent = "Editable";
                makeEditable(td);
                row.querySelectorAll('td').forEach(function(cell) {
                    makeEditable(cell);
                });
                row.appendChild(td);
            });
        });
    </script>
</head>
<body>
    <h3>PRODUCTOS</h3>
    <br/>

    <?php
    if(isset($_GET['tope'])) {
        $tope = $_GET['tope'];

        if (!empty($tope)) {
            @$link = new mysqli('localhost', 'root', 'Kamaleon_2002', 'marketzone');

            if ($link->connect_errno) {
                die('Falló la conexión: '.$link->connect_error.'<br/>');
            }

            if ($result = $link->query("SELECT * FROM productos WHERE unidades <= $tope AND eliminado = 0")) {
                echo '<table class="table">';
                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th scope="col">#</th>';
                echo '<th scope="col">Nombre</th>';
                echo '<th scope="col">Marca</th>';
                echo '<th scope="col">Modelo</th>';
                echo '<th scope="col">Precio</th>';
                echo '<th scope="col">Unidades</th>';
                echo '<th scope="col">Detalles</th>';
                echo '<th scope="col">Imagen</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    echo '<tr>';
                    echo '<th scope="row">'.$row['id'].'</th>';
                    echo '<td>'.$row['nombre'].'</td>';
                    echo '<td>'.$row['marca'].'</td>';
                    echo '<td>'.$row['modelo'].'</td>';
                    echo '<td>'.$row['precio'].'</td>';
                    echo '<td>'.$row['unidades'].'</td>';
                    echo '<td>'.utf8_encode($row['detalles']).'</td>';
                    echo '<td><img src="'.$row['imagen'].'" alt="Imagen del producto"></td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';

                $result->free();
            }

            $link->close();
        } else {
            echo '<script>alert("Parámetro \'tope\' no detectado o vacío.");</script>';
        }
    } else {
        echo '<script>alert("Parámetro \'tope\' no detectado.");</script>';
    }
    ?>
</body>
</html>
