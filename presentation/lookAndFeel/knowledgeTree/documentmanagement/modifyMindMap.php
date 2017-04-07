<?php
require_once("../../../../config/dmsDefaults.php");

require_once("FirePHPCore/FirePHP.class.php4");
require_once("MM_ficha.php");
require_once("MM_Relaciones.php");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentCollaboration.inc");

ob_start();
$firephp=FirePHP::getInstance(true);
//$var=array('i'=>10,'j'=>20);
//$firephp->log($var,'Iteradores');
$errorr="";
//$finarchivo=1;
$banderafetch=0;
$id_doc = $_GET["idd"];
$idnodo = $_GET["idnodo"];
$tipo = $_GET["tipo"];
$numinstr = $_GET["numinstr"];
$paquetin="";
//$oDocument = & Document::get($iddoc);
$indiceToken=0; 
$indiceHelix=0;
$indicePH=0;
$palabras="";
$resulta="";
$helix="";
$nodoOrigen="";
$arrayPadresHijos=""; //array de padres e hijos
$arrayIDIndx=""; //array donde el indice es el id de los nodos
$eldoc="";

 
//$default->rootUrl

//documento de pruebas 14599

function fInsertaNodo($id_nodo,$contenido_nodo)
{//Recibe id de nodo donde se realizara insercion y el contenido de el nodo a insertar
 //debe consultar si terminacion de nodo es /> , de ser asi cambiar por terminacion > + </node>
  global $helix;
  global $indiceHelix;
  global $arrayPadresHijos;
  global $arrayIDIndx;
  global $errorr;
  global $paquetin;  // me quede preparando paquetin para debug 15/07/10
  //global $firephp;
  $errorr=$helix[$arrayIDIndx[$id_nodo]["NODOF"]]." ".strcmp($helix[$arrayIDIndx[$id_nodo]["NODOF"]],"/>\n");
  //$firephp->log($helix[$arrayIDIndx[$id_nodo]["NODOF"]],'condicion');
  if (strcmp($helix[$arrayIDIndx[$id_nodo]["NODOF"]],"/>\n")==0) 
     {
       //$firephp->log($arrayIDIndx[$id_nodo],'Iteradores');
      $helix[$arrayIDIndx[$id_nodo]["NODOF"]]=">"; 
      $helix[$arrayIDIndx[$id_nodo]["NODOF"]+1]=$contenido_nodo;
      $helix[$arrayIDIndx[$id_nodo]["NODOF"]+2]="</node>";
     }
  else
    {
      //$firephp->log($arrayIDIndx[$id_nodo],'Iteradores_else');
$numresta=$arrayIDIndx[$id_nodo]["NODOF"]-1;
      $helix[$numresta]=$contenido_nodo;
    }
  if (  $helix[$arrayIDIndx[$id_nodo]["LINK="]]!="")
    {
  $helix[$arrayIDIndx[$id_nodo]["LINK="]]="";
  $helix[$arrayIDIndx[$id_nodo]["LINK="]+5]="";
    }
}


function TRAY($nivel, &$row,$pIdnodo,$comnd)

{ global $resulta;
  global $finarchivo;
  //global $firephp;
  $sMapa="";
  //$firephp->trace('Trace Level');
  if ($nivel==0) { $finarchivo=($row =  mysql_fetch_row($resulta));}
  if ($finarchivo){

    $tCreacion="1274726578281"; //php tiene funcion para tiempo en formato longint
 $tModificado="1274731944034"; 
 
 // el id de nodo tipo trayectoria: NT_50_valordocfieldlink_nrandom (50 es el campo tipotray)
 $numrr=rand(100000,200000);
 $idNodo= "TRAY_campsect-o-sect_50_".$row[3]."_".$numrr;
 $tipoTray=$row[3];

 //abajo parte tipotray de gramatica 
 $sMapa.='<node CREATED= "'.$tCreacion.'" FOLDED="true" ID="'.$idNodo.'"  MODIFIED= "'.$tModificado.'"  TEXT= "'.$tipoTray.'" >';
 $sMapa.=EMPRE($tipoTray,$row,$idNodo,$comnd);
 $sMapa.='</node>'."\n";
 $nivel++;
 $sMapa.=TRAY($nivel,$row,$pIdnodo,$comnd);

 return $sMapa;
  }
  else {
    if ($comnd==1){
     return CMND("TRAY_campsect-sect",$pIdnodo);
    } else {
      return "";}

  }
}

  function EMPRE($tipoTray,&$row,$pIdnodo,$comnd)
{
  global $resulta;
  $sMapa="";
  //$row =  mysql_fetch_row($resulta);
 if($row[3]==$tipoTray)
    {
 

 $tCreacion="1274726578281";
 $tModificado="1274731944034"; 
 // el id de nodo documento empresa: ND_iddocSY_22_nrandom (22 es el tipo para inst/Org en SY)
 $numrr=rand(100000,200000);
 $idNodo= "EMPRE_idemp_22_".$row[1]."_".$numrr;
 $texto=utf8_encode($row[2]);

 //abajo parte tipotray de gramatica 
 $sMapa.='<node CREATED= "'.$tCreacion.'" FOLDED="true" ID="'.$idNodo.'"  MODIFIED= "'.$tModificado.'"  TEXT= "'.$texto.'" >';

 $sMapa.=PUESTOS($row[1],$row,$idNodo,$comnd);
 $sMapa.='</node>'."\n";
 $sMapa.=EMPRE($tipoTray,$row,$pIdnodo,$comnd);
 //$sMapa.=CMND($row[1]);   
 return $sMapa;
}
 else { if ($comnd==1){$sMapa.=CMND($row[1],$pIdnodo); return $sMapa;}
   else {return $sMapa;}}

}

  function PUESTOS($empresa,&$row,$pIdnodo,$comnd)
{
 global $resulta;
  $sMapa="";
  if($row[1]==$empresa)
    {
 

 $tCreacion="1274726578281";
 $tModificado="1274731944034"; 
 // el id de nodo documento empresa: ND_iddocSY_4_nrandom (4 es el tipo para trayectoria en SY)
 $numrr=rand(100000,200000);
 $idNodo= "PUESTOS_idtray_4_".$row[0]."_".$numrr;
 $texto=utf8_encode($row[4]);
 if ($texto==""){$texto="Sin Fecha Registrada";}

 //abajo parte tipotray de gramatica 
 $sMapa.='<node CREATED= "'.$tCreacion.'" FOLDED="true" ID="'.$idNodo.'"  MODIFIED= "'.$tModificado.'"  TEXT= "'.$texto.'" >';

 $sMapa.=DATOS($row[0],$row,$idNodo,$comnd);
 $sMapa.='</node>'."\n";
 
 $sMapa.=PUESTOS($empresa,$row,$pIdnodo,$comnd);
 //$sMapa.=CMND($row[0]);
 return $sMapa;   
 }
  else { if ($comnd==1){$sMapa.=CMND($row[0],$pIdnodo); return $sMapa;}
   else {return $sMapa;}}
 

}

  function DATOS($puestoTrayectoria,&$row,$pIdnodo,$comnd)
{
  //vacia los datos y los pone en nodes consecutivos con terminacion />,row apunta a siguiente tray
 global $resulta;
 global $finarchivo;
  $sMapa="";
  if($row[0]==$puestoTrayectoria)
    {
 

 $tCreacion="1274726578281";
 $tModificado="1274731944034"; 
 // el id de campo documento empresa: NC_idcampo_nrandom
 $numrr=rand(100000,200000);
 $idNodo= "DATOS_camptray-o-document-field-id_N_".$row[5]."_".$numrr;

 $texto=utf8_encode($row[6]);

 //abajo parte tipotray de gramatica 
 if ($texto!="")
   {
 $sMapa.='<node CREATED= "'.$tCreacion.'" ID="'.$idNodo.'"  MODIFIED= "'.$tModificado.'"  TEXT= "'.$texto.'" />';
   }
 
 
 while($finarchivo)
   {
    $finarchivo=($row =  mysql_fetch_row($resulta));
 if ($finarchivo)
   {
     if ($row[0]!=$puestoTrayectoria){break;}
     else { 
       $tCreacion="1274726578281";
       $tModificado="1274731944034"; 
       // el id de campo documento empresa: NC_idcampo_nrandom
       $numrr=rand(100000,200000);
       $idNodo= "ND_".$row[5]."_".$numrr;
       $texto=utf8_encode($row[6]);
       //abajo parte tipotray de gramatica 
       $sMapa.='<node CREATED= "'.$tCreacion.'" ID="'.$idNodo.'"  MODIFIED= "'.$tModificado.'"  TEXT= "'.$texto.'" />';
     }
   }
 else break;
   }
 
 return $sMapa;

 }
  else {if ($comnd==1){$sMapa.=CMND($row[0],$pIdnodo); return $sMapa;}
   else {return $sMapa;}}
  

}

function generaInstruccion($nombre_nodo, $num_instr,$tipopar)
{
  global $eldoc;
  global $id_doc;
  global $default;

  if ($num_instr==1){
$enlace= "http://".$default->serverName.$default->rootUrl."/control.php?action=modifymindmap&idd=".$id_doc."&tipo=4&numinstr=1&elmapa=".$eldoc."&idnodo=".$nombre_nodo;
$include='LINK="'.$enlace.'"';
  } else if ($num_instr==2){
$enlace= "http://".$default->serverName.$default->rootUrl."/control.php?action=modifymindmap&idd=".$id_doc."&numinstr=2&elmapa=".$eldoc."&idnodo=".$nombre_nodo;
$include='LINK="'.$enlace.'"';
  }
else if ($num_instr==3){
  // a partir de aqui sacar el rescan, usando array de padres e hijos 
$enlace= "http://".$default->serverName.$default->rootUrl."/control.php?action=modifymindmap&idd=".$id_doc."&numinstr=3&elmapa=".$eldoc."&idnodo=".$nombre_nodo;
$include='LINK="'.$enlace.'"';
  }
else if ($num_instr!=5){
  // a partir de aqui sacar el rescan, usando array de padres e hijos 
  $expid= explode("_",$nombre_nodo);
$enlace= "http://".$default->serverName.$default->rootUrl."/control.php?action=modifymindmap&idd=".$expid[3]."&tipo=".$tipopar."&numinstr=".$num_instr."&elmapa=".$eldoc."&idnodo=".$nombre_nodo;
$include='LINK="'.$enlace.'"';
  }
else if ($num_instr==5){
  // a partir de aqui sacar el rescan, usando array de padres e hijos 
  $expid= explode("_",$nombre_nodo);
$enlace= "http://".$default->serverName.$default->rootUrl."/control.php?action=modifymindmap&idd=".$expid[1]."&tipo=".$tipopar."&numinstr=5&elmapa=".$eldoc."&idnodo=".$nombre_nodo;
$include='LINK="'.$enlace.'"';
  }
 return $include;
}

function CMND($quien,$pIdnodo)
{  //debe recibir nombre de nodo y ..
  $numrr=rand(100000,200000);
  $sMap='<node CREATED="1276205457253" FOLDED="true" ID="NCMD_'.$quien.'_'.$numrr.'" MODIFIED="1276205459917" TEXT="cmd">';
  $sMap.='<node CREATED="1276205489893" ID="NSCAN_'.$quien.'_'.$numrr.'" '.generaInstruccion($pIdnodo,3,"").' MODIFIED="1276205493197" TEXT="rescan"/>';
  $sMap.='<node CREATED="1276205501115" ID="NDEL_'.$quien.'_'.$numrr.'" '.generaInstruccion($pIdnodo,2,"").' MODIFIED="1276205504546" TEXT="borrar"/>';
  $sMap.='</node>'."\n";
  return $sMap;
}



function fCalculaRama($tipo_desarrollar,$id_doc_origen,$where1,$funcionsem,$cmnd)
{
  global $resulta;
  global $idnodo;
  global $paquetin;
  global $firephp;
  /*** funcion recibe el tipo a desarrollar de document_types_lookup, cada tipo puede recibir diferente trato
   a la hora de desarrollar el mapa mental.
   Esta funcion debe calcular la nueva rama de nodos y sus nuevos PARAMS
  ***/

  // sacar trayectoria de la base de datos

  if ($tipo_desarrollar==4)
    { 

$consultaTrayectoria="SELECT idtray, idemp, campos.value, campsect.sect, campfechop.fop, camptray.document_field_id, camptray.value ";
$consultaTrayectoria.="FROM ( ";
$consultaTrayectoria.="( ";

$consultaTrayectoria.="SELECT id AS idtray, child_document_id AS idemp ";
$consultaTrayectoria.="FROM `documents` ";
$consultaTrayectoria.="WHERE `document_type_id` = 4 and status_id <=2 ";
$consultaTrayectoria.="AND `parent_document_id` =".$id_doc_origen." ";
$consultaTrayectoria.=") ";
$consultaTrayectoria.="UNION ( ";

$consultaTrayectoria.="SELECT id AS idtray, parent_document_id AS idemp ";
$consultaTrayectoria.="FROM `documents` ";

$consultaTrayectoria.="WHERE `document_type_id` = 4 and status_id <=2 ";
$consultaTrayectoria.="AND `child_document_id` =".$id_doc_origen." ";
$consultaTrayectoria.=") ";
$consultaTrayectoria.=") AS uniemp ";
$consultaTrayectoria.="LEFT JOIN document_fields_link AS camptray ON camptray.document_id = uniemp.idtray ";
$consultaTrayectoria.="LEFT JOIN ( ";

$consultaTrayectoria.="SELECT document_id, value AS sect ";
$consultaTrayectoria.="FROM document_fields_link ";
$consultaTrayectoria.="WHERE document_field_id =50 ";
$consultaTrayectoria.=") AS campsect ON campsect.document_id = uniemp.idtray ";
$consultaTrayectoria.="LEFT JOIN ( ";

$consultaTrayectoria.="SELECT document_id, value AS fop ";
$consultaTrayectoria.="FROM document_fields_link ";
$consultaTrayectoria.="WHERE document_field_id =24 ";
$consultaTrayectoria.=") AS campfechop ON campfechop.document_id = uniemp.idtray, document_fields_link AS campos ";
$consultaTrayectoria.="WHERE campos.document_id = uniemp.idemp ";
$consultaTrayectoria.="AND campos.document_field_id =92 ".$where1;
$consultaTrayectoria.="ORDER BY campsect.sect ASC , campfechop.fop DESC ";
$resulta= mysql_query($consultaTrayectoria);
//echo $consultaTrayectoria;
  //print_r($row,true);
//$paquetin.=" el sql ".$consultaTrayectoria." \n ";
 
 return $funcionsem(0,$row1,$idnodo,$cmnd);
 
    }
  else
 if ($tipo_desarrollar==20)
    { 

$consultarelacion.='SELECT idrel, idindiv, campsect.tiporel, campfechop.direcc,  concat(campnom.nom," ",campap.ap," ",campam.am) as nombre, base ';
$consultarelacion.='FROM (';

$consultarelacion.='(';

$consultarelacion.='SELECT id AS idrel, child_document_id AS idindiv, 1 AS base ';
$consultarelacion.='FROM `documents`';
$consultarelacion.='WHERE `document_type_id` = 20 and status_id <=2 ';
$consultarelacion.='AND `parent_document_id` ='.$id_doc_origen.'';
$consultarelacion.=')';
$consultarelacion.='UNION (';

$consultarelacion.='SELECT id AS idrel, parent_document_id AS idindiv, 0 AS base ';
$consultarelacion.='FROM `documents`';

$consultarelacion.='WHERE `document_type_id` = 20 and status_id <=2 ';
$consultarelacion.='AND `child_document_id` ='.$id_doc_origen.'';
$consultarelacion.=')';
$consultarelacion.=') AS unirel ';

$consultarelacion.='LEFT JOIN (';

$consultarelacion.='SELECT document_id, value AS tiporel ';
$consultarelacion.='FROM document_fields_link ';
$consultarelacion.='WHERE document_field_id =26';
$consultarelacion.=') AS campsect ON campsect.document_id = unirel.idrel ';


$consultarelacion.='LEFT JOIN (';


$consultarelacion.='SELECT document_id, value AS direcc ';
$consultarelacion.='FROM document_fields_link ';
$consultarelacion.='WHERE document_field_id =85 ';
$consultarelacion.=') AS campfechop ON campfechop.document_id = unirel.idrel ';
$consultarelacion.='LEFT JOIN (';


$consultarelacion.='SELECT document_id, value AS nom ';
$consultarelacion.='FROM document_fields_link ';
$consultarelacion.='WHERE document_field_id =8';
$consultarelacion.=') AS campnom ON campnom.document_id = unirel.idindiv ';
$consultarelacion.='LEFT JOIN (';


$consultarelacion.='SELECT document_id, value AS ap ';
$consultarelacion.='FROM document_fields_link ';
$consultarelacion.='WHERE document_field_id =21';
$consultarelacion.=') AS campap ON campap.document_id = unirel.idindiv ';
$consultarelacion.='LEFT JOIN (';


$consultarelacion.='SELECT document_id, value AS am ';
$consultarelacion.='FROM document_fields_link ';
$consultarelacion.='WHERE document_field_id =22';
$consultarelacion.=') AS campam ON campam.document_id = unirel.idindiv ';
  $consultarelacion.='order by campsect.tiporel ASC, campfechop.direcc ASC';

$firephp->log($consultarelacion,'checksconsulta');

$resulta= mysql_query($consultarelacion);
//echo $consultaTrayectoria;
  //print_r($row,true);
//$paquetin.=" el sql ".$consultaTrayectoria." \n ";
 $firephp->log($funcionsem,'checksem');
$firephp->log($idnodo,'checknodo');
$algo=  $funcionsem(0,$row1,$idnodo,$cmnd);
 $firephp->log($algo,'checkalgo');
 //return $funcionsem(0,$row1,$idnodo,$cmnd);
 return $algo;
  
    }
  
 if ($tipo_desarrollar==41)
    {

      $consultab2b.='SELECT idempev, idev, YEAR( campsect.ano ) AS anio , MONTHNAME( campsect.ano ) AS mes ,CONCAT(IF(STRCMP(cd,"YES")=0,"Competitive Dynamic ",""),IF(STRCMP(corp,"YES")=0,"Corporate ",""),IF(STRCMP(opp,"YES")=0,"Oportunity ",""),IF(STRCMP(react,"YES")=0,"Reaction ",""),IF(STRCMP(sust,"YES")=0,"Sustainability ",""),IF(STRCMP(tech,"YES")=0,"Technology ","")) AS eventtype, summary';
$consultab2b.='FROM ( ';
$consultab2b.='( ';

$consultab2b.='SELECT id AS idempev, child_document_id AS idev ';
$consultab2b.='FROM `documents` ';
$consultab2b.='WHERE `document_type_id` =41 ';
$consultab2b.='AND status_id <=2 ';
$consultab2b.='AND `parent_document_id` ='.$id_doc_origen.' ';
$consultab2b.=') ';
$consultab2b.='UNION ( ';

$consultab2b.='SELECT id AS idempev, parent_document_id AS idev ';
$consultab2b.='FROM `documents` ';
$consultab2b.='WHERE `document_type_id` =41 ';
$consultab2b.='AND status_id <=2 ';
$consultab2b.='AND `child_document_id` ='.$id_doc_origen.' ';
$consultab2b.=') ';
$consultab2b.=') AS unirel ';
$consultab2b.='LEFT JOIN ( ';

$consultab2b.='SELECT document_id, value AS ano ';
$consultab2b.='FROM document_fields_link ';
$consultab2b.='WHERE document_field_id =109 ';
$consultab2b.=') AS campsect ON campsect.document_id = unirel.idev ';

$consultab2b.='LEFT JOIN ( ';

$consultab2b.='SELECT document_id, value AS cd ';
$consultab2b.='FROM document_fields_link ';
$consultab2b.='WHERE document_field_id =136 ';
$consultab2b.=') AS campcd ON campcd.document_id = unirel.idev ';

$consultab2b.='LEFT JOIN ( ';

$consultab2b.='SELECT document_id, value AS corp ';
$consultab2b.='FROM document_fields_link ';
$consultab2b.='WHERE document_field_id =138 ';
$consultab2b.=') AS corp ON corp.document_id = unirel.idev ';
$consultab2b.='LEFT JOIN ( ';

$consultab2b.='SELECT document_id, value AS opp ';
$consultab2b.='FROM document_fields_link ';
$consultab2b.='WHERE document_field_id =183 ';
$consultab2b.=') AS opp ON opp.document_id = unirel.idev ';
$consultab2b.='LEFT JOIN ( ';

$consultab2b.='SELECT document_id, value AS react ';
$consultab2b.='FROM document_fields_link ';
$consultab2b.='WHERE document_field_id =186 ';
$consultab2b.=') AS react ON react.document_id = unirel.idev ';

$consultab2b.='LEFT JOIN ( ';

$consultab2b.='SELECT document_id, value AS sust ';
$consultab2b.='FROM document_fields_link ';
$consultab2b.='WHERE document_field_id =139 ';
$consultab2b.=') AS sust ON sust.document_id = unirel.idev ';

$consultab2b.='LEFT JOIN ( ';

$consultab2b.='SELECT document_id, value AS tech ';
$consultab2b.='FROM document_fields_link ';
$consultab2b.='WHERE document_field_id =137 ';
$consultab2b.=') AS tech ON tech.document_id = unirel.idev ';
$consultab2b.='LEFT JOIN ( ';

$consultab2b.='SELECT document_id, value AS summary ';
$consultab2b.='FROM document_fields_link ';
$consultab2b.='WHERE document_field_id =113 ';
$consultab2b.=') AS campsummary ON campsummary.document_id = unirel.idev ';
$consultab2b.='ORDER BY campsect.ano DESC , cd ASC ,corp ASC, opp ASC, react ASC, sust ASC, tech ASC  ';
 
$resultb2b= mysql_query($consultab2b);
$some=  $funcionsem(0,$row1,$idnodo,$cmnd);
 return $some;
    }

}

function chequeo($stringsillo)
{
  global $paquetin;
  $paquetin.=$stringsillo;
}

function fReScan($id_nodo,&$func,&$id_del_doc,&$tipo_del_doc,&$where1)
{ global $paquetin;
  global $arrayPadresHijos;
  global $arrayIDIndx;
  $iCuenta=0;
 
  for($iCuenta=0 ; $iCuenta < count($arrayPadresHijos);$iCuenta++)
    {
      //$paquetin.=$iCuenta."-".$arrayPadresHijos[$iCuenta][PADRE]."\n";
      if ($arrayPadresHijos[$iCuenta][PADRE]==$id_nodo)
	{  
          // $paquetin.="si entre \n";
          // $paquetin.=$arrayIDIndx[$arrayPadresHijos[$iCuenta][HIJO]][TEXT]."\n";
           $explotado=explode("_",$arrayPadresHijos[$iCuenta][HIJO]);
           $explotadoP=explode("_",$arrayPadresHijos[$iCuenta][PADRE]);
           $id_del_doc=$explotadoP[1];
           $tipo_del_doc=$explotadoP[2];
           //$paquetin.=print_r($explotado,true)."\n";
	   if ($explotado[0]!="NCMD")
	     {
               $lacol=str_replace("-o-",".",$explotado[1]);
               $where1.=" AND ".$lacol." != '".$explotado[3]."' ";
               $func=$explotado[0];     
             } else {  $func=$explotado[1]; }

	}

    }

}


function fBorraRelleno($idnodo)
{ global $arrayIDIndx;
  global $helix;
  // global $paquetin;
  
  //Reinserta Link de Instruccion
  //encontrar en  helix nodoi de nodocmd, desde nodom+1 hasta nodof-1, despues borrar desde nodoi hasta nodoicmd-1
  //$paquetin.=" el id nodo".$idnodo." el nodoi ".$arrayIDIndx[$idnodo]["NODOI"]." el nodof ".$arrayIDIndx[$idnodo]["NODOF"];
  
  for ($indiceN=$arrayIDIndx[$idnodo]["NODOI"];$indiceN < $arrayIDIndx[$idnodo]["NODOF"] ;$indiceN++)
    {
      if (strncmp($helix[$indiceN],'"NCMD_',6)==0) 
            {
              $icmd=str_replace('"',"", $helix[$indiceN]);
              $inicioCMD= $arrayIDIndx[$icmd]["NODOI"]-1;
               $finCMD= $arrayIDIndx[$icmd]["NODOF"];
	       //$paquetin.=" el id del comd ".$helix[$indiceN]." el nodoi ".$idnodo." y inicio ".$inicioCMD."idnodo i".$arrayIDIndx[$idnodo]["NODOI"]; 
	    }
    }
  for ($indiceN=$arrayIDIndx[$idnodo]["NODOM"];$indiceN<$inicioCMD;$indiceN++)
    {  $indexN=$indiceN+1;
       $helix[$indexN]="";
       }
 for ($indiceN1=$finCMD;$indiceN1<$arrayIDIndx[$idnodo]["NODOF"]-1;$indiceN1++)
    {  $indexN1=$indiceN1+1;
       $helix[$indexN1]="";
       }


}


function fInit($archivo)
{
$indiceToken=0;
$handle = fopen($archivo, "r");
$contents = fread($handle, filesize($archivo));
fclose($handle);
$contents=str_replace("=","= ", $contents);
$contents=str_replace('"', ' " ', $contents);
$contents=str_replace(">", "> ", $contents);
$contents=str_replace("/>", " />", $contents);
$contents=str_replace("-->", " -->", $contents);
$contents=str_replace("\n", " ", $contents);
 $contents=str_replace("   ", " ", $contents);
 $contents=str_replace("  ", " ", $contents);
 $contents=str_replace("  ", " ", $contents);
$contents=str_replace("  ", " ", $contents);
$contents=str_replace("src= ", "src=", $contents);
$contents=str_replace("action= ", "action=", $contents);
$contents=str_replace("idnodo= ", "idnodo=", $contents);
$contents=str_replace("idd= ", "idd=", $contents);
$contents=str_replace("tipo= ", "tipo=", $contents);
$contents=str_replace("numinstr= ", "numinstr=", $contents);
$contents=str_replace("elmapa= ", "elmapa=", $contents);
$contents=str_replace("idnodo= ", "idnodo=", $contents);
 $datos=explode(" ",$contents);
 return $datos;
}

function fgetToken()
{
  global $indiceToken;
  global $palabras;
  
  $identif="";
  $tokens="";
  $tokens=$palabras[$indiceToken];
  $indiceToken++; 
  if (($tokens=="" or $tokens==" " )&& $indiceToken <= count($palabras))
  { 
   $tokens=$palabras[$indiceToken];
   
    for (;$palabras[$indiceToken]=="" or $palabras[$indiceToken]==" " ; $indiceToken++){} 
    
  }
  return $tokens;
 
}

function fgetSame()
{global $indiceToken;
  $indiceToken--;
}

function fputToken($tokk)
{
global $helix;
 global $paquetin;

  global $indiceHelix;
$indiceHelix=$indiceHelix+5;
$helix[$indiceHelix]=$tokk;
// if ($indiceHelix==3935){$paquetin.=$indiceHelix." = ".print_r($helix,true)."\n";}
}

function fpurgeToken()
{global $indiceHelix;
  $indiceHelix--;
}

function fMap()
{global $indiceToken;
  global $paquetin;
  global $helix;
  $tok=fgetToken();
 if ($tok=="<map")
   {  
        
     for (;$tok!=">";$tok=fgetToken()){ 
//$paquetin.=$tok." -> "; 
fputToken($tok);}
fputToken($tok."\n");
//$paquetin.="helix ->".print_r($helix,true); 
     }
 else {
/**err**/
}
 fBranch(0,"");
 $tok=fgetToken();
 if ($tok=="</map>"){/**ok**/ // echo " termine ".$tok;
    fputToken($tok);}else{/**Err**/}

}

function fComment()
{global $variablex;
  echo $variablex;
}

function fBranch($nivel,$nodoPadre)
{

  $tok=fgetToken();
if ($tok=="<!--")
  {

    for (;$tok!="-->";$tok=fgetToken()){fputToken($tok);}
fputToken($tok."\n");}
 else {
   fgetSame();
   
    }
 
 $numerin=fNode($nivel,$nodoPadre);
 
 if ($numerin){ fBranch($nivel,$nodoPadre);}
}

function Marca($que,&$donde,$contenido)
{global $indiceHelix;
  if ($contenido==""){
  $donde[$que]=$indiceHelix;
  } else {
    $donde[$que]=$contenido; 
          }

}



function MarcaPH($P,$H)
{ global $indicePH;
  global $arrayPadresHijos;
  $donde = array("PADRE" => "","HIJO" => "");

  $donde["PADRE"]=$P;
  $donde["HIJO"]=$H;
  $arrayPadresHijos[$indicePH]=$donde;
  $indicePH++;

}


function fNode($nivel,$nodoPadre)
{ global $nodoOrigen;
  global $arrayIDIndx;
  //global $paquetin;
  $registroParamsTemp= array("NODOI" => "","NODOF" => "","CREATED" => "","FOLDED" => "","HGAP" => "","ID" => "","LINK" => "","MODIFIED" => "","POSITION" => "","TEXT" => "","VSHIFT" => "","CREATED=" => "","FOLDED=" => "","HGAP=" => "","ID=" => "","LINK=" => "","MODIFIED=" => "","POSITION=" => "","TEXT=" => "","VSHIFT=" => "","PADRE" => "","NODOM" => "");

  // En nivel 1 es forzoso, niveles subsecuentes puede ser getsame
$tok=fgetToken();
 if ($tok=="<node") 
   {fputToken($tok);
     Marca("NODOI",$registroParamsTemp,"");
     Marca("PADRE",$registroParamsTemp,$nodoPadre);
     fParams($nivel,$registroParamsTemp);
    $tok=fgetToken();
    if ($tok==">")
      { 
       fputToken($tok."\n");
 Marca("NODOM",$registroParamsTemp,"");
    $tok=fgetToken();
    if ($tok=="<node" or $tok=="<arrowlink" or $tok=="<icon" )
     { fgetSame($indiceToken);
       $nivel++;
       fBranch($nivel,$registroParamsTemp["ID"]);}
    else {/*err*/
         if ($tok=="</node>"){
            fputToken($tok."\n"); 
            Marca("NODOF",$registroParamsTemp,"");
            $arrayIDIndx[$registroParamsTemp["ID"]]=$registroParamsTemp;
            MarcaPH($nodoPadre,$registroParamsTemp["ID"]);
            return 1;}
         else {

	   //err
	 }

    }} //primer llave else *err*, segunda if tok = >
    else if ($tok=="/>" ){
      //$paquetin.="el nodof ".$registroParamsTemp["ID"]." : ".$tok."# ";
                          fputToken($tok."\n"); 
                          Marca("NODOF",$registroParamsTemp,"");
                          $arrayIDIndx[$registroParamsTemp["ID"]]=$registroParamsTemp;
                          MarcaPH($nodoPadre,$registroParamsTemp["ID"]);              
                          return 1;}
    else {
      //err

         }

   } else  if ($tok=="<arrowlink"){fputToken($tok);
   fParamsArr();
   $tok=fgetToken();
   if ($tok=="/>" ){fputToken($tok."\n");return 1;}
   else { /** error **/}
 }else  if ($tok=="<icon"){
      fputToken($tok);
fParamsIcon();
   $tok=fgetToken();
   if ($tok=="/>" ){fputToken($tok."\n"); return 1;}
   else { /** error **/}
 }
else  {
  fgetSame();
  return 0; 
 }

 $tok=fgetToken();
 //$paquetin.="\n ".$registroParamsTemp["ID"]." :".$tok."\n";
 if ($tok=="</node>"){
        fputToken($tok."\n"); 
         Marca("NODOF",$registroParamsTemp,"");
         $arrayIDIndx[$registroParamsTemp["ID"]]=$registroParamsTemp;
         MarcaPH($nodoPadre,$registroParamsTemp["ID"]);
        return 1;}
    else {

      //err
         }



}


function fParamsIcon()
{
$tok=fgetToken();
 if ($tok=="BUILTIN=") 
   {fputToken($tok);
     Ident();

} else {
   //$paquetin.=" errparams node\n".$tok;
   //err
 }
}




function fParamsArr()
{
$tok=fgetToken();
 if ($tok=="COLOR=") 
   {fputToken($tok);
     Ident();
    } else {
   fgetSame();
}

$tok=fgetToken();
 if ($tok=="DESTINATION=") 
   {fputToken($tok);
     Ident();
    } else {
   //err
}
$tok=fgetToken();
 if ($tok=="ENDARROW=") 
   {fputToken($tok);
     Ident();
   } else {
   
}
$tok=fgetToken();
 if ($tok=="ENDINCLINATION=") 
     { fputToken($tok);
       Ident(); 
     } else {
   //err
 }
$tok=fgetToken();
 if ($tok=="ID") 
   {fputToken($tok);
     Ident();
   } else {
   //err
 }
$tok=fgetToken();
 if ($tok=="STARTARROW=") 
   {fputToken($tok);
     Ident();
   } else {
   
 }
$tok=fgetToken();
 if ($tok=="STARTINCLINATION=") 
   {fputToken($tok);
     Ident();
    } else {
   //err
 }

}


function Ident()
{
 $tok=fgetToken();
 ;
     if ($tok=='"'){
     $tok=fgetToken(); 
     for (;$tok!='"';$tok=fgetToken()){$acum.=$tok." ";}
     $acum=chop($acum);
       fputToken('"'.$acum.'"');  
       return $acum;
       
      }
     else {return "err"; /**err**/}

}


function fParams($nivel,&$registroParamsTemp)
{
  // global $paquetin;
$tok=fgetToken();
 if ($tok=="CREATED=") 
   {fputToken($tok);
     Marca($tok,$registroParamsTemp,"");
     Marca("CREATED",$registroParamsTemp,Ident());
   } else {
   //$paquetin.=" errparams created\n".$tok;
   //err
 }
$tok=fgetToken();
 if ($tok=="FOLDED=") 
   {fputToken($tok);
     Marca($tok,$registroParamsTemp,"");
     Marca("FOLDED",$registroParamsTemp,Ident());
} else {
   fgetSame();
}
$tok=fgetToken();
 if ($tok=="HGAP=") 
   {fputToken($tok);
     Marca($tok,$registroParamsTemp,"");
     Marca("HGAP",$registroParamsTemp,Ident());     
    } else {
   fgetSame();
}
$tok=fgetToken();
 if ($tok=="ID=") 
   {fputToken($tok);
    Marca($tok,$registroParamsTemp,"");
    Marca("ID",$registroParamsTemp,Ident()); 
    
    } else {
   //$paquetin.=" errparams id\n".$tok;
   //err
 }
$tok=fgetToken();
 if ($tok=="LINK=") 
   {fputToken($tok);
    Marca($tok,$registroParamsTemp,"");
    Marca("LINK",$registroParamsTemp,Ident()); 
    } else {
   fgetSame();
}
$tok=fgetToken();
 if ($tok=="MODIFIED=") 
   {fputToken($tok);
     Marca($tok,$registroParamsTemp,"");
    Marca("MODIFIED",$registroParamsTemp,Ident()); 
    } else {
   //$paquetin.=" errparams modified\n".$tok;
   //err
 }
 if ($nivel==1)
   {
$tok=fgetToken();
 if ($tok=="POSITION=") 
   {fputToken($tok);
      Marca($tok,$registroParamsTemp,"");
    Marca("POSITION",$registroParamsTemp,Ident()); 
    } else {
   //$paquetin.=" errparams position\n".$tok;
   //ERROR
 }
   }
$tok=fgetToken();
 if ($tok=="TEXT=") 
   {fputToken($tok);
     Marca($tok,$registroParamsTemp,"");
    Marca("TEXT",$registroParamsTemp,Ident()); 
    } else {
   //$paquetin.=" errparams text\n".$tok;
   //err
 }
$tok=fgetToken();
 if ($tok=="VSHIFT=") 
   {fputToken($tok);
     Marca($tok,$registroParamsTemp,"");
    Marca("VSHIFT",$registroParamsTemp,Ident()); 
   } else {
   fgetSame();
}
}

function fInscribe($ppath) {
  global $helix;
  global $indiceHelix;
  global $arrayPadresHijos;
  global $arrayIDIndx;
  global $errorr;
  global $idnodo;
  global $paquetin;
  global $palabras;
  

 $gestor = fopen($ppath, "w");
 //$paquetin.="helix fin ->".print_r($helix,true);
for ($inx=0;$inx<=$indiceHelix;$inx++){
  if ($helix[$inx]!=""){
if ($helix[$inx]!="</node>"){
  fwrite($gestor, $helix[$inx]." ");}
 else {fwrite($gestor, $helix[$inx]."\n");}
  }


}
// fwrite($gestor, "<!--e ### y ### ".print_r($arrayIDIndx,true)."-->");
//fwrite($gestor, "<!--e ###".print_r($helix,true)."-->");
// fwrite($gestor, "<!--e".$helix[$arrayIDIndx["Freemind_Link_1876460424"]["NODOF"]]."-->");
//fwrite($gestor, "<!--e ".$errorr."-->");
// fwrite($gestor, "<!--e".$idnodo."-->");
//fwrite($gestor, "<!--el paquetin".$paquetin."-->"); 
// fwrite($gestor, "<!--e las pal ".print_r($palabras,true)."-->");


fclose($gestor);
	   return true;
}

if (checkSession()) {
 
$eldoc=$_GET[elmapa]; 
  $palabras=fInit("/usr/local/apache_1.3.41/htdocs/FichasBD/branches/SY/Documents/Root Folder/Default Unit/SIDEM/Mindmaps/".$eldoc);
  
 fMap();
 if ($numinstr==1){
 $numrr=rand(100000,200000);
 $dato_ins=fCalculaRama($tipo,$id_doc,"","TRAY",1);
 fInsertaNodo($idnodo,$dato_ins);
 fInscribe("/usr/local/apache_1.3.41/htdocs/FichasBD/branches/SY/Documents/Root Folder/Default Unit/SIDEM/Mindmaps/".$eldoc);
 }
 else if ($numinstr==2){
   fBorraRelleno($idnodo);
 fInscribe("/usr/local/apache_1.3.41/htdocs/FichasBD/branches/SY/Documents/Root Folder/Default Unit/SIDEM/Mindmaps/".$eldoc);
} else if ($numinstr==3){
   
   fReScan($idnodo,$lafunc,$id_doc,$tipo_doc,$where1);
   $paquetin.="helix precalcula ->".print_r($helix,true);
   $dato_ins=fCalculaRama($tipo_doc,$id_doc,$where1,$lafunc,0);
   $paquetin.="helix preinserta ->".print_r($helix,true);
   fInsertaNodo($idnodo,$dato_ins);
   $paquetin.="helix preinscribe->".print_r($helix,true);
   fInscribe("/usr/local/apache_1.3.41/htdocs/FichasBD/branches/SY/Documents/Root Folder/Default Unit/SIDEM/Mindmaps/".$eldoc);
 }
 else if ($numinstr==4){
   
   $firephp->log($id_doc,'Iteradores');
   $firephp->log($tipo,'Iteradores2');
   $firephp->log($eldoc,'Iteradores'); 
   $dato_ins=fgeneraFicha($id_doc,$tipo,$eldoc);
    $firephp->log($dato_ins,'Iteradores');
   //$paquetin.="helix preinserta ->".print_r($helix,true);
   fInsertaNodo($idnodo,$dato_ins);
   //$paquetin.="helix preinscribe->".print_r($helix,true);
   fInscribe("/usr/local/apache_1.3.41/htdocs/FichasBD/branches/SY/Documents/Root Folder/Default Unit/SIDEM/Mindmaps/".$eldoc);
 } else if ($numinstr==5){
 $numrr=rand(100000,200000);
$firephp->log($tipo,'check');
$firephp->log($id_doc,'check1');
 $dato_ins=fCalculaRama($tipo,$id_doc,"","TREL",1);
$firephp->log($dato_ins,'check2');
fInsertaNodo($idnodo,$dato_ins);
fInscribe("/usr/local/apache_1.3.41/htdocs/FichasBD/branches/SY/Documents/Root Folder/Default Unit/SIDEM/Mindmaps/".$eldoc);
 }
 
 //echo $dato_ins;
 controllerRedirect("mindmaps", "iddoc=$eldoc");
 

 }


 ?>