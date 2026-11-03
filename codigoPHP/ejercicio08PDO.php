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
                    // Instanciamos el objeto DOMDocument (versión 1.0, codificación UTF-8)
                    $documentoXML = new DOMDocument('1.0', 'UTF-8');
                    // Formatear la salida para que el XML tenga saltos de línea (sea legible)
                    //$documentoXML->formatOutput = true;

                    // Creamos el elemento raiz departamentos y lo añadimos al documento
                    // Crea un nuevo nodo elemento
                    $raiz=$documentoXML->createElement('departamentos');
                    // Añade un nuevo hijo al final de los hijos
                    $documentoXML->appendChild($raiz);

                    // Recorremos los registros de la base de datos
                    while ($oDepartamento = $DatosDepartamentos->fetchObject()) {

                        // Creamos el departamento para cada registro
                        $sDepartamento = $documentoXML->createElement('departamento');

                        // Creamos el codigo, añadimos el texto y lo colgamos de departamento
                        $sCodigo = $documentoXML->createElement('CodDepartamento');

                        // Crea un nuevo texto
                        $sCodigo->appendChild($documentoXML->createTextNode($oDepartamento->T02_CodDepartamento));

                        // Añadimos el codigo al departamento
                        $sDepartamento->appendChild($sCodigo);

                        // Creamos la descripcion, añadimos el texto y lo colgamos de departamento
                        $sDescripcion = $documentoXML->createElement('DescDepartamento');
                        $sDescripcion->appendChild($documentoXML->createTextNode($oDepartamento->T02_DescDepartamento));
                        $sDepartamento->appendChild($sDescripcion);
                        
                        // Creamos la fecha de alta, añadimos el texto y lo colgamos de departamento
                        $sfechaAlta=$documentoXML->createElement('FechaCreacionDepartamento');
                        $sfechaAlta->appendChild($documentoXML->createTextNode($oDepartamento->T02_FechaCreacionDepartamento));
                        $sDepartamento->appendChild($sfechaAlta);
                        
                        // Creamos la fecha de alta, añadimos el texto y lo colgamos de departamento
                        $svolumenNegocio=$documentoXML->createElement('VolumenDeNegocio');
                        $svolumenNegocio->appendChild($documentoXML->createTextNode($oDepartamento->T02_VolumenDeNegocio));
                        $sDepartamento->appendChild($svolumenNegocio);
                        
                        // Creamos la fecha de alta, añadimos el texto y lo colgamos de departamento
                        $sfechaBaja=$documentoXML->createElement('FechaBajaDepartamento');
                        $sfechaBaja->appendChild($documentoXML->createTextNode($oDepartamento->T02_FechaBajaDepartamento));
                        $sDepartamento->appendChild($sfechaBaja);
                        
                        // Colgamos el departamento completo de la raiz departamentos
                        $raiz->appendChild($sDepartamento);
                    }

                    // Guardamos el archivo XML generado en el servidor
                    // Guarda el documento XML en un fichero
                    $documentoXML->save($_SERVER["DOCUMENT_ROOT"] . '/JDPDWESProyectoTema4/tmp/departamentos.xml');

                    // Mostramos el mensaje y el enlace web
                    echo "<h3>Exportacion completada con exito.</h3>";
                    echo "<p>El archivo se ha guardado en: <b>".$_SERVER['DOCUMENT_ROOT'] . "JDPDWESProyectoTema4/tmp/departamentos.xml}</b></p>";
                    echo "<a href='../tmp/departamentos.xml' target='_blank' style='color: #green; font-weight: bold; text-decoration: underline;'>Ver archivo XML</a>";

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