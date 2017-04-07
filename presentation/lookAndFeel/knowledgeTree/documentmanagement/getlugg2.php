<?php

require_once("../../../../config/dmsDefaults.php");



if (1) {


$tabla=$_GET[idd];
$id_enlacesel=$_GET[cc];

/****/
if ($tabla == "Estado"){ 

if ($id_enlacesel == 0 ){ 

$linkA = "SELECT `Lugares`.`Pais`.`dos`, `Lugares`.`Pais`.`id` FROM   `Lugares`.`Pais` WHERE `Lugares`.`Pais`.`id`>0";
$linkB = mysql_query($linkA);
 
//while fetch row
 echo "obj.options[obj.options.length] = new Option('Elija un Pais','');\n";
while ($enlaceB=mysql_fetch_row($linkB)){
$opcion=addslashes($enlaceB[0]);
       echo "obj.options[obj.options.length] = new Option('$opcion','$enlaceB[1]');\n";

}  // fin else id_enlacesel =0
}
else //idenlacesel
{

$linkhay = "SELECT count(*) FROM  `Lugares`.`".$tabla."` WHERE `tres`=". $id_enlacesel;
$linkhayb = mysql_query($linkhay);
$hayono = mysql_fetch_row($linkhayb);
if($hayono[0]>0)
{
$linkA = "SELECT `dos`, `id` FROM  `Lugares`.`".$tabla."` WHERE `tres`=". $id_enlacesel;
$linkB = mysql_query($linkA);
 
//while fetch row
 echo "obj.options[obj.options.length] = new Option('Elija un Estado','');\n";
while ($enlaceB=mysql_fetch_row($linkB)){
$opcion=addslashes($enlaceB[0]);
       echo "obj.options[obj.options.length] = new Option('$opcion','$enlaceB[1]');\n";

}
}//hay o no
else
{
 echo "obj.options[obj.options.length] = new Option('Elija un Estado','');\n";
 echo "obj.options[obj.options.length] = new Option('Pais sin estado','SE o $id_enlacesel');\n";
}
} //id_enlacesel>0



} //tabla=estado
else if ($tabla == "Lugares")
{

$elementos = explode(" o ",$id_enlacesel);

if (!strncmp($elementos[0],"SE",2))
{
   echo "obj.options[obj.options.length] = new Option('Elija una Ciudad','');\n";

$linkA = "SELECT `dos`, `id` FROM  `Lugares`.`".$tabla."` WHERE `cinco`= ". $elementos[1]." order by dos Limit ".$elementos[2].", 50";
$linkB = mysql_query($linkA);
while ($enlaceB=mysql_fetch_row($linkB)){

 

// contar elementos de enlB y concatenarlos en for o while sin la comilla

$opcion=addslashes($enlaceB[0]);
    echo "obj.options[obj.options.length] = new Option('$opcion','$enlaceB[1]');\n";
//   echo "obj.options[obj.options.length] = new Option('$id_enlacesel','1');\n";
 //echo "obj.options[obj.options.length] = new Option('$elementos[0] $elementos[1] $elementos[2]','1');\n";

}

}
else
{

$linkA = "SELECT `dos`, `id` FROM  `Lugares`.`".$tabla."` WHERE `cuatro`=". $elementos[0]." order by dos LIMIT ".$elementos[1].", 50";
//$linkA = "SELECT `dos`, `id` FROM  `Lugares`.`".$tabla."` WHERE `cuatro`=". $elementos[0]." order by dos";
$linkB = mysql_query($linkA);
//while fetch row

 echo "obj.options[obj.options.length] = new Option('Elija una Ciudad','');\n";

while ($enlaceB=mysql_fetch_row($linkB)){

 

// contar elementos de enlB y concatenarlos en for o while sin la comilla

$opcion=addslashes($enlaceB[0]);
    echo "obj.options[obj.options.length] = new Option('$opcion','$enlaceB[1]');\n";
//   echo "obj.options[obj.options.length] = new Option('$id_enlacesel','1');\n";
 //echo "obj.options[obj.options.length] = new Option('$elementos[0] $elementos[1] $elementos[2]','1');\n";

}


} //else elementos

}
  

else if ($tabla == "Lugares_0")
{

$elementoEst=explode(" o ",$id_enlacesel);

//echo "obj.options[obj.options.length] = new Option('$id_enlacesel $elementoEst[0]','');\n";
if (!strncmp($elementoEst[0],"SE",2))
{

echo "obj.options[obj.options.length] = new Option('Elija un Rango','');\n";
//echo "obj.options[obj.options.length] = new Option('Rango Unico','$id_enlacesel');\n";
$linkA = "SELECT count(*)  FROM  `Lugares`.`Lugares` WHERE  `cinco`=". $elementoEst[1];

$linkB = mysql_query($linkA);
//while fetch row
$cuenta=mysql_fetch_row($linkB);
$limite=0;
//$liminf=10;
$secc=0;

 while ($limite<$cuenta[0]){
$limite+=1000;
$liminf=$limite-1000;
$secc++;
//$pruebamod=$limite%3;
//if($pruebamod==0)
//{
$linknom = "SELECT dos  FROM  `Lugares`.`Lugares` WHERE `cinco`=". $elementoEst[1]." order by dos LIMIT ".$liminf.", 1";

$nom0 = mysql_query($linknom);
//while fetch row
$nom1=mysql_fetch_row($nom0);
$opcionom=addslashes($nom1[0]);
//}
//else
//{$opcionom=$secc;}

       echo "obj.options[obj.options.length] = new Option('Empezando en $opcionom','$id_enlacesel o $liminf');\n";


}







}
else
{

echo "obj.options[obj.options.length] = new Option('Elija un Rango','');\n";

$linkA = "SELECT count(*)  FROM  `Lugares`.`Lugares` WHERE `cuatro`=". $id_enlacesel;

$linkB = mysql_query($linkA);
//while fetch row
$cuenta=mysql_fetch_row($linkB);
$limite=0;
//$liminf=10;
$secc=0;

 while ($limite<$cuenta[0]){
$limite+=1000;
$liminf=$limite-1000;
$secc++;
$pruebamod=$limite%3;
//if($pruebamod==0)
//{
$linknom = "SELECT dos  FROM  `Lugares`.`Lugares` WHERE `cuatro`=". $id_enlacesel." order by dos LIMIT ".$liminf.", 1";

$nom0 = mysql_query($linknom);
//while fetch row
$nom1=mysql_fetch_row($nom0);
$opcionom=addslashes($nom1[0]);
//}
//else
//{$opcionom=$secc;}

       echo "obj.options[obj.options.length] = new Option('Empezando en $opcionom','$id_enlacesel o $liminf o $limite');\n";
     //  echo "obj.options[obj.options.length] = new Option('$linknom','$id_enlacesel o $liminf');\n";

}
}//else elementoEst

}//else Lugares_0
  


else if ($tabla == "Lugares_1")
{

$elementoEst=explode(" o ",$id_enlacesel);

if (!strncmp($elementoEst[0],"SE",2))
{

echo "obj.options[obj.options.length] = new Option('Elija un Rango','');\n";
/// seran 500 $linkA = "SELECT count(*)  FROM  `Lugares`.`Lugares` WHERE  `cinco`=". $elementoEst[1];

//$linkB = mysql_query($linkA);
//$cuenta=mysql_fetch_row($linkB);
$limite=0;
$secc=0;

 while ($limite<1000){
$limite+=50;
$liminf=$limite-50+$elementoEst[2];

$secc++;
$linknom = "SELECT dos  FROM  `Lugares`.`Lugares` WHERE `cinco`=". $elementoEst[1]." order by dos LIMIT ".$liminf.", 1";

$nom0 = mysql_query($linknom);
$nom1=mysql_fetch_row($nom0);
$opcionom=addslashes($nom1[0]);
       echo "obj.options[obj.options.length] = new Option('Empezando en $opcionom','$elementoEst[1] o $liminf');\n";


}

}
else
{

echo "obj.options[obj.options.length] = new Option('Elija un Rango','');\n";

// 500 $linkA = "SELECT count(*)  FROM  `Lugares`.`Lugares` WHERE `cuatro`=". $id_enlacesel;

//$linkB = mysql_query($linkA);
//$cuenta=mysql_fetch_row($linkB);
$limite=0;
$secc=0;

 while ($limite<1000){
$limite+=50;
$liminf=$limite-50+$elementoEst[1];
$secc++;
$pruebamod=$limite%3;
//abajo agregado de prueba
//$linkA = "SELECT `dos`, `id` FROM  `Lugares`.`".$tabla."` WHERE `cuatro`=". $elementos[0]." order by dos LIMIT ".$elementos[1].", 50";

$linknom = "SELECT dos  FROM  `Lugares`.`Lugares` WHERE `cuatro`=". $elementoEst[0]." order by dos LIMIT ".$liminf.", 1";

$nom0 = mysql_query($linknom);
$nom1=mysql_fetch_row($nom0);
$opcionom=addslashes($nom1[0]);

       echo "obj.options[obj.options.length] = new Option('Empezando en $opcionom','$elementoEst[0] o $liminf o $limite');\n";
     //  echo "obj.options[obj.options.length] = new Option('$linknom','$id_enlacesel o $liminf');\n";

}
}//else elementoEst

}//else Lugares_1


}
 ?>