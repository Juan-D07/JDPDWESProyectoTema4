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


try {
    //conexion correcta
    //                          hostname, usuario, contraseña, base de datos
     $conexionMYSQLi = new mysqli("10.199.9.114", "userJDPDWESProyectoTema4", "paso", "DBJDPDWESProyectoTema4");
     echo "Conectado a MariaDB con MYSQLi<br/>";
     echo $conexionMYSQLi->server_info ."<br/>";
} catch (mysqli_sql_exception $e) {
    echo "Conexion con la bases de datos fallida: ". $e->getMessage();
    echo "Codigo de error ". $e->getCode()."<br/>";
}
try {
    //conexion incorrecta
    $conexionMYSQLi = new mysqli("10.199.9.114", "UsuarioIncorrecto", "paso", "DBJDPDWESProyectoTema4");

} catch (mysqli_sql_exception $e) {
    echo "Conexion con la bases de datos fallida: ". $e->getMessage();
    echo "Codigo de error ". $e->getCode()."<br/>";
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