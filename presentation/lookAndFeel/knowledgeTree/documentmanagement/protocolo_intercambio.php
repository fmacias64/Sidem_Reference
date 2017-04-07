<?php

require_once("../../../../config/dmsDefaults.php");


//echo $_POST[1];


if  ($_POST['opcion']=="si") {               
  $actuals=" SELECT YEAR( CURDATE( ) ) AS ano, MONTH( CURDATE( ) ) AS mes, WEEK( CURDATE( ) ) AS semana, DATE_SUB( CURDATE( ) , INTERVAL 2 DAY ) AS antier, DATE_SUB( CURDATE( ) , INTERVAL 1 DAY ) AS ayer, CURDATE( ) AS hoy";
$actualq =mysql_query($actuals);
$actualf=mysql_fetch_array($actualq);

if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', "'"));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}

 $longitudcontenido=600;
 $extensiontitulo=600;
require_once("../../../../lib/util/sanitize.inc");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
$boolnota=0;
$echoactor=0;
$letra = $_GET["letra"];
$alltier1=$_GET["alltier"];
$tier1=$_GET["tier"];
$nota = $_GET["nota"];
$region = $_GET["region"];
$event = $_GET["event"];
$action = $_GET["action2"];
$type = $_GET["type"];
$competitive = $_GET["competitive"];
$sustainability = $_GET["sustainability"];
$reactiontype = $_GET["reactiontype"];
$reactiontopic = $_GET["reactiontopic"];
$consequence = $_GET["consequence"];
$actor = $_GET["actor"];
$competidor=$_GET["competidor"];
$industria=$_GET["industry"];
$subindustria=$_GET["subindustry"];
$parampais=$_GET["pais"];
$ano=$_GET["ano"];
$notime=$_GET["notime"];
$politik=$_GET["pol"];
 $erm=$_GET["erm"];
$fechaA=$_GET["fecha1"];

$fechaP=$_GET["fecha2"];

 if (($fechaA=='2012-11-30')&&($fechaP=='2012-12-21')) {$fechaA='2011-12-21';}



$apartir=$_GET["apartir"];
$where1 = "";
$from1="";
 $letram=strtoupper($letra);
   $letrasar= explode("_",$letram);
   

   if ($fechaA==""){} else {$where1=" AND dateb >= '".$fechaA."' ";}
   if (($nota=="") or ($politik!=""))
{
}else
{
$boolnota=1;

$where1.="AND note LIKE '%$nota%' ";
}


if($parampais=="")
{

}else
{
$boolpais=1;


$where1.= " AND idcountry = ".$parampais." ";


}


 if (($industria=="") or ($politik!=""))
{} else
{
$boolnota=1;
$where1.= " AND indufield = '".$industria."' ";

// SubIndustria
 }
 if (($subindustria=="") or ($politik!=""))
{}
else
{

  $from1.= ", sidem210708.Empresas_extended as emp ";
$where1.= " AND ( emp.id=sidem210708.EventosB2B_extended.compet and subindustry = '".$subindustria."')";


}

 if (($tier1=="") or ($politik!=""))
{}
else
{

  $from1.= ", sidem210708.Empresas_extended as emp ";
$where1.= " AND ( emp.id=sidem210708.EventosB2B_extended.compet and emp.super = '".$tier1."')";


}

if ($erm!="")
{
$where1.= " AND erm = 'YES' ";
 
}
else
{

}

if (($alltier1=="") or ($politik!=""))
{}
else
{

  $from1.= ", sidem210708.Empresas_extended as emp ";
  $where1.= " AND ( emp.id=sidem210708.EventosB2B_extended.compet and (";
  $where1.= "(emp.super = '3074') OR ";
  $where1.= "(emp.super = '2514') OR ";  
$where1.= "(emp.super = '1581') OR ";
$where1.= "(emp.super = '2513') OR ";
$where1.= "(emp.super = '2728'))) ";


}




if($ano=="")
{

}else
{
$boolano=1;

$where1.=" AND dateb LIKE '".$ano."%' ";
}

$oplog=($fechaA=="" && $fechaP=="" && $ano =="" && $nota=="" && $region=="" && $erm=="" );
$oplog=($oplog && $event=="" && $action=="" && $type=="" && $competitive=="");
$oplog=($oplog && $sustainability=="" && $reactiontype =="" &&$reactiontopic =="");
$oplog=($oplog && $consequence =="" &&  $actor =="" && $competidor =="" && $industria=="" && $parampais=="" && $politik=="" && $tier1 =="" && $alltier1=="" );
if($oplog)
{
  if ($_POST['cantidad'])
    {
      //echo $_POST[2];

      if ($_POST['periodo']!="YEAR")
	{
$where1.=" AND sidem210708.EventosB2B_extended.dateb  > (CURDATE()-INTERVAL ".$_POST['cantidad']." ".$_POST['periodo'].") ";
	}
      else
	{
	  $where1.=" AND YEAR(sidem210708.EventosB2B_extended.dateb) =".$_POST['periodo']." ";
	}    
      //echo $where1;

    }
  else
    {
      $where1.="AND sidem210708.EventosB2B_extended.modifiedb  > (CURDATE()-INTERVAL 123 DAY) ";
    }
}else
{

}

if($fechaA!="")
{
}else
{
$boolano=1;

if ($notime==0)
{
  //$where1.=" AND dateb >= (CURDATE()-INTERVAL 123 DAY) ";
  //$where1.=" AND dateb > (CURDATE()-INTERVAL 2 WEEK) ";
}
elseif ($notime==1)
{
$where1.=" AND dateb >= (CURDATE()-INTERVAL 2 DAY) ";
  //$where1.=" AND dateb > (CURDATE()-INTERVAL 2 WEEK) ";
}
else if($notime==2)
{

$where1.=" AND dateb  > (CURDATE()-INTERVAL 1 MONTH) ";
}
else if($notime==3)
{

$where1.=" AND dateb > (CURDATE()-INTERVAL 2 MONTH) ";
}
else if($notime==4)
{

$where1.=" AND dateb > (CURDATE()-INTERVAL 1 WEEK) ";
}
else
{
$where1.=" AND dateb >= (CURDATE()-INTERVAL 2 DAY) ";
}
}

if($fechaP=="")
{
}else
{
$boolano=1;

$where1.=" AND dateb <= '$fechaP' ";
}



if($region=="")
{
}else
{


if($region=="Asia and South Pacific")
{
$where1.=" AND ( region='Asia & South Pacific' OR region='ASIA AND SOUTH PACIFIC') ";
}
else
if($region=="Egypt and Middle East")
{
$where1.=" AND ( region='Egypt & Middle East' OR region='EGYPT AND MIDDLE EAST') ";
}
else{


$where1.=" AND  region='".$region."' ";
}
}

if (($event=="")or ($politik!=""))
{
}else
{


if ($event=="Competitive Dynamic")
{
$where1.=" AND (iscompdyn='Yes' OR  iscompdyn='YES') ";
} else if ($event=="Technology")
{
$where1.=" AND (istech='Yes' OR  istech='YES') ";
} else if ($event=="Sustainability")
{
$where1.=" AND (issust='Yes' OR  issust='YES') ";

} else if ($event=="Opportunities")
{
$where1.=" AND (isopp='Yes' OR  isopp='YES') ";
} else if ($event=="Corporate")
{
$where1.=" AND (iscorp='Yes' OR  iscorp='YES') ";
} else if ($event=="Reactions")
{
$where1.=" AND (iseac='Yes' OR  iseac='YES') ";
}

}

if($politik=="")
{
}
else
{

  /***
$where1.=" AND ((ispoli='Yes' OR  ispoli='YES') ";
$where1.=" OR (isecon='Yes' OR  isecon='YES') ";
$where1.=" OR (issoci='Yes' OR  issoci='YES') ";
$where1.=" OR (iscont='Yes' OR  iscont='YES')) ";
  ***/

$where1.=" AND ((isitpolitics='Yes' OR  isitpolitics='YES') ";
$where1.=" OR (isiteconomics='Yes' OR  isiteconomics='YES') ";
$where1.=" OR (isitsocial='Yes' OR  isitsocial='YES') ";
$where1.=" OR (isitcontingency='Yes' OR  isitcontingency='YES')) ";

 $tipodoc="55 ";
}


 if (($action=="") or ($politik!=""))
{
}else
{


if ($action=="New Company")
{
$where1.=" AND  compdynact='".$action."' ";
} else if ($action=="Acquisition-Company")
{
$where1.=" AND compdynact='".$action."' ";
} else if ($action=="Expansion")
{
$where1.=" AND compdynact='".$action."' ";
} else if ($action=="Mergers")
{
$where1.=" AND compdynact='".$action."' ";
} else if ($action=="Upgrades")
{
$where1.=" AND compdynact='".$action."' ";
} else if ($action=="JV")
{
$where1.=" AND compdynact='".$action."' ";
} else if ($action=="Alternative Fuels Project")
{
$where1.=" AND  techact='".$action."' ";
} else if ($action=="New Material / Processes")
{
$where1.=" AND techact='".$action."' ";
}else if ($action=="Projects / Loans")
{
$where1.=" AND sustaitype='".$action."' ";
}
else if ($action=="Organization of Forums and Events")
{
$where1.=" AND sustaitype='Organization of Forums and Events' ";
}
else if ($action=="Attendance to Forums and Events")
{
$where1.=" AND sustaitype='".$action."' ";
}
else if ($action=="Awards delivered")
{
$where1.=" AND sustaitype='".$action."' ";
}
else if ($action=="Document Publishing")
{
$where1.=" AND sustaitype='".$action."' ";
}
else if ($action=="Foundation/Cofoundation of organisms")
{
$where1.=" AND oppact='".$action."' ";
}else if ($action=="Cost Reduction")
{
$where1.=" AND oppact='".$action."' ";
}else if ($action=="Capital Finance Raise")
{
$where1.=" AND oppact='".$action."' ";
}else if ($action=="Increase Prices")
{
$where1.=" AND oppact='".$action."' ";
}else if ($action=="Volume Raise")
{
$where1.=" AND compdynsect='".$type."' ";
}
}

if (($type=="") or ($politik!=""))
{
}else
{



 if ($type=="Cement")
{
$where1.=" AND compdynsect='".$type."' ";
}
else if ($type=="Concrete")
{
$where1.=" AND compdynsect='".$type."' ";
}
else if ($type=="Aggregates")
{
$where1.=" AND compdynsect='".$type."' ";
}
else if ($type=="Other")
{
$where1.=" AND compdynsect='".$type."' ";
}

else if ($type=="Quarries")
{
$where1.=" AND compdynsect='".$type."' ";
}
else if ($type=="Sea Terminal")
{
$where1.=" AND compdynsect='".$type."' ";
}
else if ($type=="Distribution Center")
{
$where1.=" AND compdynsect='".$type."' ";
}
else if ($type=="RandB Center")
{
$where1.=" AND compdynsect='R&D'";
}
else if ($type=="Non Core Related")
{
$where1.=" AND compdynsect='".$type."' ";
}
else if ($type=="AF. TDF(Tires)")
{
$where1.=" AND techtype='".$type."' ";
}
else if ($type=="AF Bio-Mass")
{
$where1.=" AND techtype='".$type."' ";
}
else if ($type=="AF. Industrial Wastes")
{
$where1.=" AND techtype='".$type."' ";
}
else if ($type=="AF. Municipal Waste")
{
$where1.=" AND techtype='".$type."' ";
}
else if ($type=="NP. Low resource consumption")
{
$where1.=" AND techtype='".$type."' ";
}
else if ($type=="NP. Recyclers")
{
$where1.=" AND techtype='".$type."' ";
}
else if ($type=="NP. Low polluters / Env Quality Enchancers")
{
$where1.=" AND techtype='".$type."' ";
}
else if ($type=="Training/ Education ")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Business Incubator")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Redeployment on closure")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Infraestructure Development")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Housing")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Natural Disaster Aid")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Historical Monuments Protector")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Safety promotion")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Labor Equity/Human Rights")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Sponsor of Cultural-Sport Activities")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Stakeholders/Community Involvement")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Biodiversity and Quarry Rehabilitation")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Protecting Air Quality and Mitigating Disturbances")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Water Protection")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Reccycling Industrial by products and wastes")
{
$where1.="AND typcorp='".$type."' ";
}
else if ($type=="Energy Recovery (Electricity)")
{
$where1.="AND typcorp='".$type."' ";
}
}
//===========================


 if (($competitive=="")or ($politik!=""))
{

}else
{



if ($competitive=="Plan")
{
$where1.=" AND compdynsp='".$competitive."' ";
}
else if ($competitive=="In Process")
{
$where1.=" AND compdynsp='".$competitive."' ";
}
else if ($competitive=="Completed")
{
$where1.=" AND compdynsp='".$competitive."' ";
}
}
//======================
if($sustainability=="")
{

}else
{


if ($sustainability=="Economic")
{
$where1.="AND  sustaitheme='".$sustainability."' ";
}
else if ($sustainability=="Social")
{
$where1.="AND  sustaitheme='".$sustainability."' ";
}
else if ($sustainability=="Enviroment")
{
$where1.="AND  sustaitheme='".$sustainability."' ";
}
else if ($sustainability=="Sustainable")
{
$where1.="AND  sustaitheme='".$sustainability."' ";
}
}
//================

 if (($reactiontype=="")or ($politik!=""))
{

}else
{



 if ($reactiontype=="Positive")
{
$where1.=" AND reaction='".$reactiontype."' ";
}
else if ($reactiontype=="Negative")
{
$where1.=" AND (reaction='".$reactiontype."' or reaction='NEGATIVE') ";
}
else if ($reactiontype=="N/A")
{
$where1.=" AND reaction='".$reactiontype."' ";
}
}
//====================

if (($reactiontopic=="")or ($politik!=""))
{
}else
{


 if ($reactiontopic=="Enviroment/Health" || $reactiontopic=="ENVIRONMENT/HEALTH" || $reactiontopic == "Environment" )
{
$where1.=" AND  (reacttopic='Enviroment/Health' OR reacttopic='ENVIRONMENT/HEALTH') ";
}
else if ($reactiontopic=="Labor/Security within org" || $reactiontopic=="LABOR/SECURITY WITHIN ORG" )
{
$where1.=" AND (reacttopic='Labor/Security within org' OR reacttopic='LABOR/SECURITY WITHIN ORG') ";
}
else if ($reactiontopic=="Competitiveness" || $reactiontopic=="COMPETITIVENESS")
{
  $where1.=" AND (reacttopic='Competitiveness' OR reacttopic='COMPETITIVENESS' ) ";
}
else if ($reactiontopic=="Social Resp. community" || $reactiontopic=="SOCIAL RESPONSIBILITY WITH COMMUNITY" )
{
$where1.=" AND ( reacttopic='Social Resp. community' OR reacttopic='SOCIAL RESPONSIBILITY WITH COMMUNITY' )";
}
else if ($reactiontopic=="ETHICS / LICIT" )
{
$where1.="AND ( reacttopic='ETHICS / LICIT' ) ";
}
else if ($reactiontopic=="PERFORMANCE")
{
$where1.="AND ( reacttopic='PERFORMANCE') ";
}
else if ($reactiontopic=="N/A")
{
$where1.="AND ( reacttopic='N/A') ";
}
}
//=====================

 if (($consequence=="")or ($politik!=""))
{
}else
{

if ($consequence=="CLOSURES")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="DOWNGRADE")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="EXPROPIATION")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="FINES")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="INVESTIGATION")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="LAWSUITS")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="OPPOSITION / ACCUSATION")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="PROTEST / DEMOSTRATIONS")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="RECOGNITION")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="RECOMMENDATION")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="RESTRICTIONS")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="UPGRADE")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="WARNING")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
else if ($consequence=="N/A")
{
$where1.=" AND  reactcons='".$consequence."' ";
}
}
//=========================

 if (($actor=="") or ($politik!=""))
{
}else
{
$echoactor=1;

 if ($actor=="Community")
{
$where1.=" AND reactact='".$actor."' ";
}
else if ($actor=="NGO/Media")
{
$where1.=" AND reactact='".$actor."' ";
}
else if ($actor=="Government")
{
$where1.=" AND reactact='".$actor."' ";
}
else if ($actor=="Other Competitors")
{
$where1.=" AND reactact='".$actor."' ";
}

else if ($actor=="N/A")
{
$where1.=" AND reactact='".$actor."' ";
}
}



 if (($competidor=="") or ($politik!=""))
{
}else
{
$echocompetidor=1;


if ($competidor=="1581")
{
$where1.="AND ( compet='1581'";
$where1.=" OR compet='1587'";  
$where1.=" OR compet='1640'";
$where1.=" OR compet='1641'";
$where1.=" OR compet='1655'";
$where1.=" OR compet='2300'";
$where1.=" OR compet='2301'";
$where1.=" OR compet='3238'";
//  la union $where1.=" OR compet='3170'";
$where1.=" OR compet='3192'";
//la union $where1.=" OR compet='3184'";
$where1.=" OR compet='3116'";
$where1.=" OR compet='3113'";
$where1.=" OR compet='3102'";
$where1.=" OR compet='3065'";
$where1.=" OR compet='3143'";


$where1.=") ";
}
else if ($competidor=="3089")
{
$where1.="AND ( compet='3089'";
$where1.=" OR compet='3122'";  
$where1.=" OR compet='3157'";
$where1.=" OR compet='3159'";
$where1.=" OR compet='3175'";
$where1.=" OR compet='3217'";
$where1.=" OR compet='3224'";
$where1.=" OR compet='3227'";
$where1.=" OR compet='3170'";
$where1.=" OR compet='3231'";
$where1.=" OR compet='3184'";


$where1.=") ";
}



}





//            Encabezado

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

header('Content-type: application/json; charset=utf-8');

mysql_query("set names 'utf8'");


$busq_links="SELECT distinct sidem210708.EventosB2B_extended.*, emp.*, YEAR(sidem210708.EventosB2B_extended.dateb), MONTH(sidem210708.EventosB2B_extended.dateb), WEEK(sidem210708.EventosB2B_extended.dateb)  FROM sidem210708.EventosB2B_extended, sidem210708.Empresas_extended as emp  WHERE 1 AND ( emp.id=sidem210708.EventosB2B_extended.compet ) and sidem210708.EventosB2B_extended.typsou not like '%INTERNAL NETWORK%'".$where1." order by EventosB2B_extended.id ASC";

//echo $busq_links;

$busq_links1 = mysql_query($busq_links);

         
     echo "{";
echo "\n";
echo " items:[";


$checkfirst=0;

 while ($busq_links2 = mysql_fetch_row($busq_links1))
{//while busqlinks2
  $acum="";
$compdyn="";
  $cont="";
  $tech="";
  $corp="";
  $sust="";
  $pere="";
  $coma="";
  if ($busq_links2[17]=='YES') 
{
$compdyn="\"Competitive Dynamic\"";$coma=", ";
 $acum="CD_";
}
  if ($busq_links2[26]=='YES') {
$cont=$coma."\"Contingencies\"";
$coma=", ";
 $acum.="CONT_";
}
  if ($busq_links2[27]=='YES') {
$tech=$coma."\"Technology\"";
$coma=", ";
 $acum.="TECH_";
}
 if ($busq_links2[28]=='YES') {
$corp=$coma."\"Corporate\"";$coma=", ";
 $acum.="CORP_";}
 if ($busq_links2[29]=='YES') {$sust=$coma."\"Sustainability\"";$coma=", ";
   $acum.="SUST_";
}
 if ($busq_links2[47]=='YES') {$pere=$coma."\"Public Relations\"";
   $acum.="PR_";
}
  $enc=str_replace('"',"'",$busq_links2[5]);
$tit=str_replace('"',"'",$busq_links2[5]);
 $conte=str_replace('"',"'",$busq_links2[14]);
 $refer=json_encode($busq_links2[4]);
  $enc=json_encode($enc);
 


  
 $extension=strlen($tit);
  if ($extension>$extensiontitulo) $extension=$extensiontitulo; 
 
$tit=substr($tit,0,$extension);
$tit=json_encode($tit);

  $conte=json_encode($conte);
   $subconte=substr($conte,0,120);
   //$numword=explode(" ",$subconte);
  // $lapalabra=$numword[count($numword)-2];
  // $nume=strpos($conte,$lapalabra,strlen($lapalabra)*2/3);
$extension=strlen($conte);
  if ($extension>$longitudcontenido) $extension=$longitudcontenido;
$subconte=substr($conte,0,$extension);
  $subconte=json_encode($subconte);
  
 if ($checkfirst > 0 ) { echo ",";}
 $checkfirst++;
echo "\n"; 
echo "{";
echo "\n";
echo "label:".json_encode($busq_links2[0]."_".$acum."_".$busq_links2[33]).",";
echo "\n";
echo "label2:".$tit.",";
echo "\n";


//echo "label2:".json_encode($acum."_".$busq_links2[33]).",";
//echo "\n";
 echo "\"type\":\"Event\",";
echo "\n";
echo "\"index\":".$busq_links2[0].",";
echo "\n";
echo "\"categoria\":[".$compdyn.$cont.$tech.$corp.$sust.$pere."],";
echo "\n";
echo "\"fecha\":\"".$busq_links2[6]."\",";
echo "\n";
 $estasemana="";
 $hoy="";
 if (($busq_links2[83]==$actualf['ano']) && ($busq_links2[85]==$actualf['semana'] )){$estasemana=",\"Current Week\"";}
 if (($busq_links2[6]==$actualf['hoy']) || ($busq_links2[6]==$actualf['ayer'])|| ($busq_links2[6]==$actualf['antier'])) {$hoy=",\"Last 4 Days\"";}
echo "\"periodo\":[\"".$busq_links2[83]."\",\"".$busq_links2[83]."/".$busq_links2[84]."\"".$estasemana.$hoy."],";
echo "\n";
//sql
$busq_emprels="SELECT distinct sidem210708.EmpresaXEventoB2B_extended.supertn,sidem210708.EmpresaXEventoB2B_extended.tradename  FROM sidem210708.EmpresaXEventoB2B_extended WHERE sidem210708.EmpresaXEventoB2B_extended.ideventb2b=".$busq_links2[0]." order by id ASC";
 $numemp=0;
 $empres="";
 $supers="";
$busq_er = mysql_query($busq_emprels);
 while ($busq_er2 = mysql_fetch_array($busq_er))
   {
     if ($numemp==0){$empres='"'.$busq_er2["tradename"].'"';}
     else {$empres.=",".'"'.$busq_er2["tradename"].'"';}
 if ($numemp==0){$supers='"'.$busq_er2["supertn"].'"';}
     else {$supers.=",".'"'.$busq_er2["supertn"].'"';}
}

 
echo "\"empresarel\":[".$empres."],";
echo "\n";

echo "\"superrel\":[".$supers."],";
echo "\n";

echo "\"region\":\"".$busq_links2[1]."\",";
echo "\n\r";

 echo "\"matriz\":".json_encode($busq_links2[82]).",";
echo "\"competidor\":".json_encode($busq_links2[33]).",";
echo "\n";
 if($busq_links2[3]==''){$pais="\"NA\"";}else{$pais=json_encode($busq_links2[3]);}
 echo "\"pais\":".$pais.",";
 //echo "\"otro\":"".$busq_links2[3]."",";
echo "\n\r";
echo "\"enlace\":\"<center><h3><a href='http://www.viemsys.com/index.php?page=bizdetail&biz=".$busq_links2[0]."' target='_BLANK'>Full Note ...</a></h3></center>\",";
echo "\n\r";
echo "\"contenido\":".$subconte."";
echo "\n\r";

echo "}";
echo "\n";
}

/****
 
 /// Fecha

 mysql_data_seek($busq_links1,0);
 while ($busq_links2 = mysql_fetch_row($busq_links1))
{//while busqlinks2


 if ($checkfirst > 0 ) { echo ",";}
 $checkfirst++;
echo "{";
echo "\n";
 echo "\"label\":'".$busq_links2[0]."',";
echo "\n";
echo "\"index\":".$busq_links2[0].",";
echo "\n";
echo "\"inDate\":\"".$busq_links2[6]."\",";
echo "\n";
 echo "\"outDate\":\"".$busq_links2[6]."\"";
echo "\n";
echo "}";
echo "\n";
 

}

 ///longlat

 mysql_data_seek($busq_links1,0);
 while ($busq_links2 = mysql_fetch_row($busq_links1))
{//while busqlinks2
  $acum="";
$compdyn="";
  $cont="";
  $tech="";
  $corp="";
  $sust="";
  $pere="";
  $coma="";
  if ($busq_links2[17]=='YES') 
{
$compdyn="\"Competitive Dynamic\"";$coma=", ";
 $acum="CD_";
}
  if ($busq_links2[26]=='YES') {
$cont=$coma."\"Contingencies\"";
$coma=", ";
 $acum.="CONT_";
}
  if ($busq_links2[27]=='YES') {
$tech=$coma."\"Technology\"";
$coma=", ";
 $acum.="TECH_";
}
 if ($busq_links2[28]=='YES') {
$corp=$coma."\"Corporate\"";$coma=", ";
 $acum.="CORP_";}
 if ($busq_links2[29]=='YES') {$sust=$coma."\"Sustainability\"";$coma=", ";
   $acum.="SUST_";
}
 if ($busq_links2[47]=='YES') {$pere=$coma."\"Public Relations\"";
   $acum.="PR_";
}

  //...
 
$tit=str_replace('"',"'",$busq_links2[5]);


 
 $extension=strlen($tit);
  if ($extension>$extensiontitulo) $extension=$extensiontitulo; 
 
$tit=substr($tit,0,$extension);
  $tit=json_encode($tit);

 if ($checkfirst > 0 ) { echo ",";}
 $checkfirst++;
echo "\n";
echo "{";
echo "\n";
echo "id:".json_encode($busq_links2[0]."_".$acum."_".$busq_links2[33]).",";
// echo "id:".$tit.",";
echo "\n";
 echo "\"birthLatlng\":\"".$busq_links2[52].",".$busq_links2[53]."\"";
echo "\n";
echo "}";
echo "\n";
 

 }

****/

 echo "]";
echo "\n";
echo "}";

}



?>
