<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 3</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    ?>


<br>
<h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <p>$a = “ManejadorSQL”;
<br>$b = 'MySQL’;
<br>$c = &$a;</p>

    <?php
 $a = "ManejadorSQL";
 $b = 'MySQL';
 $c = &$a;

 echo "a: $a".'<br>'; 
 echo "b: $b".'<br>'; 
 echo "c: $c".'<br>'; 

 echo '<br>';

 $a = "PHP server";
 $b = &$a;

 echo "a: $a".'<br>'; 
 echo "b: $b".'<br>';
 echo "En el segundo bloque se observó un cambio a la información de las variables más recientes".'<br>';


     
    ?>
<br>
<h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación,
verificar la evolución del tipo de estas variables (imprime todos los componentes de los
arreglo):</p>
    <p>$a = “PHP5”;
    <br>
$z[] = &$a;<br>
$b = “5a version de PHP”;<br>
$c = $b*10;<br>
$a .= $b;<br>
$b *= $c;<br>
$z[0] = “MySQL”;</p>

<?php
$a = "PHP5";
echo "a: $a"; 
 echo '<br>';


$z[] = &$a;
echo "z[0]: $z[0]"; 
 echo '<br>';


$b = "5a version de PHP";
echo "b: $b"; 
 echo '<br>';

$b = 5;
$c = $b * 10;
echo "c: $c"; 
 echo '<br>';


$a .= " version de PHP";
echo "a: $a"; 
 echo '<br>';


$b *= $c;
echo "b: $b"; 
 echo '<br>';


$z[0] = "MySQL";
echo "z[0]: $z[0]";  
?>

<br>
<h2>Ejercicio 4</h2>
    <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de
    la matriz $GLOBALS o del modificador global de PHP.</p>

<?php
$a = "PHP5";
$GLOBALS['a'] = $a;
echo "a: " . $GLOBALS['a'];
 echo '<br>';

$z[] = &$GLOBALS['a'];
echo "z[0]: " . $GLOBALS['a']; 
 echo '<br>';


$b = "5a version de PHP";
$GLOBALS['b'] = $b;
echo "b: " . $GLOBALS['b']; 
 echo '<br>';



$GLOBALS['b'] = 5;
$GLOBALS['c'] = $GLOBALS['b'] * 10;
echo "c: " . $GLOBALS['c'];
 echo '<br>';


$GLOBALS['a'] .= " version de PHP";
echo "a: " . $GLOBALS['a'];
 echo '<br>';


$GLOBALS['b'] *= $GLOBALS['c'];
echo "b: " . $GLOBALS['b'];
 echo '<br>';


$z[0] = "MySQL";
echo "z[0]: " . $z[0];

?>

<br>
<h2>Ejercicio 5</h2>
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>
    <p>$a = “7 personas”;<br>
$b = (integer) $a;<br>
$a = “9E3”;<br>
$c = (double) $a;<br>
</p>
<?php
$a = "7 personas";
echo "Valor de \$a: $a<br>";

$b = (integer) $a;
echo "Valor de \$b: $b<br>"; 

$a = "9E3";
echo "Valor de \$a: $a<br>"; 

$c = (double) $a;
echo "Valor de \$c: $c<br>";

?>

<br>
<h2>Ejercicio 6</h2>
    <p>Dar y comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f y muéstralas
usando la función var_dump(<datos>).
Después investiga una función de PHP que permita transformar el valor booleano de $c y $e
en uno que se pueda mostrar con un echo:</p>

<p>
$a = “0”;<br>
$b = “TRUE”;<br>
$c = FALSE;<br>
$d = ($a OR $b);<br>
$e = ($a AND $c);<br>
$f = ($a XOR $b);<br>
</p>

<?php
$a = "0";
$b = "TRUE";
$c = FALSE;
$d = ($a OR $b);
$e = ($a AND $c);
$f = ($a XOR $b);

var_dump($a); 
echo '<br>';
var_dump($b);
echo '<br>'; 
var_dump($c);
echo '<br>'; 
var_dump($d);
echo '<br>'; 
var_dump($e);
echo '<br>'; 
var_dump($f);
echo '<br>'; 


echo $c ? 'true' : 'false'; 
echo '<br>';
echo $e ? 'true' : 'false'; 

?>

<br>
<h2>Ejercicio 7</h2>
    <p>Usando la variable predefinida $_SERVER, determina lo siguiente:
a. La versión de Apache y PHP,
b. El nombre del sistema operativo (servidor),
c. El idioma del navegador (cliente).</p>



<?php
// a. La versión de Apache y PHP
$apache_version = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'No disponible';
$php_version = phpversion();

// b. El nombre del sistema operativo (servidor)
$server_os = PHP_OS;

// c. El idioma del navegador (cliente)
$browser_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'No disponible';

// Mostrar los resultados con saltos de línea
echo "Versión de Apache: $apache_version";
echo '<br>';
echo "Versión de PHP: $php_version";
echo '<br>';
echo "Sistema operativo del servidor: $server_os";
echo '<br>';
echo "Idioma del navegador: $browser_language";


?>
</body>
</html>