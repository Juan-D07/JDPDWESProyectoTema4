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
                $fechaActual= new DateTime();
                //creacion de conexion 
                $miDB = new PDO(DSN, USER, PASS);
                
                //array de datos de departamentos
                //codigo, descripcion, fecha alta, volumen
                $aDepartamentosnuevos=[
                    ["codDepartamento" => "DDD",
                    "descDepartamento" => "descripcion d",
                    "fechaAltaDepartamento"=>    "2025-05-07",
                    "volumenNegocioDepartamento" => 33456.36,
                    "fechaBajaDepartamento" => null,    
                    ],
                    ["codDepartamento" => "EEE",
                    "descDepartamento" => "descripcion e",
                    "fechaAltaDepartamento"=>    "2020-05-07",
                    "volumenNegocioDepartamento" => 10.43,
                    "fechaBajaDepartamento" => $fechaActual->format("Y-m-d"), 
                    ],
                    ["codDepartamento" => "FFF",
                    "descDepartamento" => "descripcion f",
                    "fechaAltaDepartamento"=>    $fechaActual->format("Y-m-d"),
                    "volumenNegocioDepartamento" => 480000.01,
                    "fechaBajaDepartamento" => null, 
                    ]
                ];
                
                
                //insercion con consulta preparada
                //iniciamos consulta dentro de un heredoc
                $sqlInsert = <<<sql
                INSERT INTO T02_Departamento VALUES (
                :codDepartamento,
                :descDepartamento,
                :fechaAltaDepartamento,
                :volumenNegocioDepartamento,
                :fechaBajaDepartamento)
                sql;
                //preparamos la insercion
                $insercionDepartamento=$miDB->prepare($sqlInsert);
                foreach ($aDepartamentosnuevos as $aDatosCadaDepartamento){
                    //ejecutamos la insercion por cada deparatamento
                    $insercionDepartamento->bindParam(":codDepartamento", $aDatosCadaDepartamento["codDepartamento"]);
                    $insercionDepartamento->bindParam(":descDepartamento", $aDatosCadaDepartamento["descDepartamento"]);
                    $insercionDepartamento->bindParam(":fechaAltaDepartamento", $aDatosCadaDepartamento["fechaAltaDepartamento"]);
                    $insercionDepartamento->bindParam(":volumenNegocioDepartamento", $aDatosCadaDepartamento["volumenNegocioDepartamento"]);
                    $insercionDepartamento->bindParam(":fechaBajaDepartamento", $aDatosCadaDepartamento["fechaBajaDepartamento"]);
                    $insercionDepartamento->execute();
                    //$insercionDepartamento->execute($aDatosCadaDepartamento);
                }

                echo "<h4>Insercion Completa</h4> <br/>";
                
                //hacer query de la tabla
                $selectDepartamentos = $miDB->query('select * from T02_Departamento');
                echo '<table>';
                // mostrar la tabla
                echo '<tr class="titulo"> <td>Codigo</td> <td>Descripcion</td><td>FechaCreacion</td><td>VolumenNegocio</td><td>FechaBaja</td></tr>';
                while ($oDepartamento = $selectDepartamentos->fetchObject()) {
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