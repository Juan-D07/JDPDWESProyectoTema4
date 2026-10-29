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
$archivo = '../codigoPHP/ejercicio05PDO.php';
 
if ($archivo && file_exists($archivo)) {
    echo "<h2>Viendo el codigo de: " . htmlspecialchars($archivo) . "</h2>";
    // funcion nativa de PHP, lee el archivo y lo imprime con colores.
    highlight_file($archivo);
} else {
    echo "<h2>Error: El archivo no existe.</h2>";
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