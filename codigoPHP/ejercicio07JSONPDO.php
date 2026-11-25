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
            require_once '../config/configDBPDO.php';
            //comprobamos si el archivo existe
            if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/JDPDWESProyectoTema4/tmp/departamentos.json')) {

                // Lee todo el contenido del archivo JSON como una cadena de texto
                $textoJSON = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/JDPDWESProyectoTema4/tmp/departamentos.json');

                // Convierte el texto JSON a un array asociativo de PHP
                // https://www.php.net/manual/es/function.json-decode.php
                $aDepartamentos = json_decode($textoJSON, true);
            
                // Verificamos que el JSON no este vacio y sea un array valido
                if (is_array($aDepartamentos) && count($aDepartamentos) > 0) {
                    try {
                                            
                        // Iniciamos la conexion con la base de datos con el objeto PDO
                        $miDB = new PDO(DSN, USER, PASS);
                        // Iniciamos la transaccion para asegurar que o se importan todos, o ninguno
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

                        // Recorremos cada departamento del array PHP
                        foreach ($aDepartamentos as $departamento) {
                        
                            // Extraemos los valores. Si FechaBaja esta vacia, le asignamos null.
                            $codDepartamento = $departamento['CodDepartamento'];
                            $descDepartamento = $departamento['DescDepartamento'];
                            $fechaCreacionDepartamento = $departamento['FechaCreacionDepartamento'];
                            $volumenDeNegocio = $departamento['VolumenDeNegocio'];
                            $fechaBajaDepartamento = (!empty($departamento['FechaBajaDepartamento'])) ? $departamento['FechaBajaDepartamento'] : null;

                            // Ejecutamos la consulta preparada pasando un array asociativo con los nombres de los campos
                            $insercionDepartamento->execute([
                                ':codDepartamento' => $codDepartamento,
                                ':descDepartamento' => $descDepartamento,
                                ':fechaCreacionDepartamento' => $fechaCreacionDepartamento,
                                ':volumenDeNegocio' => $volumenDeNegocio,
                                ':fechaBajaDepartamento' => $fechaBajaDepartamento
                            ]);
                        }

                        // Si el bucle termina sin errores, confirmamos la transacción
                        $miDB->commit();
                        
                        // Mostramos el mensaje y el enlace web
                        echo "<h3>Importacion completada con exito.</h3>";
                        echo "<p>Se han importado $aDepartamentos->length departamentos del archivo guardado en: <b>" . $_SERVER['DOCUMENT_ROOT'] . "/JDPDWESProyectoTema4/tmp/departamentos.json</b></p>";
                        echo "<a href='ejercicio02PDO.php' target='_blank' style='color: #green; font-weight: bold; text-decoration: underline;'>Ver Tabla</a>";
                    
                    } catch (PDOException $miExceptionPDO) {
                        // Si ocurre un error, deshacemos todos los cambios
                        $miDB->rollBack();

                        echo "<div class='error'>";
                        echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
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