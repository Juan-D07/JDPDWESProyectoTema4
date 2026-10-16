<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Tema 4 · Juan Miguel Dominguez </title>
    <link rel="stylesheet" href="../webroot/css/ejercicios.css">
</head>
<body>
  <header>
      <h2> UT4: TÉCNICAS DE ACCESO A DATOS EN PHP</h2>
  </header>
  <main>
      
<?php

//require_once '../config/configDB00.php';
//$conexionPDO = new PDO(HOST, USER, PASS);

// opciones de driver, que se pueden inicializar con la conexion pdo
//$opcionesDriver= [
//    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
//    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//    PDO::ATTR_EMULATE_PREPARES   => false
//];


try {
    //conexion correcta
    //                      dsn, usuario, contraseña
     $miDB = new PDO("mysql:host=10.199.9.114;dbname=DBJDPDWESProyectoTema4;", "userJDPDWESProyectoTema4", "paso");
     $miDB->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
     
     $atributosPDO=[
        "ATTR_AUTOCOMMIT",
        "ATTR_ERRMODE",
        "ATTR_SERVER_VERSION",
        "ATTR_CLIENT_VERSION",
        "ATTR_SERVER_INFO",
        "ATTR_CONNECTION_STATUS",
        "ATTR_CASE",
        "ATTR_ORACLE_NULLS",
        "ATTR_PERSISTENT",
        "ATTR_STATEMENT_CLASS",
        "ATTR_DRIVER_NAME",
        "ATTR_STRINGIFY_FETCHES",
        "ATTR_EMULATE_PREPARES",
        "ATTR_DEFAULT_FETCH_MODE",
        "ATTR_DEFAULT_STR_PARAM"];
     
     echo "<h4>Primera Conexion a MariaDB</h4> <br/>";
     echo '<ul>';
     foreach ($atributosPDO as $valor) {
         try{
             echo"<li><strong> $valor: </strong>". $miDB->getAttribute(constant("PDO::".$valor))."</li>";
         } catch (PDOException $e) {
            echo"<li><strong> $valor: </strong> Error->". $e->getMessage()."</li>";
         }
         
     }
     echo '</ul>';
} catch (PDOException $e) {
    echo "<span style='color:red;'> Codigo de error: ". $e->getCode()." <span><br/>";
    echo "<span style='color:red;'> Mensaje de error: ". $e->getMessage()." <span><br/>";
}


echo "<h4>Segunda Conexion a MariaDB</h4> <br/>";
try {
    //conexion incorrecta
    
    $conexion = new PDO("mysql:host=10.199.9.114;dbname=DBJDPDWESProyectoTema4;", "usuarioIncorrecto","paso");

} catch (PDOException $e) {
    echo "<span style='color:red;'> Codigo de error: ". $e->getCode()." <span><br/>";
    echo "<span style='color:red;'> Mensaje de error: ". $e->getMessage()." <span><br/>";
}
?>
  </main>

  <footer>
    <address>
      <p class="foo-txt">
        © 2026 <span ><a class="miweb-link" href="../../JDPDWESProyectoDWES/indexProyectoDWES.php" >Juan Miguel Dominguez</a></span> Todos los derechos reservados.
        <a href="https://github.com/Juan-D07/JDPDWESProyectoTema4" target="_blank"> <img class="github" src="../webroot/images/github.png"  alt="Github logo"/></a>
        <a href="../indexProyectoTema4.php"> <img class="casa" src="../webroot/images/casa.png"  alt="Casa logo"/></a>
      </p>
    </address>
  </footer>
  
</body>
</html>