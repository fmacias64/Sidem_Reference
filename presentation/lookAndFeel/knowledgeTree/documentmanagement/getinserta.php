<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

  //echo "hola";
$id_docactual=$_GET[idd];
$id_enlacesel=$_GET[cc];
 
for($numerito1=2929010; $numerito1<3788900;$numerito1=$numerito1+10000){

$numerito2=$numerito1+10000;

//$miquery="INSERT INTO `sidem210708`.`Lugareshomonimos` SELECT distinct B.`id`, B.`dos`, B.`cuatro`, B.`cinco`, B.`seis`, B.`siete`, B.`ocho`, B.`nueve`, B.`diez`, B.`once`, B.`Nivel` FROM `LugaresBK2` as A, `LugaresBK2` as B where B.`seis` = A.`seis` AND B.`siete` = A.`siete` AND B.`ocho` = A.`ocho` AND B.`id` < A.`id` AND A.`id` > $numerito1 AND B.`id` > $numerito1 AND A.`id` < $numerito2 AND B.`id` < $numerito2;";

$miquery="INSERT INTO `sidem210708`.`Lugareshomonimos` SELECT distinct B.`id`, B.`dos`, B.`cuatro`, B.`cinco`, B.`seis`, B.`siete`, B.`ocho`, B.`nueve`, B.`diez`, B.`once`, B.`Nivel` FROM `CiudadesF2` as A, `CiudadesF2` as B where B.`seis` = A.`seis` AND B.`siete` = A.`siete` AND B.`ocho` = A.`ocho` AND B.`id` < A.`id` AND A.`id` > $numerito1 AND B.`id` > $numerito1 AND A.`id` < $numerito2 AND B.`id` < $numerito2;";
 $miejecucion = mysql_query($miquery);


echo $numerito2."\n";
$ONE = "INSERT INTO `sidem210708`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('$i', 'Numero CF2 0: ". $numerito1."', ".$numerito2.", NULL);"; 
   $TWO = mysql_query($ONE);


}



 }

 ?>