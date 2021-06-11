<?php
try
{
$connect = new PDO("mysql: host=localhost; dbname=exemplo","exemplo","exemplo");
$connect->exec("set names utf8");
}
catch(PDOException $e)
{
$validacao = false;
echo "Error code: ".$e->getMessage();
exit();
}

$sql = "select nome, email from formulario where id = ?";
$state = $connect->prepare($sql);
$state->bindParam(1,$_REQUEST['id']);
if($state->execute())
{
    if($registro = $state->fetch(PDO::FETCH_OBJ))
    {
        $_POST["nome"] = $registro->nome;
        $_POST["email"] = $registro->email;
    }
    else
    {
        echo"Dados não encontrados";
    }
}
else
{
        echo"falha ao alterar a senha";
    }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>registration 4</title>
        <?php
        $validacao = false;
        $erro = null;
        if(isset($_REQUEST["validacao"]) && $_REQUEST["validacao"] == true)
        {
            
            if($_POST["campoSenha"] == null)
            {
                echo "Insira uma senha";
                echo "<a href='?id=".$_POST["id"]."'>Tente Novamente</a>";
                exit();
            }
            else if($_POST["senhaRepeat"] == null)
            {
                echo "Insira a senha pela segunda vez";
                echo "<a href='?id=".$_POST["id"]."'>Tente Novamente</a>";
                exit();
            }
            else if($_POST["campoSenha"] != $_POST["senhaRepeat"])
            {
                echo "As senhas devem ser iguais";
                echo "<a href='?id=".$_POST["id"]."'>Tente Novamente</a>";
                exit();
            }
            else
            {
                $validacao = true;
                
                $sqlup = "update formulario set senha = ? where id=?";
                
                $run = $connect->prepare($sqlup);
                $senhaSec = md5($_POST["campoSenha"]."TOKKEN DE SEGURANÇA");
                $run->bindParam(1,$senhaSec);
                $run->bindParam(2,$_POST['id']);
                $run->execute();
                
                if($run->errorCode() != "00000")
                {
                    $validacao = false;
                    $erro = "Error code ".$run->errorCode().":";
                    $erro .= implode(",",$run->errorInfo());
                }
                else
                {
                    echo "senha editada com sucesso";
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
        <?php
        echo"Nome: ".$_POST["nome"]."<br>";
        echo"Email: ".$_POST["email"]."<br>";
        ?>
       <form method="post" action="?validacao=true">
        Senha:
        <input type="password" name="campoSenha"><br>
        Senha Novamente
        <input type="password" name="senhaRepeat"><br>
        <input type="submit" name="enviar">
        <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
        </form>
       <?php
        }
       ?>
    </body>
</html>