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
            #T02_CodDepartamento,#T02_DescDepartamento,
            #T02_FechaCreacionDepartamento,#T02_VolumenDeNegocio{
                background-color: #fffce0;
                border:1px solid black;
            }
            /* Remove arrows for Chrome, Safari, Edge, and Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
            }
            /* Remove arrows for Firefox */
            input[type=number] {
                -moz-appearance: textfield;
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
                padding: 4px;
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
            tr{
                td:nth-child(1){
                    max-width: 70px
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
            require_once '../core/libreriaValidacion.php';
            require_once '../config/configDBPDO.php';
            //Inicializacion de variables
            $entradaOK = true; // Variable que nos indica que todo va bien
            //Array donde recogemos los mensajes de error
            $aError = [
                'T02_CodDepartamento' => "",
                'T02_DescDepartamento' => "",
                'T02_FechaCreacionDepartamento' => "",
                'T02_VolumenDeNegocio' => ""];
            //Array donde recogemos la respuestas correctas
            $aRespuesta = [
                'T02_CodDepartamento' => "",
                'T02_DescDepartamento' => "",
                'T02_FechaCreacionDepartamento' => "",
                'T02_VolumenDeNegocio' => ""];

            // Comprueba si el formulario se a enviado
            if (isset($_REQUEST["enviar"])) {
                // Validar Entrada
                
                $aError["T02_CodDepartamento"] = validacionFormularios::comprobarAlfabetico($_REQUEST["T02_CodDepartamento"],3,3,1);
                $aError["T02_DescDepartamento"] = validacionFormularios::comprobarAlfabetico($_REQUEST["T02_DescDepartamento"],1000,1,1);
                
                $aError["T02_FechaCreacionDepartamento"] = validacionFormularios::validarFecha($_REQUEST["T02_FechaCreacionDepartamento"],date("m/d/Y"),"01/01/1900", 1);
                $aError["T02_VolumenDeNegocio"] = validacionFormularios::comprobarFloatMonetarioES($_REQUEST["T02_VolumenDeNegocio"], PHP_FLOAT_MAX, 0, 1);

                foreach ($aError as $value) {
                    if (!empty($value)) {
                        $entradaOK = false;
                    }
                }
            }
            // El formulario no se ha enviado nunca
            else {
                $entradaOK = false;
            }

            if ($entradaOK) {
                //Cargar la variable $aRespuestas y tratamiento de datos OK
                $aRespuesta["T02_CodDepartamento"] = htmlspecialchars($_REQUEST["T02_CodDepartamento"]);
                $aRespuesta["T02_DescDepartamento"]= htmlspecialchars($_REQUEST["T02_DescDepartamento"]);
                $aRespuesta["T02_FechaCreacionDepartamento"] = new DateTime($_REQUEST["T02_FechaCreacionDepartamento"]);
                $aRespuesta["T02_VolumenDeNegocio"] = floatval(str_replace(',','.',$_REQUEST["T02_VolumenDeNegocio"]));


                try{
                    // inciamos conexion con la base de datos con un objeto PDO
                    $miDB = new PDO(DSN, USER, PASS);
                    // Activamos el modo de excepciones de PDO por seguridad
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // insercion a la bases de datos                  
                    //$consultaInsert = $miDB->exec("INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio) VALUES (".$aRespuesta["T02_CodDepartamento"].",".$aRespuesta["T02_DescDepartamento"].",". $aRespuesta["T02_FechaCreacionDepartamento"]->format("Y-m-d").",".$aRespuesta["T02_VolumenDeNegocio"] .")");
                    // Asignacion de variables preparadas para la inserción
                    
                    $sCodigoDepInsert = $aRespuesta["T02_CodDepartamento"];
                    $sDescripcionDepInsert = $aRespuesta["T02_DescDepartamento"];
                    $sFechaCreacionDepInsert = $aRespuesta["T02_FechaCreacionDepartamento"]->format("Y-m-d");
                    $svolumenNegocioDepInsert = $aRespuesta["T02_VolumenDeNegocio"];

                    // Construccion de la sentencia SQL para insertar el registro (codigo de juan)
                    $sqlInsert = <<<sql
                    INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio) VALUES (
                    '$sCodigoDepInsert',
                    '$sDescripcionDepInsert',
                    '$sFechaCreacionDepInsert',
                    $svolumenNegocioDepInsert)
                sql;

                    // Ejecucion de la consulta de insercion devuelviendo el numero de filas (codigo de juan)
                    $miDB->exec($sqlInsert);
                    echo "<h4 style='margin:0px;color:green'>Insersion exitosa</h4> <br/>";
                    
                    
                    $consulta1 = $miDB->query('select * from T02_Departamento');
                    
                    echo "<h4 >Tabla departamentos</h4> <br/>";
                    echo '<table>';
                    echo '<tr class="titulo"> <td>Codigo</td> <td>Descripcion</td><td>FechaCreacion</td><td>VolumenNegocio</td><td>FechaBaja</td></tr>';
                    while ($oDepartamento = $consulta1->fetchObject()) {
                        echo '<tr>';
                        echo '<td>' . $oDepartamento->T02_CodDepartamento . '</td>';
                        echo '<td>' . $oDepartamento->T02_DescDepartamento . '</td>';
                        $fechaCreacionDepartamento= new DateTime($oDepartamento->T02_FechaCreacionDepartamento);
                        echo '<td>' . $fechaCreacionDepartamento->format('d/m/Y') . '</td>';
                        echo '<td>' . number_format($oDepartamento->T02_VolumenDeNegocio,2,',','.') . ' €</td>';
                        if (is_null($oDepartamento->T02_FechaBajaDepartamento)){
                            echo '<td></td>';
                        }else{
                            $fechaBajaDepartamento=new DateTime($oDepartamento->T02_FechaBajaDepartamento);
                            echo '<td>'.$fechaBajaDepartamento->format('d/m/Y').'</td>';
                        }

                        echo '</tr>';
                    }
                    echo '</table>';
                    echo "<p><a href='". $_SERVER['PHP_SELF']. "'>Añadir otro departamento</a></p>";
                    
                } catch (PDOException $e) {
                    echo "<span style='color:red;'> Codigo de error: " . $e->getCode() . " <span><br/>";
                    echo "<span style='color:red;'> Mensaje de error: " . $e->getMessage() . " <span><br/>";
                } finally {
                    unset($miDB);    
                }     

            } else {
                // Mostrar Formulario
                ?>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" name="formulario" method="post" novalidate>
                    <h3>Alta Departamentos</h3>
                    <label for="T02_CodDepartamento" >Codigo del Departamento:</label>
                    
                    <input type="text" name="T02_CodDepartamento" id="T02_CodDepartamento" value="<?php echo !empty($_REQUEST["T02_CodDepartamento"]) ? htmlspecialchars($_REQUEST["T02_CodDepartamento"]): '' ?>"/>
                    
                    <?php echo !empty($aError["T02_CodDepartamento"]) ? "<span style='color:red;'>" . $aError['T02_CodDepartamento'] . "</span>": '' ?>

                    <br/>
                    
                    <label for="T02_DescDepartamento" >Descripcion del Departamento:</label>
                    
                    <input type="text" name="T02_DescDepartamento" id="T02_DescDepartamento" value="<?php echo !empty($_REQUEST["T02_DescDepartamento"]) ? htmlspecialchars($_REQUEST["T02_DescDepartamento"]): '' ?>"/>
                    
                    <?php echo !empty($aError["T02_DescDepartamento"]) ? "<span style='color:red;'>" . $aError['T02_DescDepartamento'] . "</span>": '' ?>

                    <br/>
                    
                    <label for="T02_FechaCreacionDepartamento">Fecha de Creacion:</label>
                    
                    <input type="date" name="T02_FechaCreacionDepartamento" id="T02_FechaCreacionDepartamento" value="<?php echo !empty($_REQUEST["T02_FechaCreacionDepartamento"])&&empty($aError["T02_FechaCreacionDepartamento"]) ? htmlspecialchars($_REQUEST["T02_FechaCreacionDepartamento"]): '' ?>"/>
                    
                    <?php echo !empty($aError["T02_FechaCreacionDepartamento"]) ? "<span style='color:red;'>" . $aError['T02_FechaCreacionDepartamento'] . "</span>": '' ?>
                    <br/>
                    <div class="advertancia"> Usar una coma para separar los decimales de los enteros</div>
                    <label for="T02_VolumenDeNegocio" >Volumen de Negocio:</label>
                    
                    <input type="text" name="T02_VolumenDeNegocio" id="T02_VolumenDeNegocio" value="<?php echo !empty($_REQUEST["T02_VolumenDeNegocio"]) ? htmlspecialchars($_REQUEST["T02_VolumenDeNegocio"]): '' ?>"/>
                    
                    <?php echo !empty($aError["T02_VolumenDeNegocio"]) ? "<span style='color:red;'>" . $aError['T02_VolumenDeNegocio'] . "</span>": '' ?>
                    
                    <br/>
                    
                    <input type="submit" name="enviar" id="enviar" value="Enviar"/>
                </form>  
                <?php
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