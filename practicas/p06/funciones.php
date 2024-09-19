<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Secuencia</title>
</head>
<body>
<h2>Ejercicio 2</h2>
    <p>Generar una secuencia de números aleatorios hasta obtener una secuencia impar-par-impar.</p>

    <p>Haz clic en el botón para generar una secuencia de números aleatorios hasta obtener una secuencia impar-par-impar.</p>

    <form method="post" action="">
        <input type="submit" value="Generar Secuencia">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $secuencias = [];
        $iteraciones = 0;

        while (true) {
            $num1 = rand(1, 1000);
            $num2 = rand(1, 1000);
            $num3 = rand(1, 1000);

            $secuencias[] = [$num1, $num2, $num3];
            $iteraciones++;

            if ($num1 % 2 != 0 && $num2 % 2 == 0 && $num3 % 2 != 0) {
                break;
            }
        }

        echo "Número de iteraciones: " . $iteraciones . "<br>";
        echo "Cantidad de números generados: " . ($iteraciones * 3) . "<br>";
        echo "Secuencias generadas:<br>";

        echo "<table border='1'>";
        echo "<tr><th>Iteración</th><th>Número 1</th><th>Número 2</th><th>Número 3</th></tr>";
        foreach ($secuencias as $index => $secuencia) {
            echo "<tr><td>" . ($index + 1) . "</td><td>" . $secuencia[0] . "</td><td>" . $secuencia[1] . "</td><td>" . $secuencia[2] . "</td></tr>";
        }
        echo "</table>";
    }
    ?>

<h2>Ejercicio 3 - Ciclo Do-While</h2>
    <p>Encontrar el primer número entero aleatorio que sea múltiplo de un número dado.</p>

    <form method="get" action="">
        <label for="multiplo">Ingresa un número:</label>
        <input type="number" id="multiplo" name="multiplo" required>
        <input type="submit" value="Encontrar Múltiplo">
    </form>

    <?php
    if (isset($_GET['multiplo'])) {
        $multiplo = $_GET['multiplo'];
        $num = 0;
        $iteraciones = 0;

        do {
            $num = rand(1, 1000);
            $iteraciones++;
        } while ($num % $multiplo != 0);

        echo "Número encontrado: " . $num . "<br>";
        echo "Número de iteraciones: " . $iteraciones . "<br>";
    }
    ?>

<h2>Ejercicio 4</h2>
    <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la 'a' a la 'z'.</p>
    <?php
    $arreglo = [];
    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i);
    }

    echo "<table border='1'>";
    echo "<tr><th>Índice</th><th>Valor</th></tr>";
    foreach ($arreglo as $key => $value) {
        echo "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
    }
    echo "</table>";
    ?>

<h2>Ejercicio 5</h2>
    <p>Identificar a una persona de sexo "femenino" cuya edad esté entre 18 y 35 años.</p>
    <form method="post" action="">
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required>
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="femenino">Femenino</option>
            <option value="masculino">Masculino</option>
        </select>
        <input type="submit" value="Verificar">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $edad = $_POST['edad'];
        $sexo = $_POST['sexo'];

        if ($sexo == 'femenino' && $edad >= 18 && $edad <= 35) {
            echo '<h3>Bienvenida, usted está en el rango de edad permitido.</h3>';
        } else {
            echo '<h3>Error: No cumple con los requisitos.</h3>';
        }
    }
    ?>

<h2>Ejercicio 6</h2>
<p>Crea en código duro un arreglo asociativo que sirva para registrar el parque vehicular de
una ciudad.</p>
<h2>Consulta de Vehículos</h2>
    <form method="post" action="">
        <label for="matricula">Matrícula del Auto:</label>
        <input type="text" id="matricula" name="matricula">
        <input type="submit" name="consulta" value="Consultar por Matrícula">
        <input type="submit" name="consulta" value="Consultar Todos">
    </form>

    <?php
    $vehiculos = [
        'UBN6338' => [
            'Auto' => [
                'marca' => 'HONDA',
                'modelo' => 2020,
                'tipo' => 'camioneta'
            ],
            'Propietario' => [
                'nombre' => 'Alfonzo Esparza',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'C.U., Jardines de San Manuel'
            ]
        ],
        'UBN6339' => [
            'Auto' => [
                'marca' => 'MAZDA',
                'modelo' => 2019,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Ma. del Consuelo Molina',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => '97 oriente'
            ]
        ],
        // Agrega más registros según sea necesario
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $consulta = $_POST['consulta'];
        if ($consulta == 'Consultar por Matrícula') {
            $matricula = $_POST['matricula'];
            if (isset($vehiculos[$matricula])) {
                echo '<h3>Información del Vehículo</h3>';
                echo '<table border="1">';
                echo '<tr><th>Campo</th><th>Valor</th></tr>';
                foreach ($vehiculos[$matricula] as $categoria => $datos) {
                    foreach ($datos as $campo => $valor) {
                        echo "<tr><td>$categoria - $campo</td><td>$valor</td></tr>";
                    }
                }
                echo '</table>';
            } else {
                echo '<h3>Error: Matrícula no encontrada.</h3>';
            }
        } elseif ($consulta == 'Consultar Todos') {
            echo '<h3>Información de Todos los Vehículos</h3>';
            echo '<table border="1">';
            echo '<tr><th>Matrícula</th><th>Campo</th><th>Valor</th></tr>';
            foreach ($vehiculos as $matricula => $info) {
                foreach ($info as $categoria => $datos) {
                    foreach ($datos as $campo => $valor) {
                        echo "<tr><td>$matricula</td><td>$categoria - $campo</td><td>$valor</td></tr>";
                    }
                }
            }
            echo '</table>';
        }
    }
    ?>


</body>
</html>
