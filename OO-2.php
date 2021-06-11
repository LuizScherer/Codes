<html>
    <head>
        <meta charset="UTF-8">
        <title>Olaaa</title>
    </head>
    <body>
        <?php
        class InstrumentoMusical
        {
            public $isPercussao;
            public $volume;
            public function __construct($isPercussao,$volume)
            {
                $this->isPercussao = $isPercussao;
                $this->volume = $volume;
            }
            
            public function tocar()
            {
                echo"toca um som no volume de ".$this->volume.".<br>";
            }
        }
        $InMusical = new InstrumentoMusical(true,22);
        $InMusical->tocar();
        if($InMusical->isPercussao)
        {
            echo"Instrumento de percussao com volume de ".$InMusical->volume."<br>";
        }
        else
        {
            echo"Instrumento não é de percussao com volume de ".$InMusical->volume;
        }
        
        class violino extends InstrumentoMusical
        {
            public function tocar()
            {
                echo"Somzão em ".$this->volume.".<br>";
            }
            public function tocarTudo()
            {
                $this->tocar();
                parent::tocar();
            }
        }
        $Guitarra = new violino(false,52);
        $Guitarra->tocar();
        $Guitarra->tocarTudo();
        if($Guitarra->isPercussao)
        {
            echo"Instrumento que é de percussao com vol de ".$Guitarra->volume; 
        }
        else
        {
            echo"Instrumento não que é de percussao com vol de ".$Guitarra->volume; 
        }
        
        class alfabeto
        {
            public static $tresPrimeirasLetras = "A B C";
        }
        echo "3 primeiras letras: ".alfabeto::$tresPrimeirasLetras;
        
        ?>
    </body>
</html>