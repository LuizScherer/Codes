<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="LuizS">
        <meta name="description" content="Primeira Parte Cadastro">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Entrada</title>
        <?php
        $validacao = false;
        $erro = null;
        error_reporting(0);
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
            else if($_POST["campoSenha"] == null)
            {
                $erro = "Insira uma senha";
            }
            else if($_POST["senhaRepeat"] == null)
            {
                $erro = "Insira novamente a senha";
            }
            else if($_POST["campoSenha"] != $_POST["senhaRepeat"])
            {
                $erro = "As senhas devem ser iguais";
            }
            else
            {
                $validacao = true;
                
                try
                {
                    $connect = new PDO("mysql: host=localhost; dbname=exemplo","exemplo","senhaexemplo");
                    $connect->exec("set names utf8");
                }
                catch(PDOException $e)
                {
                    $validacao = false;
                    echo "Error code: ".$e->getMessage();
                    exit();
                }
                
                $sql = "insert into formulario(nome,email,idade,sexo,exatas,humanas,biologicas,cidade,senha)
                value(?,?,?,?,?,?,?,?,?)";
                
                $statement = $connect->prepare($sql);
                
                $statement->bindParam(1,$_POST["campoNome"]);
                $statement->bindParam(2,$_POST["campoEmail"]);
                $statement->bindParam(3,$_POST["campoIdade"]);
                $statement->bindParam(4,$_POST["campoSexo"]);
                $exact = isset($_POST["exatas"])? 1 : 0;
                $statement->bindParam(5,$exact);
                $hum = isset($_POST["humanas"])? 1 : 0;
                $statement->bindParam(6,$hum);
                $bio = isset($_POST["biologicas"])? 1 : 0;
                $statement->bindParam(7,$bio);
                $statement->bindParam(8,$_POST["campoCidade"]);
                $segurança = md5($_POST["campoSenha"]."TOKKEN DE SEGURANÇA ALEATORIO");
                $statement->bindParam(9,$segurança);
                
                $statement->execute();
                
                if($statement->errorCode() != "00000")
                {
                    $validacao = false;
                    $erro = "Error code ".$statement->errorCode().":";
                    $erro .= implode(",",$statement->errorInfo());
                }
                else
                {
                    echo "Fomulário enviado com sucesso";
                }
            }
        }
        if($validacao == false)
        {
            if(isset($erro))
            {
                echo $erro;
            }
          
        ?>
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
        <input type="checkbox" name="exatas" <?php if(isset($_POST["exatas"])){echo "checked";}?>>Exatas<br>
        <input type="checkbox" name="humanas"<?php if(isset($_POST["humanas"])){echo "checked";}?>>Humanas<br>
        <input type="checkbox" name="biologicas"<?php if(isset($_POST["biologicas"])){echo "checked";}?>>Biológicas<br>
        Cidade:
        <select name="campoCidade">
            <option value="Sem">Selecione...</option>
            <option value="Poa" <?php if($_POST["campoCidade"] == "Poa"){echo "selected";}?>>Porto Alegre</option>
            <option value="Can"<?php if($_POST["campoCidade"] == "Can"){echo "selected";}?>>Canoas</option>
            <option value="Est"<?php if($_POST["campoCidade"] == "Est"){echo "selected";}?>>Esteio</option>
        </select><br>
        Senha:
        <input type="password" name="campoSenha"><br>
        Senha Novamente
        <input type="password" name="senhaRepeat"><br>
        <input type="submit" name="enviar">
        </form>
       <?php
        }
       ?>
    </body>
</html>