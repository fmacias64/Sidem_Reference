<?php

function fCreanodo($funcqllama,$campo,$tipodoc,$colact,$eltexto, $num_instr,$fin,$folded,$doctype,&$idNodo)
{
  $tCreacion="1274726578281"; //php tiene funcion para tiempo en formato longint
 $tModificado="1274731944034"; 
 $numrr=rand(100000,200000);
 $idNodo= $funcqllama."_".$campo."_".$tipodoc."_".$colact."_".$numrr; 
 if($fin!="")
   { 
$final='" />';
 
   }
 else
   { 
$final='" >';
 
   } 

 if($folded==1)
   { 
$foldedt=' FOLDED="true" ';
 
   }
 else
   { 
     $foldedt='';
 
   } 
if ($num_instr=="" || $doctype=="")
   {
     $sMapa.='<node CREATED= "'.$tCreacion.'" '.$foldedt.' ID="'.$idNodo.'"  MODIFIED= "'.$tModificado.'"  TEXT= "'.$eltexto.$final;
   }
 else
   {

     $sMapa.='<node CREATED= "'.$tCreacion.'" '.$foldedt.' ID="'.$idNodo.'" '.generaInstruccion($idNodo,$num_instr,$doctype).' MODIFIED= "'.$tModificado.'"  TEXT= "'.$eltexto.$final;
   }
 return $sMapa;
}



function TREL($nivel, &$row,$pIdnodo,$comnd)

{ global $resulta;
  global $finarchivo;
  global $firephp;
$firephp->log($pIdnodo,'checkrel');
  $sMapa="";
  //$firephp->trace('Trace Level');
  if ($nivel==0) { $finarchivo=($row =  mysql_fetch_row($resulta));}
  if ($finarchivo){


$pintR= print_r($row,true); 
$firephp->log($pintR,'TRELprint');
$idNodo= "TREL_campsect-o-sect_50_".$row[3]."_".$numrr;
 $sMapa.= fCreanodo("TREL","campsect-o-tiporel","26",$row[2],$row[2],"","",0,"",$idNodo);

//Sustiruir por funcion de arriba

 $sMapa.=DIREC($row[2],$row,$idNodo,$comnd);
 $sMapa.='</node>'."\n";
 $nivel++;
 $sMapa.=TREL($nivel,$row,$pIdnodo,$comnd);
$firephp->log($sMapa,'checkmapatrel');
 return $sMapa;
  }
  else {
    if ($comnd==1){
     return CMND("TREL_campsect-tiporel",$pIdnodo);
    } else {
      return "";}

  }
}

  function DIREC($tipoTray,&$row,$pIdnodo,$comnd)
{
  global $resulta;
  global $firephp;
  $sMapa="";
  //$row =  mysql_fetch_row($resulta);
 if($row[2]==$tipoTray)
    {

      $sdireccion=$row[3];
      if($row[5]==0){
	if($row[3]=="HIERARCHICAL ASCENDANT" || $row[3]=="Jerarquica Ascendente"){
	  $sdireccion="HIERARCHICAL DESCENDANT1";}
	

	else if ($row[3]=="HIERARCHICAL DESCENDANT" || $row[3]=="Jerarquica Descendente")
	  {$sdireccion="HIERARCHICAL ASCENDANT1";}

       

      }


$idNodo= "DIREC_idemp_22_".$row[1]."_".$numrr;
 $sMapa.= fCreanodo("DIREC","idindiv","85",$sdireccion,$sdireccion,"","",0,"",$idNodo);

$pintR= print_r($row,true); 
$firephp->log($pintR,'DIRECprint');

 $sMapa.=PERSONA($row[3],$row[2],$row,$idNodo,$comnd);
 $sMapa.='</node>'."\n";
 $sMapa.=DIREC($tipoTray,$row,$pIdnodo,$comnd);
 //$sMapa.=CMND($row[1]);   
 return $sMapa;
}
 else { if ($comnd==1){$sMapa.=CMND($row[3],$pIdnodo); return $sMapa;}
   else {return $sMapa;}}

}

function PERSONA($direccion,$tiporelacion,&$row,$pIdnodo,$comnd)
{
  //vacia los datos y los pone en nodes consecutivos con terminacion />,row apunta a siguiente tray
 global $resulta;
 global $finarchivo;
 global $firephp;



  $sMapa="";
  if($row[3]==$direccion)
    {
    
$oDocument1 = & Document::get($row[1]);
$pintR= print_r($row,true); 
$firephp->log($pintR,'PERSONA1print');
      $Nom = " http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents". $oDocument1->generateFullFolderPath($oDocument1->getFolderID())."/".$oDocument1->getFileName();

$texto= '&lt;html&gt;&lt;img src=&quot;'.$Nom.'&quot;&gt;'. utf8_encode($row[4]);


 $idNodo= "PERSONA_camptray-o-document-field-id_N_".$row[5]."_".$numrr;

 $sMapa.= fCreanodo("PERSONA","nombre","8",$row[1],$texto,"4","1",0,"18",$idNodo);
$firephp->log($sMapa,'checkmapa');
      while($finarchivo)
   {
    $finarchivo=($row =  mysql_fetch_row($resulta));
 if ($finarchivo)
   {
$pintR= print_r($row,true); 
$firephp->log($pintR,'PERSONA2print');
$oDocument1 = & Document::get($row[1]);

 $Nom = " http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents". $oDocument1->generateFullFolderPath($oDocument1->getFolderID())."/".$oDocument1->getFileName();

$texto= '&lt;html&gt;&lt;img src=&quot;'.$Nom.'&quot;&gt;'. utf8_encode($row[4]);
     if ($row[3]!=$direccion || $row[2]!=$tiporelacion){break;}
     else { 
  
       //$texto=utf8_encode($row[4]);
       $sMapa.= fCreanodo("PERSONA","nombre","8",$row[1],$texto,"4","1",0,"18",$idNodo);
     }
   }

 else{
         
      break;
}
   }
 
 return $sMapa;

 }
  else {if ($comnd==1){$sMapa.=CMND($row[4],$pIdnodo); return $sMapa;}
   else {return $sMapa;}}
  

}


?>