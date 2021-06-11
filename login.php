<!DOCTYPE HTML>
<html lang="pt=br">
    <head>
        <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Interface open</title>
    </head>
    <body>
        <?php
        session_start();
           if(isset($_SESSION["usuario"]) == false)
           {
            echo "Usuario não encontrado";
            exit();
           }
           echo"Bem vindo".$_SESSION["usuario"]."<br>";
        ?>
        [CONTEUDO SENSÍVEL]
    </body>
</html>