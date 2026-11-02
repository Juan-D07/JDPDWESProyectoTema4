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
            require_once '../config/configDBPDO.php';

            try {
                //declaracion de variables de cuando se muestra la tabla
                $fechaCreacionDepartamento;
                $fechaBajaDepartamento;
                
                //creacion de conexion 
                $miDB = new PDO(DSN, USER, PASS);
                
                //array de datos de departamentos
                //codigo, descripcion, coluemn
                $aDatosDepartamentos=[
                    ["codDepartamento" => "AAA",
                    "desDepartamento" => "descripcion a",
                    "volumenNegocioDepartamento" => 400100.11
                    ],
                    ["codDepartamento" => "BBB",
                    "desDepartamento" => "descripcion b",
                    "volumenNegocioDepartamento" => 70100.51
                    ],
                    ["codDepartamento" => "CCC",
                    "desDepartamento" => "descripcion c",
                    "volumenNegocioDepartamento" => 40.61
                    ]
                ];
                
                //iniciamos la transaccion
                $miDB->beginTransaction();
                
                foreach ($aDatosDepartamentos as $aDatosCadaDepartamento){
                    $insercion= 'insert into T02_Departamento values ("'.$aDatosCadaDepartamento["codDepartamento"].'","'.$aDatosCadaDepartamento["desDepartamento"].'",now(),"'.$aDatosCadaDepartamento["volumenNegocioDepartamento"].'",null)';
                    echo "<span> $insercion </span><br>";
                    $miDB->exec($insercion);
                }
                //aplicamos los cambio
                $miDB->commit();
                echo "<h4>Transaccion correcta</h4> <br/>";
                
                //hacer query de la tabla
                $consulta1 = $miDB->query('select * from T02_Departamento');
                echo '<table>';
                // mostrar la tabla
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
                $miDB->rollBack();               
                echo "<span style='color:red;'>Transacción fallida. Cambios deshechos (ROLLBACK).</span>";
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