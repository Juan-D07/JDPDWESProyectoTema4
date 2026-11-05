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

            try {
                // Instanciacion del objeto PDO para conectar a MariaDB
                $miDB = new PDO(DSN, USER, PASS);

                // Consulta SQL para obtener código y descripción de todos los departamentos
                $sql = 'SELECT * FROM T02_Departamento';
                $DatosDepartamentos = $miDB->prepare($sql);
                $DatosDepartamentos->execute();

                // Si hay registros, comenzamos a generar el XML
                if ($DatosDepartamentos->rowCount() > 0) {
                    
                    //inicializamos el vector de departamentos
                    $aDepartamentos=[];

                    // Recorremos los registros de la base de datos
                    while ($oDepartamento = $DatosDepartamentos->fetchObject()) {
                        //creamos un departamento y lo añadimos al vec
                        $aDepartamentos[] = [
                            'CodDepartamento' => $oDepartamento->T02_CodDepartamento,
                            'DescDepartamento' => $oDepartamento->T02_DescDepartamento,
                            'FechaCreacionDepartamento' => $oDepartamento->T02_FechaCreacionDepartamento,
                            'VolumenDeNegocio' => $oDepartamento->T02_VolumenDeNegocio,
                            'FechaBajaDepartamento' => $oDepartamento->T02_FechaBajaDepartamento
                        ];
                    }

                    //convertimos al array en json
                    $sjson= json_encode($aDepartamentos, JSON_PRETTY_PRINT);
                    
                    // Guarda el contenido JSON en un fichero
                    $ficheroJSON= file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/JDPDWESProyectoTema4/tmp/departamentos.json',$sjson);

                    // Mostramos el mensaje y el enlace web
                    echo "<h3>Exportacion completada con exito.</h3>";
                    echo "<p>El archivo se ha guardado en: <b>".$_SERVER['DOCUMENT_ROOT'] . "/JDPDWESProyectoTema4/tmp/departamentos.json</b></p>";
                    echo "<a href='../tmp/departamentos.json' target='_blank' style='color: #green; font-weight: bold; text-decoration: underline;'>Ver archivo JSON</a>";

                }
            } catch (PDOException $miExceptionPDO) {
                // Captura errores de PDO
                echo "<div class='error'>";
                echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
                echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
                echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
                echo "</div>";
            } finally {
                // Cierra la conexión a la base de datos
                unset($miDB);
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