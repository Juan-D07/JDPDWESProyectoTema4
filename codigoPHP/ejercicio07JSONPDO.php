<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Tema 4 · Juan Miguel Dominguez </title>
        <link rel="stylesheet" href="../webroot/css/ejercicios.css">
        <style>
            input{
                margin: 10px 5px;
            }

            .advertancia{
                font-size: 12px;
                color:gray;
                margin-top: 12px;                
            }
            table{
                border-collapse: collapse;
            }
            td{
                width:300px;
                border: 1px solid black;
                text-align: center;
            }
            .titulo{
                background-color: orange;               
            }
            tr:not(.titulo){
                td:nth-child(4){
                    text-align: right;
                }
                td:nth-child(2){
                    text-align: left;
                }
            }
        </style>

    </head>
    <body>
        <header>
            <h2> UT4: TÉCNICAS DE ACCESO A DATOS EN PHP</h2>
        </header>

        <main>
            <?php

                        // Calculamos la ruta del archivo JSON en la carpeta tmp
                        $rutaFicheroJSON = $_SERVER["DOCUMENT_ROOT"] . '/MDCDWESProyectoTema4/tmp/departamentos.json';

                        // Comprobamos si el archivo existe
                        if (file_exists($rutaFicheroJSON)) {

                            // Leetodo el contenido del archivo JSON como una unica cadena de texto
                            // https://www.php.net/manual/es/function.file-get-contents.php
                            $textoJSON = file_get_contents($rutaFicheroJSON);

                            // Convierte el texto JSON a un array asociativo de PHP
                            // https://www.php.net/manual/es/function.json-decode.php
                            $aDepartamentos = json_decode($textoJSON, true);

                            // Verificamos que el JSON no este vacio y sea un array valido
                            if (is_array($aDepartamentos) && count($aDepartamentos) > 0) {

                                require_once '../config/configDBPDO.php';

                                try {
                                    // Instanciacion del objeto PDO
                                    $miDB = new PDO(HOST, USER, PASS);

                                    // Iniciamos la transaccion para asegurar que o se importan todos, o ninguno
                                    $miDB->beginTransaction();

                                    // Preparamos la consulta de insercion
                                    $sqlInsert = 'INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES (:CodDepartamento, :DescDepartamento, :FechaCreacionDepartamento, :VolumenDeNegocio, :FechaBajaDepartamento)';
                                    $sentenciaPreparada = $miDB->prepare($sqlInsert);

                                    $registrosImportados = 0;

                                    // Recorremos cada departamento del array PHP
                                    foreach ($aDepartamentos as $departamento) {

                                        // Extraemos los valores. Si FechaBaja esta vacia, le asignamos null.
                                        $codigo = $departamento['CodDepartamento'];
                                        $descripcion = $departamento['DescDepartamento'];
                                        $fecha = $departamento['FechaCreacionDepartamento'];
                                        $volumen = $departamento['VolumenDeNegocio'];
                                        $fechaBaja = (!empty($departamento['FechaBajaDepartamento'])) ? $departamento['FechaBajaDepartamento'] : null;

                                        // Ejecutamos la consulta preparada pasando un array asociativo con los nombres de los campos
                                        $sentenciaPreparada->execute([
                                            ':CodDepartamento' => $codigo,
                                            ':DescDepartamento' => $descripcion,
                                            ':FechaCreacionDepartamento' => $fecha,
                                            ':VolumenDeNegocio' => $volumen,
                                            ':FechaBajaDepartamento' => $fechaBaja
                                        ]);

                                        $registrosImportados++;
                                    }

                                    // Si el bucle termina sin errores, confirmamos la transacción
                                    $miDB->commit();

                                    echo "<div class='mensaje-exito'>";
                                    echo "<h3>Importación completada con éxito.</h3>";
                                    echo "<p>Se han importado <b>{$registrosImportados}</b> departamentos desde el archivo JSON a la base de datos.</p>";
                                    echo "</div>";
                                } catch (PDOException $miExceptionPDO) {
                                    // Si ocurre un error, deshacemos todos los cambios
                                    $miDB->rollBack();

                                    echo "<div class='error'>";
                                    echo "<h3 style='margin-top:0;'>Error al importar en la base de datos.</h3>";
                                    echo "<p>La transaccion ha sido cancelada. Ningun registro ha sido importado.</p>";
                                    echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
                                    echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
                                    echo "</div>";
                                } finally {
                                    unset($miDB);
                                }
                            }
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