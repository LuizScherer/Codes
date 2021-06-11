<html>
    <head>
        <meta charset="UTF-8">
        <title>Olaaa</title>
    </head>
    <body>
        <?php
        abstract class InstMusical 
        {
            public $volume;
            public abstract function tocar();
        }
        
        interface transportar
        {
            public function transporte();
        }
        
        class guitarra extends InstMusical implements transportar
        {
            public function tocar()
            {
                echo"Tocando Guitarra";
            }
            public function transporte()
            {
                echo"Senta na cabeça<br>";
            }
        }
        
        $Tocar = new guitarra();
        $Tocar->tocar();
        $Tocar->transporte();
        ?>
    </body>
</html>