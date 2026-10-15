<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Tema 3 · Juan Miguel Dominguez </title>
    <link rel="stylesheet" href="../webroot/css/ejercicios.css">
</head>
<body>
  <header>
      <h2> UT3: CARACTERÍSTICAS DEL LENGUAJE PHP</h2>
  </header>
  <main>
      
<?php

require_once '../config/configDB00.php';
//$opcionesDriver= [
//    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
//    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//    PDO::ATTR_EMULATE_PREPARES   => false
//];


try {
    //conexion correcta
     $conexionPDO = new PDO(HOST, USER, PASS);
     echo "Conectado a MariaDB <br/>";
     echo $conexionPDO->getAttribute(PDO::ATTR_CONNECTION_STATUS)."<br/>";
     echo $conexionPDO->getAttribute(PDO::ATTR_FETCH_TABLE_NAMES)."<br/>";
     echo $conexionPDO->getAttribute(PDO::ATTR_SERVER_VERSION)."<br/>";
} catch (PDOException $e) {
    echo "ERROR ". e->getMessage()."<br/>";
}
try {
    //conexion incorrecta
     $conexion = new PDO(HOST, "usuarioIncorrecto", PASS);

} catch (PDOException $e) {
    error_log("Conexion con la bases de datos fallida: ". $e->getMessage());
    echo "ERROR ". $e->getMessage()."<br/>";
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