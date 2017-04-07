<?php
/**
 * $Id: store.php,v 1.17 2004/12/20 10:52:57 nbm Exp $
 *
 * Page used by all editable patterns to actually perform the db insert/updates
 *
 * Expected form variables
 *	o fReturnURL
 *
 * Copyright (c) 2003 Jam Warehouse http://www.jamwarehouse.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @version $Revision: 1.17 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 */

require_once("../../../config/dmsDefaults.php");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
require_once("store.inc");

KTUtil::extractGPC('fReturnURL','fDocumentID');

if (checkSession()) {

//====>>>> actualizacion de tabla documents en caso individuo ========>>>
//if docid no vacio
$oDocument = Document::get($fDocumentID);

// $dbg="update debugg set tres =" .'"'."store".$fDocumentID.'"'."where llave=1";
//$r2 = mysql_query($dbg);


//******************************* Ajuste de Lugares


 reset($_POST);


$elzlugar="no";

 while (list($clave, $valor) = each($_POST))
 {

if ($valor=="document_field_id"){
       list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);

$selectlugar="SELECT name FROM `document_fields` WHERE id=".$valor." and name like 'k_zLugares%'";
$haylugar = mysql_query($selectlugar);
$siva=($respuesta = mysql_fetch_row($haylugar));

    if ($siva){
       list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
 list($clave, $valor) = each($_POST);
	$elzlugar=$valor;

        $sQueryactkz = "update documents as a, Lugares.Lugares as b set a.lugar=b.id, a.estado=b.cuatro, a.pais=b.cinco,a.latitud=b.seis,a.longitud=b.siete where b.id=".$elzlugar." and a.id=".$oDocument->getID();
	$sQueryactkz1 = mysql_query($sQueryactkz);
    }
   }



 
 } //while


 reset($_POST);



//********************************






$es_prom = lookupName($default->document_types_table,$oDocument->getDocumentTypeID());
 if (strncmp($es_prom,"Individuo",8) === 0 )
{



// felipe aqui codigo de modificacion de nombre


  reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {

  if ((int)$valor==8) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nnombre=$valor;

}

   if ((int)$valor==22)  {
  list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
      $aappat=$valor;
 }

 if ((int)$valor==21 )  {
  list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
      $aapmat=$valor;


 }
}

$fName =$fDocumentID."_".$aapmat." ".$aappat." ".$nnombre;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
	$oDocument->setName($fName);

	if ($oDocument->update()) {
              
              
				}
}
//============>> EVENTOS  <<=====
$es_Tipo = lookupName($default->document_types_table,$oDocument->getDocumentTypeID());

if ((strncmp($es_Tipo,"Eventos",7) === 0) && (strncmp($es_Tipo,"EventosB2B",10) != 0)) {

//$ONE = "INSERT INTO `sidem_dev141008`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('$i', '040309en unique ex: i". $es_Tipo." ', 'ea', NULL);"; 
 //$TWO = mysql_query($ONE);

$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {

 if ((int)$valor==78) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $fech=$valor;}


  if ((int)$valor==81) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $tem=$valor;}

  if ((int)$valor==18) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $temesp=$valor;}



 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

if ($temesp>0)
{
$oneev="SELECT `name` FROM `documents` WHERE `id` =".$temesp;
$twoev=mysql_query($oneev);
$threev=mysql_fetch_row($twoev);

$Lug=explode(" ",$threev[0]);
}
else
{$Lug=array("","");}
$fName =$fDocumentID."_ ".$fech."_".$tem."_".$Lug[1]." ".$Lug[2];
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
	$oDocument->setName($fName);

	if ($oDocument->update()) {
}
}

if (strncmp($es_Tipo,"EventosB2B",10) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {



 if ((int)$valor==109) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $fech=$valor;}

 if ((int)$valor==161) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $lugar=$valor;}

 if ((int)$valor==142) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $competidor=$valor;}

 if ((int)$valor==136) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $compdyn=$valor;}

 if ((int)$valor==137) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $tech=$valor;}

 if ((int)$valor==138) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $corp=$valor;}

 if ((int)$valor==139) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $sust=$valor;}






 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

if ($lugar>0){
$one="SELECT A.`dos` FROM `Lugares`.`Pais` as A , `Lugares`.`Lugares` as B WHERE A.id = B.cinco and B.id=".$lugar;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnom=$three[0];
}
else {$partnom="";}

if ($competidor>0){
$one="SELECT `name` FROM `documents`  WHERE  id=".$competidor;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnomcomp=$three[0];
//$ONE = "INSERT INTO `sidem_dev141008`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('050309', 'compe ". $competidor." ', 'ea', NULL);"; 
// $TWO = mysql_query($ONE);
}
else {$partnomcomp="";}

if ($compdyn=="Yes"){
 $pncd="Competitive Dynamic";}

if ($tech=="Yes"){
 $pnt="Technology";}

if ($corp=="Yes"){
 $pncrp="Corporate";}
if ($sust="Yes"){
 $pnsust="Sustainability";}


//$Subsidiaria=explode("/",$three[0]);
$fName =$fDocumentID."_ ".$fech." ".$partnom." ".$partnomcomp." ".$pncd." ".$pnt." ".$pncrp." ".$pnsust;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

reset($_POST);

$oDocument->setName($fName);

	if ($oDocument->update()) {
}


//$fName =$fDocumentID." ".$fech;


 
}


//============>> EVENTOS PESC <<=====

if (strncmp($es_Tipo,"EventosPESC",11) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {

 if ((int)$valor==109) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $fech=$valor;}

 if ((int)$valor==110) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $region=$valor;}

 if ((int)$valor==161) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $city=$valor;}

 if ((int)$valor==164) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $typeof=$valor;}

 if ((int)$valor==113) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $summ=$valor;}

 if ((int)$valor==114) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $note=$valor;}

 if ((int)$valor==264) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $summ0=$valor;}

if ((int)$valor==273) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $ispoli=$valor;}

if ((int)$valor==274) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $isecon=$valor;}

if ((int)$valor==275) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $issocial=$valor;}

if ((int)$valor==276) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $iscont=$valor;}

if ((int)$valor==82) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $source=$valor;}


 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$elId= "SELECT MAX(`id`+ 1) FROM `documents`";
$elquery2=mysql_query($elId);
$elId2= mysql_fetch_row($elquery2);
$fName3=$elId2[0]."_".$fName3;

if ($lugar>0){
$one="SELECT A.`dos` FROM `Lugares`.`Pais` as A , `Lugares`.`Lugares` as B WHERE A.id = B.cinco and B.id=".$lugar;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnom=$three[0];
}
else {$partnom="";}

if ($competidor>0){
$one="SELECT `name` FROM `documents`  WHERE  id=".$competidor;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnomcomp=$three[0];
}
else {$partnomcomp="";}

if ($compdyn=="Yes"){
 $pncd="Competitive Dynamic";}

if ($tech=="Yes"){
 $pnt="Technology";}

if ($corp=="Yes"){
 $pncrp="Corporate";}
if ($sust=="Yes"){
 $pnsust="Sustainability";}


//$Subsidiaria=explode("/",$three[0]);
$fName =$fName3." ".$fech." ".$partnom." ".$partnomcomp." ".$pncd." ".$pnt." ".$pncrp." ".$pnsust;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
}


//============>> DOMICILIO  <<=====
if (strncmp($es_prom,"Domicilio",9) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {


 if ((int)$valor==133) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $call=$valor;}

  if ((int)$valor==18) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $lug=$valor;}

 if ((int)$valor==134) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $num=$valor;}

  if ((int)$valor==135) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $col=$valor;}
 



 }

 //========== busqueda para encontrar id del documento que se crea=========>>>


$fName =$fDocumentID."_ ".$fName." ".$call." ".$num." ".$col." ".$Lug[2];
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
$oDocument->setName($fName);

	if ($oDocument->update()) {
}
}
//============>> PREFERENCIAS  <<=====
if (strncmp($es_prom,"Preferencias",12) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==4) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $name=$valor;}

 if ((int)$valor==15) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $tipo=$valor;}

 }

$fName =$fDocumentID."_ ".$fName." ".$name." ".$tipo;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
$oDocument->setName($fName);

	if ($oDocument->update()) {
}
}

//============>> FINANZAS  <<=====
if (strncmp($es_prom,"Finanzas",8) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==9) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $ntipofin=$valor;}

 if ((int)$valor==11) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $moned=$valor;}

 }

 //========== busqueda para encontrar id del documento que se crea=========>>>


$fName =$fDocumentID."_ ".$fName." ".$ntipofin." ".$moned;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
$oDocument->setName($fName);

	if ($oDocument->update()) {
}
}
//============>> Inst/Organ  <<=====
if (strncmp($es_prom,"Instituto/Organizacion",11) === 0) {
$mibool=1;
   reset($_POST);
$debe=0;
 while (list($clave, $valor) = each($_POST))
 {

$numvalor=(int)$valor;
  if ($numvalor===57) {
   
     list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
      $nph=$valor;
      $valor=0;
      
}


 $numvalor=(int)$valor;
  if (($numvalor===92)) {
     list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
      $ninst=$valor;}
 

$numvalor=(int)$valor;

 if ($numvalor=== 262) {
     while ($valor != "value" ){
        list($clave, $valor) = each($_POST);
      }
       
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $lugar=$valor;}

 }

 //========== busqueda para encontrar id del documento que se crea=========>>>


if ($lugar>0){
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$lugar;
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$lugar;
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$lugar;
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);

$partnom=" $dato1[0]_$dato2[0]_$dato3[0]";
}
else {$partnom="";}

$fName =$fDocumentID."_ ".$ninst.$partnom;
$fName1011=$fName;
$fName=limpiaFname($fName1011);
 reset($_POST);
$oDocument->setName($fName);

	if ($oDocument->update()) {


}
else{
//$ONE = "INSERT INTO `sidem_dev141008`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('1334', '$fName', '050410', NULL);"; 
 //$TWO = mysql_query($ONE);

}
}

//============>> LUGARES  <<=====

if (strncmp($es_prom,"Lugares",7) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {

 if ((int)$valor==77) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $mun=$valor;}

 if ((int)$valor==16) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $pais=$valor;}

 if ((int)$valor==38) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $state=$valor;}
 }

 //========== busqueda para encontrar id del documento que se crea=========>>>



$unos="SELECT `name` FROM `documents` WHERE `id` ='".$state."'";
$doss=mysql_query($unos);
$tress=mysql_fetch_row($doss);

$uno="SELECT `name` FROM `documents` WHERE `id` ='".$pais."'";
$dos=mysql_query($uno);
$tres=mysql_fetch_row($dos);

$PaIs=explode("_",$tres[0]);

$Muni=explode("_",$tresm[0]);

$Stat=explode("_",$tress[0]);


$fName =$fDocumentID."_ ".$mun." ".$Stat[1]." ".$PaIs[1];
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
$oDocument->setName($fName);

	if ($oDocument->update()) {
}
}

//============>> SEGUIMIENTO <<=====

if (strncmp($es_prom,"Seguimiento",11) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==4) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nname=$valor;}

 
 }

 //========== busqueda para encontrar id del documento que se crea=========>>>

$fName =$fDocumentID."_ ".$nname;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
$oDocument->setName($fName);

	if ($oDocument->update()) {
}
}

//============>> PAIS <<=====

if (strncmp($es_prom,"Pais",5) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==4) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nname=$valor;}

 
 }

 //========== busqueda para encontrar id del documento que se crea=========>>>



$fName =$fDocumentID."_ ".$nname;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
$oDocument->setName($fName);

	if ($oDocument->update()) {
}
}

//============>> ESTADOS <<=====

if (strncmp($es_prom,"Estado",6) === 0) {
$mibool=1;
   reset($_POST);
 while (list($clave, $valor) = each($_POST))
 {




  if ((int)$valor==4) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nname=$valor;}

 if ((int)$valor==8) {
        list($clave, $valor) = each($_POST);
     list($clave, $valor) = each($_POST);
    list($clave, $valor) = each($_POST);
      $nname1=$valor;}
 
 }

 //========== busqueda para encontrar id del documento que se crea=========>>>


$fName =$fDocumentID."_ ".$nname." ".$nname1;
$fName1011=$fName;
$fName=limpiaFname($fName1011);

 reset($_POST);
$oDocument->setName($fName);

	if ($oDocument->update()) {
}
}


// felipe


    if (count($_POST) > 0) {
        $aKeys = array_keys($_POST);
        $aQueries = constructQuery($aKeys);
        
        //execute the queries
        for ($i=0; $i<count($aQueries); $i++) {
            $sql = $default->db;
            $sql->query($aQueries[$i]);
        }
//$bQueries = constructQuery($aKeys);
$ONE ="
INSERT INTO  `sidem210708`.`user_modifications` (
`id` ,
`document_id` ,
`document_fields_link_id` ,
`user_id` ,
`fechahora` ,
`instruccion`
)
VALUES (
NULL , ".$fDocumentID.",'',  '".$_SESSION["userID"]."',NOW(),  '')"; 
$TWO = mysql_query($ONE);
        $default->log->debug("store.php redirecting to $fReturnURL");
        redirect(strip_tags(urldecode($fReturnURL)));
    }
}
 
function limpiaFname($pfName) {
	global $default;


$As = array("Á","À","Ä","Â");
$Es = array("É","È","Ë","Ê");
$Is = array("Í","Ì","Ï","Î");
$Os = array("Ó","Ò","Ö","Ô");
$Us = array("Ú","Ù","Ü","Û");
$Aas = array("á","à","ä","â");
$Ees = array("é","è","ë","ê");
$Iis = array("í","ì","ï","î");
$Oos = array("ó","ò","ö","ô");
$Uus = array("ú","ù","ü","û");
$simbolos = array("¡","¿","?","'","´","]","}","[","{","^","`","\\","¬","|","°","<",">",",","*","+","!","\"","#","$","%","&","(",")","=","¨","*","~",":",";");



$fName1011=$pfName;
$pfName=str_replace("/","_",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($As,"A",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Es,"E",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Is,"I",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Os,"O",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Us,"U",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Aas,"a",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Ees,"e",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Iis,"i",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Oos,"o",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Uus,"u",$fName1011);


$fName1011=$pfName;

$pfName=str_replace($simbolos,"#",$fName1011);
$fName1011=$pfName;

$pfName=str_replace("ñ","n",$fName1011);
$fName1011=$pfName;


$pfName=str_replace("Ñ","N",$fName1011);







 return $pfName;
     }


 

?>
