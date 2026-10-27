<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Tema 4 · Juan Miguel Dominguez </title>
        <link rel="stylesheet" href="../webroot/css/ejercicios.css">
        <style>
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
                td:nth-child(3),
                td:nth-child(5){
                    max-width: 200px
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
            require_once '../config/configDBPDO.php';

            try {
                //conexion correcta
                $fechaCreacionDepartamento;
                $fechaBajaDepartamento;
                $miDB = new PDO(DSN, USER, PASS);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $consulta1 = $miDB->query('select * from T02_Departamento');

                echo "<h4>Tabla departamentos</h4> <br/>";
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
            } catch (PDOException $e) {
                echo "<span style='color:red;'> Codigo de error: " . $e->getCode() . " <span><br/>";
                echo "<span style='color:red;'> Mensaje de error: " . $e->getMessage() . " <span><br/>";
            } finally {
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