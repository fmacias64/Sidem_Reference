<?php

function TB2B($nivel, &$row,$pIdnodo,$comnd)

{ global $resulta;
  global $finarchivo;
  global $firephp;
$firephp->log($pIdnodo,'checkrel');
  $sMapa="";
  //$firephp->trace('Trace Level');
  if ($nivel==0) { $finarchivo=($row =  mysql_fetch_row($resulta));}
  if ($finarchivo){


$pintR= print_r($row,true); 
//$firephp->log($pintR,'TRELprint');
$idNodo= "TREL_campsect-o-sect_50_".$row[3]."_".$numrr;
 $sMapa.= fCreanodo("TB2B","anio","26",$row[2],$row[2],"","",0,"",$idNodo);

//Sustiruir por funcion de arriba

 $sMapa.=MES($row[2],$row,$idNodo,$comnd);
 $sMapa.='</node>'."\n";
 $nivel++;
 $sMapa.=TB2B($nivel,$row,$pIdnodo,$comnd);
$firephp->log($sMapa,'checkmapatrel');
 return $sMapa;
  }
  else {
    if ($comnd==1){
     return CMND("TB2B_camp-tiporel",$pIdnodo);
    } else {
      return "";}

  }
}

  function MES($tipoanio,&$row,$pIdnodo,$comnd)
{
  global $resulta;
  global $firephp;
  $sMapa="";
  //$row =  mysql_fetch_row($resulta);
 if($row[2]==$tipoanio)
    {

    


$idNodo= "MES_idemp_22_".$row[1]."_".$numrr;
 $sMapa.= fCreanodo("MES","idev","109",$row[3],$row[3],"","",0,"",$idNodo);

$pintR= print_r($row,true); 
$firephp->log($pintR,'DIRECprint');

 $sMapa.=TIPOEVENTO($row[3],$row[2],$row,$idNodo,$comnd);
 $sMapa.='</node>'."\n";
 $sMapa.=MES($tipoanio,$row,$pIdnodo,$comnd);
 //$sMapa.=CMND($row[1]);   
 return $sMapa;
}
 else { if ($comnd==1){$sMapa.=CMND($row[3],$pIdnodo); return $sMapa;}
   else {return $sMapa;}}

}
function TIPOEVENTO($tipomes,$tipoanio,&$row,$pIdnodo,$comnd)
{
  global $resulta;
  global $firephp;
  $sMapa="";
  //$row =  mysql_fetch_row($resulta);
 if($row[3]==$tipomes && $row[2]==$tipoanio)
    {

    


$idNodo= "TIPOEVENTO_idemp_22_".$row[1]."_".$numrr;
 $sMapa.= fCreanodo("TIPOEVENTO","idev","109",$row[2],$row[2],"","",0,"",$idNodo);

$pintR= print_r($row,true); 
$firephp->log($pintR,'DIRECprint');

 $sMapa.=SUMMARY($row[4],$row[3],$row[2],$row,$idNodo,$comnd);
 $sMapa.='</node>'."\n";
 $sMapa.=TIPOEVENTO($tipomes,$tipoanio,$row,$pIdnodo,$comnd);
 //$sMapa.=CMND($row[1]);   
 return $sMapa;
}
 else { if ($comnd==1){$sMapa.=CMND($row[3],$pIdnodo); return $sMapa;}
   else {return $sMapa;}}

}

function SUMMARY($tipoev,$tipomes,$tipoanio,&$row,$pIdnodo,$comnd)
{
  //vacia los datos y los pone en nodes consecutivos con terminacion />,row apunta a siguiente tray
 global $resulta;
 global $finarchivo;
 global $firephp;



  $sMapa="";
  if($row[4]==$tipoev && $row[3]==$tipomes && $row[2]==$tipoanio)
    {
    
$oDocument1 = & Document::get($row[1]);
$pintR= print_r($row,true); 
$firephp->log($pintR,'PERSONA1print');
//$Nom = " http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents". $oDocument1->generateFullFolderPath($oDocument1->getFolderID())."/".$oDocument1->getFileName();

$texto=  utf8_encode($row[5]);


 $idNodo= "SUMMARY_camptray-o-document-field-id_N_SUMMARY_".$numrr;

 $sMapa.= fCreanodo("SUMMARY","summary","113",$row[1],$texto,"","1","1","",$idNodo);
$firephp->log($sMapa,'checkmapa');
      while($finarchivo)
   {
    $finarchivo=($row =  mysql_fetch_row($resulta));
 if ($finarchivo)
   {
$pintR= print_r($row,true); 
$firephp->log($pintR,'PERSONA2print');
$oDocument1 = & Document::get($row[1]);

// $Nom = " http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents". $oDocument1->generateFullFolderPath($oDocument1->getFolderID())."/".$oDocument1->getFileName();

$texto= utf8_encode($row[5]);
     if ($row[4]!=$tipoev || $row[3]!=$tipomes || $row[2]!=$tipoanio){break;}
     else { 
  
       //$texto=utf8_encode($row[4]);
       $sMapa.= fCreanodo("SUMMARY","summary","113",$row[1],$texto,"","1","1",""$idNodo);
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