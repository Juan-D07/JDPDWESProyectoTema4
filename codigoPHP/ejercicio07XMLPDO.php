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
            // Archivo con las variables de conexion a la base de datos
            require_once '../config/configDBPDO.php';
            if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/JDPDWESProyectoTema4/tmp/departamentos.xml')) {

                try {
                    // Instanciacion del objeto PDO para conectar a MariaDB
                    $miDB = new PDO(DSN, USER, PASS);

                    // Instaciamos el documento DOM y cargamos el archivo
                    $documentoXML = new DOMDocument();
                    $documentoXML->load($_SERVER["DOCUMENT_ROOT"] . '/JDPDWESProyectoTema4/tmp/departamentos.xml');

                    //Obtenemos una lista con los elementos
                    $aDepartamentos = $documentoXML->getElementsByTagName('departamento');
                    

                    // Si hay un elemento o mas, recorre la lista de deparatamentos
                    if ($aDepartamentos->length > 0) {
                        // comenzamos una transaccion
                        $miDB->beginTransaction();
                        
                        //insercion con consulta preparada
                        //iniciamos consulta dentro de un heredoc
                        $sqlInsert = <<<sql
                        INSERT INTO T02_Departamento VALUES (
                        :codDepartamento,
                        :descDepartamento,
                        :fechaCreacionDepartamento,
                        :volumenDeNegocio,
                        :fechaBajaDepartamento)
                        sql;
                        //preparamos la insercion
                        $insercionDepartamento = $miDB->prepare($sqlInsert);


                        // Recorremos los departamentos del documento xml
                        foreach ($aDepartamentos as $departamento) {
                            
                            // extraemos el valor de cada elemento del departamento
                            $codDepartamento = $departamento->getElementsByTagName('CodDepartamento')->item(0)->nodeValue;
                            $descDepartamento = $departamento->getElementsByTagName('DescDepartamento')->item(0)->nodeValue;
                            $fechaCreacionDepartamento = $departamento->getElementsByTagName('FechaCreacionDepartamento')->item(0)->nodeValue;
                            $volumenDeNegocio = $departamento->getElementsByTagName('VolumenDeNegocio')->item(0)->nodeValue;
                            $nullFechaBaja = $departamento->getElementsByTagName('FechaBajaDepartamento')->item(0);
                            
                            //comprobacion del elemento fecha baja
                            //                        si exisiste / no es null  &&   que su valor no sea vacio  return valor                                                     
                            $fechaBajaDepartamento = ($nullFechaBaja && trim($nullFechaBaja->nodeValue) !== '') ? $nullFechaBaja->nodeValue : null;

                            // Ejecutamos la consulta preparada pasando el array asociativo con los nombres de los campos
                            $insercionDepartamento->execute([
                                ':codDepartamento' => $codDepartamento,
                                ':descDepartamento' => $descDepartamento,
                                ':fechaCreacionDepartamento' => $fechaCreacionDepartamento,
                                ':volumenDeNegocio' => $volumenDeNegocio,
                                ':fechaBajaDepartamento' => $fechaBajaDepartamento
                            ]);
                        }
                        //Ejecutamos los inserts 
                        $miDB->commit();
                        
                        // Mostramos el mensaje y el enlace web
                        echo "<h3>Importacion completada con exito.</h3>";
                        echo "<p>Se han importado $aDepartamentos->length departamentos del archivo guardado en: <b>" . $_SERVER['DOCUMENT_ROOT'] . "/JDPDWESProyectoTema4/tmp/departamentos.xml</b></p>";
                        echo "<a href='ejercicio02PDO.php' target='_blank' style='color: #green; font-weight: bold; text-decoration: underline;'>Ver Tabla</a>";
                    }
                } catch (PDOException $miExceptionPDO) {
                    // Captura errores de PDO
                    //si hay un error deshace los cambios con rollback
                    $miDB->rollBack();
                    echo "<div class='error'>";
                    echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
                    echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
                    echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
                    echo "</div>";
                } finally {
                    // Cierra la conexión a la base de datos
                    unset($miDB);
                }
            } else {
                echo "<p>El archivo <b>" . $_SERVER['DOCUMENT_ROOT'] . "/JDPDWESProyectoTema4/tmp/departamentos.xml</b> no existe</p>";

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