<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

  //echo "hola";
$id_docactual=$_GET[idd];
$id_enlacesel=$_GET[cc];
 

KTUtil::extractGPC('fDocumentID');
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentCollaboration.inc");
$letra = $_GET["letra"];
 






   $iddoc=$letra;
  
  


$iddoc = $_GET["letra"];


$oDocument = & Document::get($iddoc);

 
  //$elword .= "<center><font size=1 face='Times'>Datos Personales</font></>";
$elword.= "<table border=0 style=\"width=100%\"><tr><td style=\"vertical-align: top; text-align: left; width: 150px;\">\n";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 
   $docs="img/".$oDocument->getFileName();
   
  $tama=filesize($docs);


   
 if ($tama >= 10){
 
 $elword =  "<img style=".'"'." width: 70px; height: 70px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src= ".'"'."http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents". $oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName().'"'." > </a>";
  
  }
 else
   {
 $elword = "<img style=".'"'." width: 70px; height: 70px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents/Root Folder/Default Unit/SIDEM/Individuo/nofoto.jpg\" >";
   }

$elword.="</td><td>";

if ($sectionName == "") {
    $sectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
}

 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====
$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$iddoc;
$indv_rel1 = mysql_query($indv_rel);
//$indv_rel2 = mysql_fetch_row($indv_rel1);

$extra="";
 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{
$bandtipo=1;
 

 
 if ($indv_rel2[2]==8) {
    $nam=$indv_rel2[3];
    $bandtipo=0;
}
 if ($indv_rel2[2]==21 ){
   $appat=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==22){
   $apmat=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==23 ){
    $fech=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==54 ){
    $nac=$indv_rel2[3];
$bandtipo=0;
}
 if ($indv_rel2[2]==55 ){
    $inst=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==56){
    $carg=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==57 ){
    $tel=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==58 ){
    $mail=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==59){
    $dir=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==60 ){
    $dir1=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==61 ){
    $cpos=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==38 ){
    $edo=$indv_rel2[3];
$bandtipo=0;
}

if ($indv_rel2[2]==18 ){
    $lug=$indv_rel2[3];
$bandtipo=0;
}

/// abajo k_z_lugares
if ($indv_rel2[2]==153 ){
    $lug=$indv_rel2[3];
$bandtipo=0;
if($indv_rel2[3]>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$indv_rel2[3];
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$indv_rel2[3];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$indv_rel2[3];
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);
//$sToRender .= "<SELECT  ID=\"%s\" NAME=\"%s\"   SIZE=\"1\">";
 $LugToRender .= "$dato1[0],$dato2[0], $dato3[0]";

     //  $extra.="<font size=2 face='Times' color='blue'>$explparam[2]</font><td colspan='2' align='justify'><font size=2 face='Times'>".$sToRender."</font>";

//$sToRender.="<input type='text' size='20' name='%s' value='%s' maxlength='12' />";

//return sprintf($sToRender,$this->sFormName, $this->sFormName,$this->sValue, $this->sFormName);
}//si value es mayor a 0 arriba si no abajo

}


if ($indv_rel2[2]==96 ){
    $resum=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==63 ){
    $rel1=$indv_rel2[3];
$bandtipo=0;
}

if ($indv_rel2[2]==64 ){
    $rel2=$indv_rel2[3];
$bandtipo=0;
}

if ($indv_rel2[2]==65 ){
    $rel3=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==69 ){
    $gen=$indv_rel2[3];
$bandtipo=0;
}

if ($bandtipo==1)
{
//ver numero de campo
if ($indv_rel2[3]!="" or $indv_rel2[3]>0)
{

  $numcampo=$indv_rel2[2];
$chkdf="select a.id from document_type_fields_link as a, documents as b  where b.id =".$iddoc." AND a.document_type_id=b.document_type_id AND a.field_id=".$numcampo;
$chk2df=mysql_query($chkdf);

if ($chk3df=mysql_fetch_row($chk2df)){

    
       $onedf="SELECT * FROM `document_fields` WHERE `id` =".$numcampo;
       $twodf=mysql_query($onedf);
       $tresdf=mysql_fetch_row($twodf);
      
       $extra.="<font size=2 face='Times' color='blue'>$tresdf[1]</font><td colspan='2' align='justify'><font size=2 face='Times'>".$indv_rel2[3]."</font>";

//k_zlugares
$explparam= explode("_",$tresdf[1]);
if (!strcmp($explparam[1],"zLugares"))
{
if($indv_rel2[3]>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$indv_rel2[3];
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$indv_rel2[3];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$indv_rel2[3];
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);
//$sToRender .= "<SELECT  ID=\"%s\" NAME=\"%s\"   SIZE=\"1\">";
 $sToRender .= "$dato1[0],$dato2[0], $dato3[0]";

       $extra.="<font size=2 face='Times' color='blue'>$explparam[2]</font><td colspan='2' align='justify'><font size=2 face='Times'>".$sToRender."</font>";

}//si value es mayor a 0 arriba si no abajo
else
{
 $extra.="<font size=2 face='Times' color='blue'>$explparam[2]</font><td colspan='2' align='justify'><font size=2 face='Times'> N/A </font>";

}
}
else{
 $extra.="<font size=2 face='Times' color='blue'>$tresdf[1]</font><td colspan='2' align='justify'><font size=2 face='Times'>".$indv_rel2[3]."</font>";
}
//lugares




}
}

}

}









 $elword .= "<h2><font size=2 face='Times'>".$appat." ".$apmat." ".$nam  ."</font></h2>";
$elword.="<br>\n";
if ($_SESSION["userID"]==1){
$bEdit=1;
if(!($sectionName =="Administration")){

	
				}	
		}
if ($_SESSION["userID"]==5){
$bEdit=1;
if(!($sectionName =="Administration")){
	
				}	
		}

//===============
//==============

$elword .= "<font size=2 face='Times' color='blue'>Fecha de Nacimiento</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times' >".$fech ."</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times' color='blue'>Nacionalidad</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times'>".$nac ."</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times' color='blue'>Telefono</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times'>".$tel ."</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times' color='blue'>E-mail</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times'>".$mail ."</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times' color='blue'>Lugar de Nacimiento</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times'> ".$LugToRender."</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times' color='blue'>Genero</font>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times'>".$gen."</font>";
$elword.="<br>\n";
$elword.="</td></tr></table>";

$elword.="<br><center><font size=2 face='Times' color='blue'>Resumen Ejecutivo</font></center>";
$elword.="<br>\n";
$elword.="<font size=2 face='Times'>".utf8_encode($resum)."</font><br>";
 


$elword .= $extra;



//===========>>> INICIA TRAYECTORIA  =============>>>>



//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=4 and `status_id` = 1") or die("deadind1"); 
$indicetra=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste3[] = $row[0];
//$elrow=$row[0];
 $indicetra++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indicetra>0)
{
$cuentaindiv=0;
// foreach ($liste3 as $ID1) {

// a,b,c ... todos los campos de un documento especifico
// doc es el documento enlace y con el campo comentario
//h es hijo o padre de doc, es de tipo evento y ea,eb e... son sus campos


$result3= mysql_query("select * from trayectoria where parent_id= $iddoc or child_id = $iddoc order by tipotray");

while($row3 =  mysql_fetch_row($result3))
{
  
/**
subindice
0
1       a  comentario            4
2	ea Tipo de Evento        6
3	eb Fecha de Registro ord 1
4	ec Titulo de Evento      2
5	ed Lugar                 3
	g 
6       h evento       
7       ee fuente                5
*/



if (($cuentaindiv!=0) AND ($tipoactual!=$row3[5])){
$elword.="</tbody></table>";
$elword .= "<br><br><center><font size=2 face='Times' color='blue'>Trayectoria  tipo: $row3[5]</font></center><br>";

$elword.="<table><tbody>";

$elword .= "<th>\n";

$elword .= "<font size=2 face='Times' color='blue'>Fecha <br>de Registro</font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fecha <br>de Inicio</font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fecha <br>Final</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Tipo de Trayectoria</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Cargo-Puesto</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Nombre Instituci&oacute;n</font>";
$elword .="</th>";

}
if ($cuentaindiv==0) {
$cuentaindiv++ ;
$elword .= "<br><br><center><font size=2 face='Times' color='blue'>Trayectoria  tipo: $row3[5]</font></center><br>";
$elword.="<table><tbody>";
$elword .="<th>";
$elword .= "<font size=2 face='Times' color='blue'>Fecha <br>de Registro</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fecha <br>de Inicio</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fecha <br>Final</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Tipo de Trayectoria</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Cargo-Puesto</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Nombre Instituci&oacute;n</font>";
$elword .="</th>";
}
$tipoactual=$row3[5];
$elword .= "<tr>\n";
$elword .= "<td>";
$elword .= "<font size=2 face='Times'>".$row3[8] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$row3[6] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$row3[7] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getftray_indv&letra=".$row3[0] ."' target='_blank'>".$row3[5] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$row3[3] ."</font>";
$elword .= "</td><td>";
//averiguamos cuel es el individuo y cual la empresa
if ($row3[1] == $iddoc) {$empresa=$row3[2];}
else {$empresa=$row3[1];}

//abajo sacamos el nombre de la empresa
    $razonsocial0= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 92  AND `document_id`=".$empresa;
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);


$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$empresa ."' target='_blank' >".$razonsocial20[0] ."</font>";
$elword .= "</td></tr>";


} // cierre del for}






}  // fin de indice
//===================<<<< TERMINA TRAYECTORIA <<<<===================
$elword.="</tbody></table>";
//*** Individuos


//me quede en corregir abajo
$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 26 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=20 and a.`status_id` = 1 order by b.`value`") or die("deadw1"); 
$indiceind=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste2[] = $row[0];
 $indiceind++; 
}
// Si indice es mayor a 0 existe trayectoria
if($indiceind>0)
{

$cuentaindiv=0;

$result3= mysql_query("select * from individuo_individuo where parent_id= $iddoc or child_id = $iddoc order by tipo");




while ($row3 =  mysql_fetch_row($result3))
{

if (($cuentaindiv!=0) AND ($tipoactual!=$row3[6])){
$elword.="</tbody></table>";
$elword .= "<br><br><center><font size=2 face='Times' color='blue'>Relaci&oacute;n  tipo: $row3[4]</font></center><br>";
$elword .= "<table><tbody>";
$elword .= "<th>\n";
$elword .= "<font size=2 face='Times' color='blue'>Nombre</font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Direcci&oacute;n</font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fecha de <br> Registro</font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fuente</font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Nota Completa</font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fuerza</font>";
$elword .= "</th>";
}

// aqui
if ($cuentaindiv==0) {
$cuentaindiv++ ;
$elword .= "<br><br><center><font size=2 face='Times' color='blue'>Relaci&oacute;n  tipo: $row3[6] 1</font></center><br>";

$elword.="<table><tbody>";
$elword .="<th>";
$elword .= "<font size=2 face='Times' color='blue'>Nombre</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Direcci&oacute;n</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fecha de <br> Registro</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fuente</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Nota Completa</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fuerza</font>";
$elword .="</th>";
//aca
}

$tipoactual=$row3[6];
/**2303 ***/
//abajo pendiente
//averiguamos cuel es el individuo y cual la empresa
$bandera_dir=0;
if ($row3[1] == $iddoc) {
$indivrelac=$row3[2];


if ($row3[4]=="")
{
$direccion_relacion=" No Disponible ";
}
else
{$direccion_relacion=$row3[4]; }
}
else 
{
$indivrelac=$row3[1];

if ($row3[4]=="")
{
$bandera_dir=1;
$direccion_relacion=" No Disponible ";
}
 if (strncmp($row3[4],"Jerarquica Ascendente",21) === 0)
{
$bandera_dir=1;
$direccion_relacion="Jerarquica Descendente";
} 

 if (strncmp($row3[4],"Jerarquica Descendente",22) === 0)
{
$bandera_dir=1;
$direccion_relacion="Jerarquica Ascendente";
}

if ($bandera_dir==0)
{
$direccion_relacion=$row3[4];
}

}

//abajo sacamos el nombre de la empresa
//nombre
    $razonsocial0= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 8  AND `document_id`=".$indivrelac;
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);

$nombre_ind_rel=$razonsocial20[0];
//appat
  $razonsocial0= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 21  AND `document_id`=".$indivrelac;
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);
$nombre_ind_rel.=" ".$razonsocial20[0];
//apmat
  $razonsocial0= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 22  AND `document_id`=".$indivrelac;
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);
$nombre_ind_rel.=" ".$razonsocial20[0];

$elword .= "<tr><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY_devel/control.php?action=getficha&letra=".$indivrelac."' target='_blank' >".$nombre_ind_rel ."</font></a>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY_devel/control.php?action=getfindv_indv&letra=".$row3[0] ."' target='_blank' >".$direccion_relacion ."</a></font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$row3[5] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$row3[8] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$row3[7] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$row3[9] ."</font>";
$elword .= "</td></tr>";







}





} 

//** fin individuos

//===================Inicia Finanzas ===========================
$elword.="</tbody></table>";

$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=15 and `status_id` = 1") or die("deadw1"); 
$indicefin=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste1[] = $row[0];
 $indicefin++; 
}
// Si indice es mayor a 0 existe trayectoria
if($indicefin>0)
{

$cuenta=0;
//foreach ($liste1 as $ID1) {


$elword .= "<br><br><center><font size=2 face='Times' color='blue'>Finanzas</font></center><br>";
$elword.="<table><tbody>";
$elword .= "<th>\n";

$elword .= "<font size=1 face='Times' color='blue'>Fecha <br>de Registro</font>";
$elword .= "</th><th>";
$elword .= "<font size=1 face='Times' color='blue'>Tipo de Finanza</font>";
$elword .= "</th><th>";
$elword .= "<font size=1 face='Times' color='blue'>Tipo de Inmueble</font>";
$elword .= "</th><th>";
$elword .= "<font size=1 face='Times' color='blue'>Valor Inmueble</font>";
$elword .= "</th><th>";
$elword .= "<font size=1 face='Times' color='blue'>Referencia de Ubicacion</font>";
$elword .= "</th><th>";
$elword .= "<font size=1 face='Times' color='blue'>Comentario </font>";
$elword .= "</th><th>";
$elword .= "<font size=1 face='Times' color='blue'>Empresa Relacionada</font>";
$elword .= "</th>";

$result3= mysql_query("select * from individuo_finanzas where parent_id= $iddoc or child_id = $iddoc");

while( $row3 =  mysql_fetch_row($result3))
{
$elword .= "<tr>";



if ($row3[1]==$iddoc){$finanza_id=$row3[2];}
else {$finanza_id=$row3[1];}
$fin0="SELECT * FROM `finanzas` WHERE `id` =".$finanza_id;
$fin1=mysql_query($fin0);
$fin2=mysql_fetch_row($fin1);

$elword .= "<td>";
$elword .= "<font size=2 face='Times'>".$row3[3] ."</font>";
$elword .= "</td>";
//codigo para sacar el lugar

if ($fin2[8]>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$fin2[8];
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$fin2[8];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$fin2[8];
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);
 $lugar_finanza= $dato1[0]." ".$dato2[0]." ".$dato3[0];
}
else
{
$lugar_finanza="No Disponible";
}






if($fin2[7]>0)
{
$elword .= "<td>";
// el id de la empresa viene bien, poner liga $fin2[7]
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$fin2[7] ."' target='_blank' >".$fin2[1] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$fin2[7] ."' target='_blank' >".$fin2[3] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$fin2[7] ."' target='_blank' >".$fin2[2] ."</font>";

$elword .= "</td><td>";

$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$fin2[7] ."' target='_blank' >".$lugar_finanza."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$fin2[7] ."' target='_blank' >".$fin2[6] ."</font>";
$elword .= "</td>";
}
else
{

$elword .= "<td>";
// si el identificador de la empresa esta vacio no poner liga
$elword .= "<font size=2 face='Times'>".$fin2[1] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$fin2[3] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$fin2[2] ."</font>";
$elword .= "</td><td>";


$elword .= "<font size=2 face='Times'>".$lugar_finanza."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$fin2[6] ."</font>";
$elword .= "</td>";
}
//echo "<font size=2 face='Times'>".$row3[10] ."</font>";

//otro select
if($fin2[7]>0)
{
  $razonsocial0= "SELECT value  FROM `document_fields_link`"
                   ." WHERE `document_field_id`= 92  AND `document_id`=".$fin2[7];
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);
  $nombre_empresarel_finanza=$razonsocial20[0];
$elword .= "<td>";
$elword .= "<font size=2 face='Times'>h<a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$empresa_id_finanza."' target='_blank' >".$nombre_empresarel_finanza."</font>";
$elword .= "</td>";
} else
{
$nombre_empresarel_finanza="No Disponible";
$elword .= "<td>";
$elword .= "<font size=2 face='Times'>".$nombre_empresarel_finanza."</font>";
$elword .= "</td>";
}

$elword .= "<td>";
$elword .= "<font size=2 face='Times'>h<a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$empresa_id_finanza."' target='_blank' >".$nombre_empresarel_finanza."</font>";
$elword .= "</td></tr>";

}





}  



//================ Termina Finanzas ==========================
$elword.="</tbody></table>";










//======================>>>>>> INICIA DOMICILIOS  ====================>>>>

//$elword.="</td></tr><tr><td>";
//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=19 and `status_id` = 1") or die("deadind1"); 
$indicedom=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste3[] = $row[0];
//$elrow=$row[0];
 $indicedom++; 
}
 

if($indicedom>0)
{
$elword .= "<br><br><font size=2 face='Times'  color='blue'><center>Domicilios</center></font><br>";
$elword .= "<table><tbody>";
$elword .= "<th>\n";
$elword .= "<font size=2 face='Times' color='blue'>Fecha <br>de Registro</font><br>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Comentario</font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Direcci&oacute;n</font><br>";$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Lugar</font><br>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fecha Final</font><br>";
$elword .= "</th>";
//$elword .= "<font size=2 face='Times' color='blue'>Fuente</font><br>";
//echo "<font size=2 face='Times' color='blue'>Tipo de Evento</font><br>";

$result3= mysql_query("select * from individuo_domicilios where parent_id= $iddoc or child_id = $iddoc");

while($row3 =  mysql_fetch_row($result3))
{
  


if ($row3[1]==$iddoc){$domicilio_id=$row3[2];}
else {$domicilio_id=$row3[1];}
$dom0="SELECT * FROM `domicilios` WHERE `id` =".$domicilio_id;
$dom1=mysql_query($dom0);
$dom2=mysql_fetch_row($dom1);

if ($dom2[2]>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$dom2[2];
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$dom2[2];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$dom2[2];
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);
 $lugar_domicilio= $dato1[0]." ".$dato2[0]." ".$dato3[0];
}
else
{
$lugar_domicilio="No Disponible";
}





if ($dom2[2]>0){

$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$dom2[2];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$Lug=explode(" ",$threev1[0]);
}
else {$Lug=explode("_"," _N/A_ _ _ ");}

$elword .= "<tr><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfindv_domic&letra=".$row3[0] ."' target='_blank'>".$row3[6] ."</a></font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfindv_domic&letra=".$row3[0] ."' target='_blank'>".$row3[3] ."</font></a>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfDomic&letra=".$dom2[0] ."' target='_blank' >".$dom2[4] ." ".$dom2[7] ."<br> C.p.".$dom2[3]."</font></a>";
$elword .= "</td><td>";

$elword .= "<font size=2 face='Times'> ".$Lug[1]." ".$Lug[2]." ".$Lug[3]." ".$Lug[4]." ".$Lug[5]." ".$Lug[6]." ".$Lug[7]." ".$Lug[8]."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$row3[5] ."</font>";
$elword .= "</td><td>";



} // cierre del for}





}  // fin de indice

//=======================>>>>> TERMINA DOMICILIOS <<<<=================
$elword.="</tbody></table>";
//*** Evento

//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=5 and `status_id` = 1") or die("deadind1"); 
$indiceev=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste3[] = $row[0];
//$elrow=$row[0];
 $indiceev++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indiceev>0)
{
$elword .= "";
$elword .= "<br><br><font size=2 face='Times'  color='blue'><center>Eventos</center></font><br>";
$elword.="<table><tbody>";
$elword .= "<th>\n";
$elword .= "<font size=2 face='Times' color='blue'>Fecha <br>de Registro</font><br>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Evento </font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Referencia de Ubicaci&oacute;n</font><br>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Comentario</font><br>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Fuente</font><br>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Tipo de Evento</font><br>";
$elword .= "</th>";



$result3= mysql_query("select * from individuo_eventos where parent_id= $iddoc or child_id = $iddoc");

while($rowevent =  mysql_fetch_row($result3))
{

if ($rowevent[1]==$iddoc){$event_id=$rowevent[2];}
else {$event_id=$rowevent[1];}
$ev0="SELECT * FROM `eventos` WHERE `id` =".$event_id;
$ev1=mysql_query($ev0);
$ev2=mysql_fetch_row($ev1);



if ($ev2[9]>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$ev2[9];
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$ev2[9];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

if ($ev2[9]>3134 && $ev2[9]<3871091){
$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$ev2[9];
$linkB1 = mysql_query($linkA1);


$dato1=mysql_fetch_row($linkB1);
}
else
{
$dato1[0]="";}

 $lugar_ev= $dato1[0]." ".$dato2[0]." ".$dato3[0];
}
else
{
$lugar_ev="No Disponible";
}
$elword .= "<tr><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfevento&letra=".$ev2[0] ."' target='_blank' >".$ev2[1] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfevento&letra=".$ev2[0] ."' target='_blank' >".$ev2[6] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$lugar_ev."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfevent_indv&letra=".$rowevent[0] ."' target='_blank' >".$rowevent[3] ."</a></font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$ev2[4] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'>".$ev2[7] ."</font>";
$elword .= "</td></tr>";

} // cierre del for}





}  // fin de indice
//** fin evento

$elword.="</tbody></table>";

//===============>>>> INICIA EVENTOB2B ============>>>

//$elword.="</td></tr><tr><td>";

//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=43 and `status_id` = 1") or die("deadind1"); 
$indiceb2b=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
//$liste3[] = $row[0];
//$elrow=$row[0];
 $indiceb2b++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indiceb2b>0)
{
//$elword .= "";
$elword .= "<br><br><font size=2 face='Times'  color='blue'><center>Eventos Empresariales</center></font><br>";
$elword.="<table width=\"50%\"><tbody>";

$elword .= "<th>\n";
$elword .= "<font size=2 face='Times' color='blue'>Fecha<br>(Date)</font><br>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Evento Empresarial</font><br>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Region</font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Amount</font>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Source</font><br>";
$elword .= "</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Summary</font><br>";
$elword .= "</th>";


$result3= mysql_query("select * from individuo_eventosb2b where parent_id= $iddoc or child_id = $iddoc");

while($row3 =  mysql_fetch_row($result3))
{



if ($row3[1]==$iddoc){$evenb_id=$row3[2];}
else {$evenb_id=$row3[1];}

/***$evenb0="SELECT * FROM eventosb2b WHERE `id` =".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);
**/





$elword .= "<tr><td>";
//Fecha
$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 109 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);
$elword.= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$row3[8] ."' target='fichas2' >".$evenb2[0] ."</font>";

$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventem_indv&letra=".$row3[0] ."' target='fichas2'>".$row3[0]."_".$row3[1] ."</font></a>";
$elword .= "</td><td>";
//Region
$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 110 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);

$elword.= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$row3[8] ."' target='fichas2' >".$evenb2[0] ."</font>";

//$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventem_indv&letra=".$row3[0] ."' target='_blank'>".$row3[7] ."</font></a>";

$elword .= "</td><td>";

$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 149 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);
//Amount
$elword.= "<font size=2 face='Times'>".$evenb2[0] ."</font>";


//$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventem_indv&letra=".$row3[0] ."' target='_blank'>".$row3[0]."_".$row3[1] ."</font></a>";
$elword .= "</td><td width=\"50\">";

$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 115 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);
//Source
$elword.= "<font size=0 face='Times'>".$evenb2[0] ."</font>";


//$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$row3[8] ."' target='_blank' >".$row3[6] ."</font>";
$elword .= "</td><td>";

$evenb0="SELECT value FROM document_fields_link WHERE `document_field_id` = 113 AND `document_id`= ".$evenb_id;
$evenb1=mysql_query($evenb0);
$evenb2=mysql_fetch_row($evenb1);
//summary
$elword .= "<font size=2 face='Times'>".$evenb2[0] ."</font>";
//$elword .= "<font size=2 face='Times'>".$row3[4] ."</font>";
$elword .= "</td></tr>";

} // cierre del for}




}  // fin de indice
//=============<<<< TERMINA EVENTOB2B <<<<<===================



$elword.="</tbody></table>";



//*** Preferencias

//$elword.="</td></tr><tr><td>";


//me quede en corregir abajo
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=17 and `status_id` = 1") or die("deadw1"); 
$indicepre=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
$liste4[] = $row[0];
 $indicepre++; 
}
// Si indice es mayor a 0 existe trayectoria
if($indicepre>0)
{
$elword .= "<br><br><center><font size=2 face='Times' color='blue' >Preferencias</font></center><br>";
//echo "";
$elword.="<table><tbody>";
$elword .="<th>";
$elword .= "<font size=2 face='Times' color='blue'>Fecha <br>de Registro</font><br>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Exponente <br>Favorito</font>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Comentario</font><br>";
$elword .="</th><th>";
$elword .= "<font size=2 face='Times' color='blue'>Actividad</font><br>";
$elword .="</th>";

//foreach ($liste4 as $ID1) {

$result3= mysql_query("select * from individuo_preferencias where parent_id= $iddoc or child_id = $iddoc");

while($row3 =  mysql_fetch_row($result3))
{
 
if ($row3[1]==$iddoc){$prefe_id=$row3[2];}
else {$prefe_id=$row3[1];}
$pref0="SELECT * FROM preferencias WHERE `id` =".$prefe_id;
$pref1=mysql_query($pref0);
$pref2=mysql_fetch_row($pref1);


$elword .= "<tr><td>";
$elword .= "<font size=2 face='Times'>".$row3[4] ."</font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfpref_indv&letra=".$row3[0] ."' target='_blank'> ".$row3[5] ."</a></font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfpref_indv&letra=".$row3[0] ."' target='_blank'>".$row3[3] ."</a></font>";
$elword .= "</td><td>";
$elword .= "<font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfprefe&letra=".$row3[5] ."' target='_blank' >".$pref2[3] ."</font></a>";
$elword .= "</td></tr>";


}





}  // fin de indice
//** fin preferencias
$elword.="</tbody></table>";


//===========>>  Busqueda de nombres de documento de Individuo   =========>>
//======== busqueda de todos aquellos documentos q sean de tipo individuo =======

// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
//$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
//$linkB = mysql_query($linkA);
 



  
$elword2 = "<table style=\"text-align: left;\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">

  <tbody>

    <tr>

      <td colspan=\"1\" rowspan=\"3\" style=\"vertical-align: top; text-align: right; width: 46px;\">
      <img style=\"width: 21px; height: 1124px;\" alt=\"\" src=\"file:///C:/Users/root/Desktop/T/Tr/Por%20Proyecto/SIDEM/margen_combinado_ficha.jpg\"></td>

      <td style=\"vertical-align: top; text-align: center; height: 50px; width: 850px;\"><img style=\"width: 800px; height: 50px;\" alt=\"\" src=\"file:///C:/Users/root/Desktop/T/Tr/Por%20Proyecto/SIDEM/cenefa.jpg\"></td>

    </tr>

    <tr>  <td style=\"width: 775px;\" align=\"undefined\" valign=\"undefined\">";




$elword3.= $elword;
//$elword3.=" <td style=\"vertical-align: top; text-align: center; height: 50px; width: 850px;\"><img style=\"width: 800px; height: 50px;\" alt=\"\" src=\"file:///C:/Users/root/Desktop/T/Tr/Por%20Proyecto/SIDEM/cenefa.jpg\"></td></tr><tr><td>".$elword. "</td></tr></table>";
$elword2.="</td>

    </tr>

    <tr>

      <td style=\"vertical-align: top; text-align: center; height: 50px; width: 850px;\" align=\"undefined\" valign=\"undefined\"></td>

    </tr>

  </tbody>
</table>";

	include("html_to_doc.inc.php");
	
	$htmltodoc= new HTML_TO_DOC();
       $htmltodoc->createDoc($elword3,"test",1);
//$htmltodoc->createDocFromURL("http://cnn.com","test2",1);
//echo $elword2;
 
 


 


 }

 ?>