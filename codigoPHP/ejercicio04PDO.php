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
            <section>
            <?php
            require_once '../core/libreriaValidacion.php';
            require_once '../config/configDBPDO.php';
            //Inicializacion de variables
            //Array donde recogemos los mensajes de error
            $aError = [
                'busquedaDescripcion' => ""];
            //Array donde recogemos la respuestas correctas
            $aRespuesta = [
                'busquedaDescripcion' => ""];

            // Comprueba si el formulario se a enviado
            if (isset($_REQUEST["buscar"])) {
                // Validar Entrada                
                $aError["busquedaDescripcion"] = validacionFormularios::comprobarAlfabetico($_REQUEST["busquedaDescripcion"],50,1,0);
            }

            ?>
            
            <div class="buscador">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <label for="busquedaDescripcion">Descripción del Departamento:</label><br><br>
                        <input type="text" name="busquedaDescripcion" id="busquedaDescripcion" value="<?php echo isset($_REQUEST['busquedaDescripcion'])&&empty($aError['busquedaDescripcion']) ? htmlspecialchars($_REQUEST['busquedaDescripcion']) : ''; ?>">
                        <button type="submit" name="buscar">Buscar</button>
                        <br>
                        <?php echo !empty($aError["busquedaDescripcion"]) ? "<span style='color:red;'>" . $aError['busquedaDescripcion'] . "</span>": '' ?>
                        <br>
                    </form>  
            </div>
            <?php
                //Cargar la variable $aRespuestas y tratamiento de datos OK
                $aRespuesta["busquedaDescripcion"]= isset($_REQUEST['busquedaDescripcion'])?htmlspecialchars($_REQUEST["busquedaDescripcion"]):"";

                try{
                    // inciamos conexion con la base de datos con un objeto PDO
                    $miDB = new PDO(DSN, USER, PASS);

                    // Ejecucion de la consulta                   
                    $listaDepartamentos = $miDB->query("select * from T02_Departamento where T02_DescDepartamento like '%" . $aRespuesta['busquedaDescripcion'] . "%'");                    
                    echo '<table>';
                    echo '<tr class="titulo"> <td>Codigo</td> <td>Descripcion</td><td>FechaCreacion</td><td>VolumenNegocio</td><td>FechaBaja</td></tr>';
                    while ($oDepartamento = $listaDepartamentos->fetchObject()) {
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
                    
                } catch (PDOException $e) {
                    echo "<span style='color:red;'> Codigo de error: " . $e->getCode() . " <span><br/>";
                    echo "<span style='color:red;'> Mensaje de error: " . $e->getMessage() . " <span><br/>";
                } finally {
                    unset($miDB);    
                }     
            
                ?>

            </section>
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