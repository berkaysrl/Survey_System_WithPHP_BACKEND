<?php
try{
    $db=new PDO("mysql:host=localhost;dbname=anket;charset=utf8","root");
}
catch(Exception $e)
{
    echo $e->getMessage();
}

function Filtrele($deger)
{
    $a=trim($Deger);
    $b=strip_tags($a);
    $c=htmlspecialchars($b,ENT_QUOTES);
    $Sonuc=$c;
    return $Sonuc;
}


?>