<?php
$validacao = false;
try
{
    $connect = new PDO("mysql: host=localhost; dbname=exemplo","exemplo","exemplo");
    $connect->exec("set names utf8");
}
catch(PDOException $e)
{
    echo "Error code: ".$e->getMessage();
    exit();
}
        if(isset($_REQUEST["validacao"]) && $_REQUEST["validacao"] == true)
        {
            if($_POST["campoNome"] == null)
            {
                $erro = "Por favor, preencha o campo nome";
            }
            else if(strlen(utf8_decode($_POST["campoNome"])) < 6)
            {
                $erro = "O campo nome deve ter no mínimo 6 caracteres";
            }
            else if($_POST["campoEmail"] == null)
            {
                $erro = "Insira um Email";
            }
            else if(is_numeric($_POST["campoIdade"]) != true)
            {
                $erro = "O campo idade deve ser numérico";
            }
            else if($_POST["campoSexo"] != "m" && $_POST["campoSexo"] != "f" )
            {
                $erro = "Marque uma das opções do campo Sexo";
            }
            else if(isset($_POST["exatas"]) != true && isset($_POST["humanas"]) != true && isset($_POST["biologicas"]) != true)
            {
                $erro = "Escolha uma das opções do campo conhecimento";
            }
            else if($_POST["campoCidade"] == "Sem")
            {
                $erro = "Selecione uma cidade";
            }
            else
            {
                $validacao=true;
                
                $newsql = "UPDATE formulario set
                nome=?,
                email=?,
                idade=?,
                sexo=?,
                exatas=?,
                humanas=?,
                biologicas=?,
                cidade=? where id = ?";
                
                $statement = $connect->prepare($newsql);
                
                $statement->bindParam(1,$_POST["campoNome"]);
                $statement->bindParam(2,$_POST["campoEmail"]);
                $statement->bindParam(3,$_POST["campoIdade"]);
                $statement->bindParam(4,$_POST["campoSexo"]);
                $exact = isset($_POST["exatas"]) ? 1 : 0 ;
                $statement->bindParam(5,$exact);
                $hum = isset($_POST["humanas"]) ? 1 : 0 ;
                $statement->bindParam(6,$hum);
                $bio = isset($_POST["biologicas"]) ? 1 : 0 ;
                $statement->bindParam(7,$bio);
                $statement->bindParam(8,$_POST["campoCidade"]);
                $statement->bindParam(9,$_POST["id"]);
                
                $statement->execute();
                if($statement->errorCode() != "00000")
                {
                    $validacao = false;
                    $erro = "Error code ".$statement->errorCode().":";
                    $erro .= implode(",",$statement->errorInfo());
                }
                else
                {
                    echo"formulário alterado com sucesso";
                }
            }
        }
        else
        {
            $sql = "select*from formulario where id = ?";
            $state = $connect->prepare($sql);
            $state->bindParam(1,$_REQUEST["id"]);

            if($state->execute())
            {
                if($registro = $state->fetch(PDO::FETCH_OBJ))
                {
                    $_POST["campoNome"] = $registro->nome;
                    $_POST["campoEmail"] = $registro->email;
                    $_POST["campoIdade"] = $registro->idade;
                    $_POST["campoCidade"] = $registro->cidade;
                    $_POST["campoSexo"] = $registro->sexo;
                    $_POST["exatas"] = $registro->exatas == 1?true : null;
                    $_POST["humanas"] = $registro->humanas == 1?true : null;;
                    $_POST["biologicas"] = $registro->biologicas == 1?true : null;;
                }
                else
                {
                    echo "problema em acessar o SQL<br>";
                }
            }
            else
            {
                $erro = "Error code ".$statement->errorCode().":";
                $erro .= implode(",",$statement->errorInfo());
            }
        }
        if($validacao == false)
        {
            if(isset($erro))
            {
                echo $erro;
            }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration 3</title>
        <meta name="author" content="LuizS">
    </head>
    <body>
       <form method="post" action="?validacao=true">
        Nome:
        <input type="text" name="campoNome"<?php if(isset($_POST["campoNome"])){echo "value='".$_POST["campoNome"]."'";}?>><br>
        Email:
        <input type="email" name="campoEmail" <?php if(isset($_POST["campoEmail"])){echo "value='".$_POST["campoEmail"]."'";}?>><br>
        Idade:
        <input type="text" name="campoIdade" <?php if(isset($_POST["campoIdade"])){echo "value='".$_POST["campoIdade"]."'";}?>><br>
        Sexo:
        <input type="radio" name="campoSexo" value="m"<?php if($_POST["campoSexo"] == "m"){echo "checked";}?>>Masculino
        <input type="radio" name="campoSexo" value="f" <?php if($_POST["campoSexo"] == "f"){echo "checked";}?>>Feminino<br>
        Conhecimento:<br>
        <input type="checkbox" name="exatas" <?php if($_POST["exatas"] == true){echo "checked";}?>>Exatas<br>
        <input type="checkbox" name="humanas"<?php if($_POST["humanas"] == true){echo "checked";}?>>Humanas<br>
        <input type="checkbox" name="biologicas"<?php if($_POST["biologicas"] == true){echo "checked";}?>>Biológicas<br>
        Cidade:
        <select name="campoCidade">
            <option value="Sem">Selecione...</option>
            <option value="Poa" <?php if($_POST["campoCidade"] == "Poa"){echo "selected";}?>>Porto Alegre</option>
            <option value="Can"<?php if($_POST["campoCidade"] == "Can"){echo "selected";}?>>Canoas</option>
            <option value="Est"<?php if($_POST["campoCidade"] == "Est"){echo "selected";}?>>Esteio</option>
        </select><br>
        <input type="submit" name="alterar">
        <input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>">
        </form>
       
       <?php
        }
       ?>
       <a href="CadastroParte2.php">Tabela</a>
    </body>
</html>