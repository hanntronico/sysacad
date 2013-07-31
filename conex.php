<?php 

// FUNCIÓN DE CONEXIÓN CON LA BASE DE DATOS MYSQL
function conectaDb()
{
    try {
        //$db = new PDO("mysql:host=localhost", "root", "root");
        $db = new PDO('mysql:host=127.0.0.1;dbname=dbsysacad', 'root', 'root');
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
        return($db);
    } catch (PDOException $e) {
        //cabecera("Error grave");
        // print "<p>Error: No puede conectarse con la base de datos.</p>\n";
	    print "<p>Error: " . $e->getMessage() . "</p>\n";
        //pie();
        exit();
    }
}

// EJEMPLO DE USO DE LA FUNCIÓN ANTERIOR
// La conexión se debe realizar en cada página que acceda a la base de datos
$db = conectaDB(); 


?>