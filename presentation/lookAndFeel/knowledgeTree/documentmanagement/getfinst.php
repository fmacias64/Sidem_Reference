<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

$id_docactual=$_GET[idd];
$id_enlacesel=$_GET[cc];
 


require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentCollaboration.inc");
$letra = $_GET["letra"];



$id_docactual=256;
$id_enlacesel=34;

function userIsInGroup1($iGroupID2) {       
        global $default, $lang_err_user_group;
        $sql2 = $default->db;
        $sQuery2 = "SELECT id FROM " . $default->users_groups_table . " WHERE group_id = ? AND user_id = ?";/*ok*/
        $aParams2 = array($iGroupID2, $_SESSION["userID"]);
        $sql2->query(array($sQuery2, $aParams2));
        if ($sql2->next_record()) {
reset($_SESSION);          
  return true;
        }
else {
reset($_SESSION);
       return false;}

    
}



function checaciclo($indice,$lista,$nodo,$padre)
{
$regreso=0;

if ($indice>=1 or count($padre)>1)
 {
  for($a=0;$a<=count($padre);$a++)
  {
   if ($padre[$a]==$nodo){$regreso=1;}

   }
 for($a=1;$a<=$indice;$a++)
  {
   if ($lista[$a]['id']==$nodo){$regreso=1;}

   }
  }
return $regreso;
}

 
function ascendencia($pfName, $nivel, &$cerradura,&$consecutivo,&$maxnivel,$extra, $fecha_org,$quien) {
	global $default;


if (checaciclo($consecutivo,$cerradura,$pfName,$quien))
    {
     // poner datos y return
               $razonsocial1= "SELECT value  FROM `document_fields_link`"
               ." WHERE `document_field_id`= 92  AND `document_id`=".$pfName;
               $razonsocial11 = mysql_query($razonsocial1);
               $razonsocial21=mysql_fetch_row($razonsocial11);
               $consecutivo++;
               $cerradura[$consecutivo]['id']=$pfName;
               $cerradura[$consecutivo]['nivel']=$nivel;
               $cerradura[$consecutivo]['nombre']=$razonsocial21[0].$extra;
               if ($nivel > $maxnivel){$maxnivel=$nivel;}
               return $cerradura;

    } else {

 if ($fecha_org != "") {$extension=" and str_to_date(fecha,'%Y-%m-%d') < str_to_date(".$fecha_org.",'%Y-%m-%d')";}
//$ONE = "INSERT INTO `sidem_dev141008`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('$pfName', '100309 entre pfname". $pfName." ', 'ea', NULL);"; 
//$TWO = mysql_query($ONE);
//obtenpap(n)
  
$oneeva='(SELECT * FROM `empresa_empresa` where child_id = '. $pfName  .' and (matriz = \'FIRST\''; 
             $oneeva.='  or matriz = \'Yes\'  or matriz = \'YES\' or unico like \'FIRST IS PARENT%\') '.$extension.' )';
             $oneeva
       .='Union';
             $oneeva
       .='(SELECT * FROM `empresa_empresa` where parent_id = '. $pfName  .' and ( matriz = \'SECOND\' or matriz = \'No\'';
             $oneeva.='  or matriz = \'NO\' or unico like \'SECOND IS PARENT%\') '.$extension.' )';
             $oneeva
       .='order by fecha desc, jv desc';
$twoeva=mysql_query($oneeva);




// si hay papas

if ($threeva=mysql_fetch_row($twoeva))
{

$ONE = "INSERT INTO `sidem_dev141008`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('$pfName', '200409 threeva:". $threeva[0]." ".$threeva[6]." ', 'ea', NULL);"; 
$TWO = mysql_query($ONE);
// si jv llamar ascendencia de cada participante
if ($threeva[6]=='FIRST' || $threeva[6]=='YES' || preg_match("/JOINT VENTURE/i",$threeva[8]) )
                                                     {
             $i=0;
            $fecha_primer_jv=$threeva[7];
            // si el nodo dado corresponde al child 
            // ( ya esta validado qu son registros del padre del nodo ) 
            // --> parent es el padre de otra forma 
            if ($pfName==$threeva[2]){$jv[$i]=$threeva[1];} 
            else {$jv[$i]=$threeva[2];}
            $i++;
            while ($jointventure = mysql_fetch_row($twoeva) )
            {
               if ($fecha_primer_jv==$jointventure[7]  && ( $jointventure[6]=='FIRST' ||  $jointventure[6]=='YES' ||  preg_match("/JOINT VENTURE/i",$threeva[8])) ){
                if ($pfName==$jointventure[2]){$jv[$i]=$jointventure[1];}
                else {$jv[$i]=$jointventure[2];}
                $i++;
               } 
               else break;
      
            }
           //$storender="";
           for($j=0;$j<$i;$j++){
               
               $quien[$nivel]=$pfName;
               $storender=ascendencia($jv[$j],$nivel+1,$cerradura,$consecutivo,$maxnivel," <font size=1 face='Times'>en Joint Venture ($nivel)</font>",$fecha_org,$quien); }
               $razonsocial1= "SELECT value  FROM `document_fields_link`"
               ." WHERE `document_field_id`= 92  AND `document_id`=".$pfName;
               $razonsocial11 = mysql_query($razonsocial1);
               $razonsocial21=mysql_fetch_row($razonsocial11);
               $consecutivo++;
               $cerradura[$consecutivo]['id']=$pfName;
               $cerradura[$consecutivo]['nivel']=$nivel;
               $cerradura[$consecutivo]['nombre']=$razonsocial21[0].$extra;
               if ($nivel > $maxnivel){$maxnivel=$nivel;}
 }

//solo 1 matriz
 else if ($threeva[6]=='SECOND' || $threeva[6]=='No' || $threeva[6]= '' || $threeva[6] == NULL  || !preg_match("/JOINT VENTURE/i",$threeva[8]) )
                                                                 {
           if ($pfName==$threeva[2]){$nodo=$threeva[1];} 
            else {$nodo=$threeva[2];}
 $quien[$nivel]=$pfName;
            $storender=ascendencia($nodo,$nivel+1,$cerradura,$consecutivo,$maxnivel,"",$fecha_org,$quien);
   $razonsocial0= "SELECT value  FROM `document_fields_link`"
           ." WHERE `document_field_id`= 92  AND `document_id`=".$pfName;
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);
 $consecutivo++;
               $cerradura[$consecutivo]['id']=$pfName;
               $cerradura[$consecutivo]['nivel']=$nivel;
               $cerradura[$consecutivo]['nombre']=$razonsocial20[0].$extra;
               if ($nivel>$maxnivel){$maxnivel=$nivel;}
           

}
//llamada recursiva
} else  { 

$razonsocial= "SELECT value  FROM `document_fields_link`"
           ." WHERE `document_field_id`= 92  AND `document_id`=".$pfName;
$razonsocial1 = mysql_query($razonsocial);
$razonsocial2=mysql_fetch_row($razonsocial1);
 $consecutivo++;
               $cerradura[$consecutivo]['id']=$pfName;
               $cerradura[$consecutivo]['nivel']=$nivel;
               $cerradura[$consecutivo]['nombre']=$razonsocial2[0].$extra;
               if ($nivel>$maxnivel){$maxnivel=$nivel;}
 }          
//regresa papas
return $cerradura;
} // else de checaciclo

}

//****************************
 
function checahijo($pfName, $supuesto, &$padresjv, $fecha_org) {
	global $default;

$jv="";
        $i=0;$valorfuncion=0;

if ($fecha_org != "") {
$extension=" and str_to_date(fecha,'%Y-%m-%d') < str_to_date(".$fecha_org.",'%Y-%m-%d')";
//$extension=" and fecha < ".$fecha_org;
}
  
$oneeva='(SELECT * FROM `empresa_empresa` where child_id = '. $pfName  .' and (matriz = \'FIRST\' or matriz = \'Yes\'  or matriz = \'YES\' or unico like \'FIRST IS PARENT%\') '.$extension.' )';
$oneeva
       .='Union';
$oneeva
       .='(SELECT * FROM `empresa_empresa` where parent_id = '. $pfName  .' and ( matriz = \'SECOND\' or matriz = \'No\' or matriz = \'NO\' or unico like \'SECOND IS PARENT%\') '.$extension.' )';
$oneeva
       .='order by fecha desc, jv desc';
$twoeva=mysql_query($oneeva);




if ($threeva=mysql_fetch_row($twoeva))
{
if ($threeva[6]=='FIRST' || $threeva[6]=='YES' ||  preg_match("/JOINT VENTURE/i",$threeva[8]))
                              {
             $i=0;
            $fecha_primer_jv=$threeva[7];
            if ($pfName==$threeva[2]){$jv[$i]=$threeva[1];} 
            else {$jv[$i]=$threeva[2];}
            if ($supuesto==$threeva[2] or $supuesto==$threeva[1]){$valorfuncion=1;}
            else {$padresjv.=$jv[$i];}
             $i++;
            while ($jointventure = mysql_fetch_row($twoeva) )
            {

  if ($fecha_primer_jv==$jointventure[7]  && ( $jointventure[6]=='FIRST' || $jointventure[6]=='YES' ||  preg_match("/JOINT VENTURE/i",$threeva[8]) )) {
                if ($pfName==$jointventure[2]){$jv[$i]=$jointventure[1];}
                else {$jv[$i]=$jointventure[2];}
 if ($supuesto==$jointventure[2] or $supuesto==$jointventure[1]){$valorfuncion=1;}
            else{$padresjv.=$jv[$i];}
                $i++;
               } 
               else break;
      
            }
 }
 else if ($threeva[6]=='SECOND' || $threeva[6]=='No' || $threeva[6]= '' || $threeva[6] == NULL  ||  !preg_match("/JOINT VENTURE/i",$threeva[8]) )
                                              {
           if ($pfName==$threeva[2]){$nodo=$threeva[1];} 
            else {$nodo=$threeva[2];}
           if ($supuesto==$threeva[2] or $supuesto==$threeva[1]){$valorfuncion=1;}
            else{$padresjv.=$jv[$i];}
        
}
} 


return $valorfuncion;


}



//********************************

 
function descendencia($pfName,&$hijoslegit,&$consecutivo,$nivel,&$maxnivel,$extra,$fecha_org,$quien) {
	global $default;

//sacar todos los hijos en array de hijos

if (checaciclo($consecutivo,$hijoslegit,$pfName,$quien))
    {
     // poner datos y return
                return $hijoslegit;

    } else {




if ($fecha_org != "") {
$extension=" and str_to_date(fecha,'%Y-%m-%d') < str_to_date(".$fecha_org.",'%Y-%m-%d')";
//$extension=" and fecha < ".$fecha_org;
}
//$ONE = "INSERT INTO `sidem_dev141008`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('$pfName', '100309 entre pfname". $pfName." ', 'ea', NULL);"; 
//$TWO = mysql_query($ONE);

$oneeva='(SELECT * FROM `empresa_empresa` where child_id = '. $pfName  .' and (matriz = \'SECOND\' or matriz = \'No\' or matriz = \'NO\'  or unico like \'SECOND IS PARENT%\') '.$extension.' )';
          $oneeva
       .='Union';
          $oneeva
       .='(SELECT * FROM `empresa_empresa` where parent_id = '. $pfName  .' and (matriz = \'FIRST\' or matriz = \'Yes\' or matriz = \'YES\' or unico like \'FIRST IS PARENT%\')  '.$extension.' )';
          $oneeva
       .='order by fecha desc, jv desc';
$twoeva=mysql_query($oneeva);

     while ($hijos = mysql_fetch_row($twoeva) )
            {
  if ($pfName==$hijos[2])
                            {$hijo=$hijos[1];}
            else {$hijo=$hijos[2];}
$padresjv="";
 if (checahijo($hijo,$pfName,$padresjv,$fecha_org))
     { 
               $razonsocial1= "SELECT value  FROM `document_fields_link`"
                              ." WHERE `document_field_id`= 92  AND `document_id`=".$hijo;
               $razonsocial11 = mysql_query($razonsocial1);
               $razonsocial21 =  mysql_fetch_row($razonsocial11);
               $consecutivo++;
               $hijoslegit[$consecutivo]['id']=$hijo;
               $hijoslegit[$consecutivo]['nivel']=$nivel;
               $hijoslegit[$consecutivo]['nombre']=$razonsocial21[0].$extra;
               if ($nivel > $maxnivel){$maxnivel=$nivel;}
         //pon datos
        //llamada recursiva
               $storender=descendencia($hijo,$hijoslegit,$consecutivo,$nivel+1,$maxnivel,$extra,$fecha_org,$pfName);
     }

             }

return $hijoslegit;
} // del else de checaciclo
}





//mientras haya elementos en el array para cada elemento

//                -checa legitimidad de la paternidad del nodo que invoca

//                - forma array de hijos legitimos

//                -para cada hijo obtiene descendencia
// si no hay elementos regresa nodo que invoco excepto el del nivel 0





 
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



 

//=======MIKE======//






   $iddoc=$letra;
 echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";
 echo "<table style='text-align: left; width:80% ; ' border='1'  cellpadding='2' cellspacing='2'><tbody>

<tr>
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><font size=1 face='Arial'><tbody>";

  


$iddoc = $_GET["letra"];

$oDocument = & Document::get($iddoc);
  
 
  echo "<tr><TH rowspan='1'><TH colspan='3'align='center' bgcolor='orange'><font size=1 face='Arial' color='white'>Datos Inst/Organizaci&oacute;n</font></tr> <tr><td valign='center' height=40% align='left' bgcolor='lightgray'>";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
//   $docs="img/".$oDocument->getFileName();



$docs="/usr/local/apache_1.3.41/htdocs/FichasBD/branches/SY/Documents".$oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName();

 $tama=filesize($docs);


   
if ($tama >= 10){
 
 echo  "<img style=".'"'." width: 100px; height: 100px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src= ".'"'."http://proveedores.intelect.com.mx/FichasBD/branches/SY/Documents". $oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName().'"'." > </a></td>

<td >";
    }
 else
   {
 echo "<img style=".'"'." width: 100px; height: 100px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/nofotoe.jpg\" ></td>
<td >";

   }





if ($sectionName == "") {
    $sectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
}
 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====
$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$iddoc;
$indv_rel1 = mysql_query($indv_rel);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 

 if ($indv_rel2[2]==92) {
    $nomcom=$indv_rel2[3];
    
}
 if ($indv_rel2[2]==78 ){
   $fechreg=$indv_rel2[3];

}
 if ($indv_rel2[2]==57){
   $tel=$indv_rel2[3];

}
 if ($indv_rel2[2]==71 ){
    $raz=$indv_rel2[3];

}
if ($indv_rel2[2]==91 ){
    $fechfun=$indv_rel2[3];

}
 if ($indv_rel2[2]==93 ){
    $giro=$indv_rel2[3];

}
if ($indv_rel2[2]==94){
    $site=$indv_rel2[3];

}
if ($indv_rel2[2]==95 ){
    $clav=$indv_rel2[3];

}
if ($indv_rel2[2]==76 ){
    $infield=$indv_rel2[3];

}
if ($indv_rel2[2]==188 ){
    $orgtype=$indv_rel2[3];

}
if ($indv_rel2[2]==263 ){
    $subind=$indv_rel2[3];

}



if ($indv_rel2[2]==18 ){
    $lug=$indv_rel2[3];

$uno="SELECT `name` FROM `documents` WHERE `id` =".$lug;
$dos=mysql_query($uno);
$tres=mysql_fetch_row($dos);

$Lug=explode(" ",$tres[0]); 
}
 

}



 echo "<font size=1 face='Arial' color='blue'>TRADE NAME</font></td>
<td colspan=1><font size=1 face='Arial'>".$nomcom ."</font></td>";


 

if (userIsInGroup1(1)){
$bEdit=1;
if(!($sectionName =="Administration")){
echo"
<td>".displayBotonRelacInddesInst($oDocument, $bEdit) ."


".displayBotonRelacProdesdeInst($oDocument, $bEdit)."
".displayBotonRelacInstdesdeInst($oDocument, $bEdit) ."
".displayBotonRelacEventdesdeInst($oDocument, $bEdit) ."
".displayBotonRelacmultdesInst($oDocument, $bEdit)."
</td>"; 
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>"; 

	
				}	
		}

echo "
<tr><td bgcolor='lightgray'><font size=1 face='Arial' color='blue'>CORPORATE NAME</font></td>
<td colspan=2><font size=1 face='Arial' >".$raz ."</font></td>


</tr>
<tr><td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>RECORD DATE</font></td>
<td ><font size=1 face='Arial'>".$fechreg ."</font></td>
</tr>

<tr><td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>FOUNDATION DATE</font></td>
<td ><font size=1 face='Arial'>".$fechfun."</font></td>
</tr>
<!--
<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Giro Inicial</font></td>
<td ><font size=1 face='Arial'>".$giro."</font></td>

</tr>
-->
<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>PHONE NUMBER</font></td>
<td><font size=1 face='Arial'>".$tel ."</font></td>

</tr>

<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>TICKET SIMBOL2</font></td>
<td  colspan='2'><font size=1 face='Arial'>".$clav."</font></td>

</tr>
<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>INDUSTRY-FIELD</font></td>
<td  colspan='2'><font size=1 face='Arial'>".$infield."</font></td>

</tr>
<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>ORG. TYPE</font></td>
<td  colspan='2'><font size=1 face='Arial'>".$orgtype."</font></td>

</tr>
<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>SUB-INDUSTRY</font></td>
<td  colspan='2'><font size=1 face='Arial'>".$subind."</font></td>

</tr>

<tr>
<td  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>WEB SITE</font></td>
<td colspan='2'><font size=1 face='Arial'>".$site."</font></td>

</tr>

";
 


echo "</td></tr></table>";

echo "<tr><td>";

$cerradura="";
$nivel=0;
$maxnivel=0;
$fecha_org="'2050-03-22'";
$espacio="";
$consecutivo=0;
 $quien[$nivel]=$iddoc;
$miarreglo = ascendencia($iddoc,$nivel,$cerradura,$consecutivo,$maxnivel," Nodo origen",$fecha_org,$quien);
for($a=1;$a<=$consecutivo;$a++)
{
$espacio="";
for ($aa=0;$aa<=$maxnivel-$cerradura[$a]['nivel'];$aa++){$espacio.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}
echo $espacio.$cerradura[$a]['nombre']." "." "."<br/>";

}

$maxnivel=0;
$fecha_org="'2050-03-22'";
$espacio="";
$hijoslegit="";
$consecutivo=0;
$miarreglo = descendencia($iddoc,$hijoslegit,$consecutivo,$nivel, $maxnivel,"*",$fecha_org,0);

for($a=1;$a<=$consecutivo;$a++)
{
$espacio="";
for ($aa=0;$aa<=$hijoslegit[$a]['nivel'];$aa++){$espacio.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}
echo $espacio.$hijoslegit[$a]['nombre']."<br/>";

}
$padresjv="";
 //if (checahijo(1975,1083,$padresjv,$fecha_org)){echo $padresjv." si ";}

/************************** abajo para sacar los nombres del joint venture
  $razonsocial1= "SELECT value  FROM `document_fields_link`"
               ." WHERE `document_field_id`= 92  AND `document_id`=".$pfName;
               $razonsocial11 = mysql_query($razonsocial1);
               $razonsocial21=mysql_fetch_row($razonsocial11);
             

*************************/

echo "</td></tr>";
//================>>>> INICIA INDIVIDUOS ===============>>>>
echo "<tr><td>";


$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=4 and `status_id` = 1") or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
 $indice++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indice>0)
{

$cuentaindiv=0;



$result3= mysql_query("select * from trayectoria where parent_id= $iddoc or child_id= $iddoc ORDER BY trayectoria.Specific ASC ");

//order by el campo tipo specific, para esto poner un leftjoin a DFL estilo el mindmap

while($row3 =  mysql_fetch_row($result3))
{


 if ($row3[7]==0){

if (($cuentaindiv!=0) AND ($tipoactual!=$row3[9])){

//echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan='6'><font size=1 face='Arial'  color='white'><center>Specific Labour: ".$row3[9]."</center></font></th><tbody>";
echo "<tr>";

echo "<th  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Individuo</font></th>";
echo "<th  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nacionalidad</font></th>";
echo "<th  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Puesto</font></th>";
echo "<th  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha<br> de Inicio</font></th>
</tr>";

}

if ($cuentaindiv==0) {
$cuentaindiv++ ;

//echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan='6'><font size=1 face='Arial'  color='white'><center>Specific Labour: ".$row3[9]."</center></font></th><tbody>";
echo "<tr>";

echo "<th  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Individuo</font></th>";
echo "<th  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Nacionalidad</font></th>";
echo "<th  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Puesto</font></th>";
echo "<th  bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha<br> de Inicio</font></th>
</tr>";

 }


$tipoactual=$row3[9];

if ($row3[1]==$iddoc){$indv_id=$row3[2];}
else {$indv_id=$row3[1];}
$indv0="SELECT * FROM `individuos` WHERE `id` =".$indv_id;
$indv1=mysql_query($indv0);
$indv2=mysql_fetch_row($indv1);


echo "<tr>";

echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$indv2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$indv2[1] ." ".$indv2[2] ." ".$indv2[3] ."</font></a></td>";
echo "<td ><font size=1 face='Arial'>".$indv2[5] ."</font></td>";
echo "<td ><font size=1 face='Arial'>".$row3[3] ."</font></td>";
if ($row3>0){
echo "<td ><font size=1 face='Arial'>".$row3[6] ."</font></td>";
}
else
{echo "<td ><font size=1 face='Arial'>No hay Fecha de Inicio</font></td>";}
echo "</tr>&nbsp;";

 }


   
}// cierre del for





echo "</table>";


}  // fin de indice


echo "</tr></tbody></td></tr>";



//=================<<<< TERMINA INDIVIDUOS <<<<=============


//================>>>> INICIA EVENTOSB2B ===============>>>>
echo "<tr><td>";
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=41 and `status_id` = 1") or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
 $indice++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=6><font size=1 face='Arial'  color='white'><center>Evento Empresarial</center></font></th><tbody>";
echo "<tr>";

echo "<th bgcolor='lightgray' align='center'><font size=1 face='Arial' color='blue'>Multimedia</font></th>";
echo "<th bgcolor='lightgray' align='center'><font size=1 face='Arial' color='blue'>Fecha</font></td>";
echo "<th bgcolor='lightgray' align='center'><font size=1 face='Arial' color='blue'>Source</font></th>";
echo "<th bgcolor='lightgray' align='center'><font size=1 face='Arial' color='blue'>Summary</font></td>";
echo "<th bgcolor='lightgray' align='center'><font size=1 face='Arial' color='blue'>Region</font></td>";
echo "<th bgcolor='lightgray' align='center'><font size=1 face='Arial' color='blue'>Comentario</font></td>";






$result3= mysql_query("select id, parent_document_id, child_document_id from documents where (parent_document_id= $iddoc or child_document_id = $iddoc) and document_type_id=41 and status_id < 3 ");



while($rowevent =  mysql_fetch_row($result3))
{


if ($rowevent[1]==$iddoc){$event_id=$rowevent[2];}
else {$event_id=$rowevent[1];}
$ev0="SELECT * FROM `eventosb2b` WHERE `id` =".$event_id." ORDER BY `date` DESC";
$ev1=mysql_query($ev0);
$ev2=mysql_fetch_row($ev1);



echo "<tr>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$ev2[0] ."' target='_blank' ><font size=1 face='Arial'>Ver <br>Multimedia</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$ev2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$ev2[5] ."</font></a></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$ev2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$ev2[3] ."</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$ev2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$ev2[4] ."</font></td>";

echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$ev2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$ev2[1] ."</font></td>";
echo "<td ><font size=1 face='Arial'>".$rowevent[5] ." ".$partnomcomp."</font></td>";



echo "</tr>";


} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA EVENTOSB2B <<<<=============


//================>>>> INICIA EVENTOSB2B COMPETITOR ===============>>>>
echo "<tr><td>";
$resulta= mysql_query("SELECT * FROM `eventosb2b` WHERE competitor =".$iddoc." ORDER BY date DESC" ) or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
 $indice++; 
}
 


if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th bgcolor='orange' colspan=6><font size=1 face='Arial'  color='white'><center>Evento Empresarial COMPETITOR</center></font></th><tbody>";
echo "<tr>";

echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Multimedia</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha de Registro</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Source</font></th>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Summary</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Region</font></td>";
//echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Comentario</font></td>";




$eve0="SELECT * FROM `eventosb2b` WHERE competitor =".$iddoc." ORDER BY date DESC";
$eve1=mysql_query($eve0);
//$eve2=mysql_fetch_row($eve1);

while($eve2 =  mysql_fetch_row($eve1))
{

/**
if ($rowevent[1]==$iddoc){$event_id=$rowevent[2];}
else {$event_id=$rowevent[1];}
*/




echo "<tr>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$eve2[0] ."' target='_blank' ><font size=1 face='Arial'>Ver <br>Multimedia</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$eve2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$eve2[5] ."</font></a></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$eve2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$eve2[3] ."</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$eve2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$eve2[4] ."</font></td>";

echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$eve2[0] ."' target='fichas2' ><font size=1 face='Arial'>".$eve2[1] ."</font></td>";

//echo "<td ><font size=1 face='Arial'>".$rowevent[5] ." ".$partnomcomp."</font></td>";



echo "</tr>";


} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA EVENTOSB2B COMPETITOR <<<<=============


//================>>>> INICIA PRODUCTOS ===============>>>>
echo "<tr><td>";


$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=40 and `status_id` = 1") or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
 $indice++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th colspan=3 bgcolor='orange'><font size=1 face='Arial'  color='white'><center>Productos</center></font></th><tbody>";
echo "<tr>";

echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Producto</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Descripci&oacute;n</font></th>";

// a,b,c ... todos los campos de un documento especifico
// doc es el documento enlace y con el campo comentario
//h es hijo o padre de doc, es de tipo evento y ea,eb e... son sus campos



$result3= mysql_query("SELECT a.document_id, a.value,ea.value,eb.value,ec.value,ed.value, h.name,h.id, ee.value,h.id  FROM `document_fields_link` as a,`document_fields_link` as ea,`document_fields_link` as eb,`document_fields_link` as ec ,`document_fields_link` as ed ,`document_fields_link` as ee, `documents` as doc ,`documents` as h WHERE doc.`id` = a.`document_id` and a.`document_field_id`=8 AND ea.`document_id`=eb.`document_id` AND ea.`document_id`=ec.`document_id` AND ea.`document_id`=ed.`document_id`  AND ea.`document_field_id`=8 AND eb.`document_field_id`=8 AND ec.`document_field_id`=6 AND ed.`document_field_id`=8 AND ee.`document_field_id`=6 AND ee.`document_id`=ea.`document_id` AND (((h.`id` = doc.`parent_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=39) or ((h.`id` = doc.`child_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=39))  and doc.`document_type_id`=40 and doc.`status_id` = 1 and ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) order by eb.value desc ") or die("deadw"); 

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


echo "<tr>";

echo "<td ><a href='/FichasBD/branches/SY_devel/control.php?action=getfprod&letra=".$row3[7] ."' target='fichas2' ><font size=1 face='Arial'>".$row3[2] ."</font></td>";
echo "<td ><font size=1 face='Arial'>".$row3[4] ."</font></td>";

echo "</tr>";


} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice



//=================<<<< TERMINA PRODUCTOS <<<<=============


//================>>>> INICIA INSTITUTO ===============>>>>
echo "<tr><td>";


$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 171 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=46 and a.`status_id` = 1 order by b.`value`") or die("deadw1");

$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indice++; 
}
 
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><th colspan=9 bgcolor='orange'><font size=1 face='Arial'  color='white'><center>Instituto</center></font></thead><tbody>";
echo "<tr>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Multimedia</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Instituto</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Razon Sozial</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha de <br>Registro</font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Fecha de <br>Fundacion </font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Industria_Ambito </font></td>";
echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Telefono</font></td>";

echo "<th bgcolor='lightgray'><font size=1 face='Arial' color='blue'>Sitio Web</font></td>";
//echo "<th><font size=2 face='Times' color='blue'></font></th>";

echo "</tr>";




/**
$res0= mysql_query("SELECT a.document_id, a.value, b.value, c.value, d.value, a.id, f.value, h.name,h.id, g.value FROM `document_fields_link` as a , `document_fields_link` as b , `document_fields_link` as c, `document_fields_link` as d , `document_fields_link` as f, `document_fields_link` as g  ,`documents` as doc ,`documents` as h  WHERE a.`document_id` = b.`document_id` and b.`document_id` = c.`document_id` and a.`document_id` = d.`document_id` and a.`document_id` = f.`document_id` and a.`document_id` = g.`document_id` and  a.`document_field_id` = 78 and b.`document_field_id` = 57 and c.`document_field_id` = 92 and d.`document_field_id` = 91  and f.`document_field_id` = 71 and g.`document_field_id` = 94 and doc.`id` = a.`document_id`  and (((h.`id` = doc.`parent_document_id`) and doc.`parent_document_id`<> $iddoc) or ((h.`id` = doc.`child_document_id`)and doc.`child_document_id`<> $iddoc))  and h.`document_type_id`=22 and a.`document_id`=doc.id  AND ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) and doc.`document_type_id`=46 and doc.`status_id` = 1 order by d.value desc,h.name desc ") or die("deadw"); 
*/

$result3= mysql_query("select * from empresa_empresa where parent_id= $iddoc or child_id = $iddoc");

while($row0 =  mysql_fetch_row($result3))
{
  


if ($row0[1]==$iddoc){$inst_id=$row0[2];}
else {$inst_id=$row0[1];}
$emp0="SELECT * FROM `empresas` WHERE `id` =".$inst_id;
$emp1=mysql_query($emp0);
$emp2=mysql_fetch_row($emp1);


/**
if ($lug>0){
$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$row3[5];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$Lug=explode(" ",$threev1[0]);
} else {$Lug=explode("_"," _N/A_ _ _ ");}

*/
echo "<tr>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$emp2[0] ."' target='_blank' ><font size=1 face='Arial'>Ver<br>Multimedia</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' ><font size=1 face='Arial'>". $emp2[3]."</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' ><font size=1 face='Arial'>". $emp2[5]."</font></td>";
echo "<td ><font size=1 face='Arial'>". $row0[7]."</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' ><font size=1 face='Arial'>". $emp2[4]."</font></td>";
echo "<a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' ><td ><font size=1 face='Arial'>". $emp2[7]."</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' ><font size=1 face='Arial'>". $emp2[1]."</font></td>";
echo "<td ><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emp2[0] ."' target='fichas2' ><font size=1 face='Arial'>". $emp2[6]."</font></td>";


/**
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY_devel/control.php?action=getficha&letra=".$row0[7] ."' target='fichas2' >".$row0[0] ." ".$row0[1] ."".$row0[2] ." ".$row0[3] ." ".$row0[4] ."</font></a></td>";

*/


echo "</tr>";

} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA INSTITUTO <<<<=============



//=================>>>> INICIA MULTIMEDIA =============>>>>


echo "<tr><td>";


$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 12 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=49 and a.`status_id` = 1 order by b.`value`") or die("deadw1");

$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indice++; 
}
 
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Multimedia</center></font></thead><tbody>";
echo "<tr>";

echo "<th><font size=2 face='Times' color='blue'>ID</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Archivo</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Comentario</font></td>";


echo "</tr>";





$result3= mysql_query("select * from empresa_multimedia where parent_id= $iddoc or child_id = $iddoc");



while($row0 =  mysql_fetch_row($result3))
{
  


if ($row0[1]==$iddoc){$mult_id=$row0[2];}
else {$mult_id=$row0[1];}
$mult0="SELECT * FROM `multimedia` WHERE `id` =".$mult_id;
$mult1=mysql_query($mult0);
$mult2=mysql_fetch_row($mult1);


$busq_links="SELECT `filename` FROM `documents` WHERE `status_id`<=2 AND `document_type_id`= 33 AND `id`=".$mult2[0];
$busq_links1 = mysql_query($busq_links);
$busq_links2 = mysql_fetch_row($busq_links1);

echo "<tr>";

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='_blank' >". $mult2[0]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='_blank' > ".$busq_links2[0]."</font></td>";
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getmultimedia&letra=".$iddoc ."' target='_blank' >". $mult2[1]."</font></td>";


echo "</tr>";

} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA MULTIMEDIA <<<<=============

echo "</table>";


// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 


 
 


 


 }

 ?>