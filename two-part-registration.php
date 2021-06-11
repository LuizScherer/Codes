<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration 2</title>
</head>
<body>
        lista de usuários
        <table border=1>
            <thead>
                <tr>
                    <th>id</th>
                    <th>nome</th>
                    <th>email</th>
                    <th>idade</th>
                    <th>sexo</th>
                    <th>exatas</th>
                    <th>humanas</th>
                    <th>biologicas</th>
                    <th>cidade</th>
                    <th>senha</th>
                    <th>ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    try
                    {
                        $connect = new PDO("mysql: host=localhost; dbname=php","root","e7550432");
                        $connect->exec("set names utf8");
                    }
                    catch(PDOException $e)
                    {
                        echo "Error code: ".$e->getMessage();
                        exit();
                    }
                    
                    if(isset($_REQUEST["excluir"]) && $_REQUEST["excluir"]==true)
                    {
                        
                        $sqldel = "delete from formulario where id = ?";
                        $qu = $connect->prepare($sqldel);
                        $qu->bindParam(1,$_REQUEST["id"]);
                        if($qu->execute())
                        {
                            echo"Dados excluido com sucesso";
                        }
                        else
                        {
                            echo"Erro ao excluir";
                        }
                    }
                    
                    $sql = "select*from formulario";
                    $state = $connect->prepare($sql);
                    
                    if($state->execute())
                    {
                        while($registro = $state->fetch(PDO::FETCH_OBJ))
                        {
                            echo "<tr>";
                            echo "<td>".$registro->id."</td>";
                            echo "<td>".$registro->nome."</td>";
                            echo "<td>".$registro->email."</td>";
                            echo "<td>".$registro->idade."</td>";
                            echo "<td>".$registro->sexo."</td>";
                            echo "<td>".$registro->exatas."</td>";
                            echo "<td>".$registro->humanas."</td>";
                            echo "<td>".$registro->biologicas."</td>";
                            echo "<td>".$registro->cidade."</td>";
                            echo "<td>".$registro->senha."</td>";
                            echo "<td>";
                            echo "<a href='CadastroParte3.php?id=".$registro->id."'>alterar</a> ";
                            echo"<a href='?excluir=true&id=".$registro->id."'>excluir</a> ";
                            echo "<a href='CadastroParte4.php?id=".$registro->id."'>nova senha</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    else
                    {
                        echo"Falha ao conectar com o Banco de Dados";
                    }
                ?>
            </tbody>
        </table><br>
        <a href="CadastroParte1.php">Cadastrar</a>
</body>
</html>