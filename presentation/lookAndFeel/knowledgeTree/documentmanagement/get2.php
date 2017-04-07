
<?php
//echo 'oh';
require_once("../../../../config/dmsDefaults.php");
require_once("../../../../lib/util/sanitize.inc");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
echo $_SESSION["userID"];


//if (!checkSession2()) {
//echo 'oh';
//   $cookietest = KTUtil::randomString();
//  setcookie("CookieTestCookie", $cookietest, false);


  $dbAuth = new $default->authenticationClass;
        $userDetails = $dbAuth->login("admin","admin");

//
//    $session = new Session();
//          $sessionID = $session->create($userDetails["userID"]);

            // initialise page-level authorisation array
//          $_SESSION["pageAccess"] = NULL;
//    echo $_SESSION["userID"];

            // check for a location to forward to
          
//echo 'eh';
//}           

//echo 'ah';
$id_docactual=256;
$id_enlacesel=34;
 

//============================>>
$one= "SELECT  `enlazadoA`, `enlazadoB`  FROM `document_types_lookup` WHERE `id` =".$id_enlacesel;
$two = mysql_query($one);
$tipodocs_enlazados = mysql_fetch_row($two);


//===========================>>
$tres= "SELECT `document_type_id`  FROM `documents` WHERE `id` =".$id_docactual;
$cuatro = mysql_query($tres);
$tipo_docactual = mysql_fetch_row($cuatro);


//==========================>>
 if ($tipo_docactual[0] == $tipodocs_enlazados[0]){
//desplegar enlazadoB
 

//=======MIKE======//
//== busqueda de todos aquellos individuos relacionados con el documento 256 y q su link sea de tipo individuo has individuo ==

$busq_links="SELECT `child_document_id` FROM `document_link` WHERE `parent_document_id`=256 AND `link_type_id`=20";
$busq_links1 = mysql_query($busq_links);
//$busq_links2 = mysql_fetch_row($busq_links1);

 echo "<table style='text-align: left; width:100% ; background-color: rgb(220, 220,220);' border='1'  cellpadding='2' cellspacing='2'><tbody><tr>
      <td><table align='left' style='text-align: left; width:30% ;' border='0'  cellpadding='4' cellspacing='4'><tbody>";
 while ($busq_links2 = mysql_fetch_row($busq_links1))
{
$oDocument = & Document::get($busq_links2[0]);
  

  echo "<tr><td style='background-color: rgb(190, 190,190);'>";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 

 echo  "<a href='http://www.intelect.com.mx:82/~FichasBD/branches/fichas_alpha/control.php?action=viewDocument&fDocumentID=".$busq_links2[0]."' target='fichas2' ><img style=".'"'." width: 50px; height: 50px;".'"'." alt= ".'"'.$oDocument->getName().'"'." src= ".'"'."http://www.intelect.com.mx:82/~FichasBD/branches/fichas_alpha/Documents". $oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName().'"'." > </a><br/>";
  
 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====
$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$busq_links2[0];
$indv_rel1 = mysql_query($indv_rel);
//$indv_rel2 = mysql_fetch_row($indv_rel1);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 

  echo  "<a href='http://www.intelect.com.mx:82/~FichasBD/branches/fichas_alpha/control.php?action=viewDocument&fDocumentID=".$busq_links2[0]."' target='fichas2' >".$indv_rel2[3]."</a><br/>";

 
}

}
echo "</td></tr></table><table align='right' style='text-align: left; width:20% ;' border='1'  cellpadding='2' cellspacing='2'>
<tr><td><iframe src='http://www.intelect.com.mx:82/~FichasBD/branches/fichas_alpha' name='fichas2' width='450' height='500' scrolling='auto' frameborder='1' transparency></iframe></td></tr></tbody></tbody></table></table>";

//===========>>  Busqueda de nombres de documento de Individuo   =========>>
//======== busqueda de todos aquellos documentos q sean de tipo individuo =======
/**
$bus_one="SELECT `name`,`document_type_id`  FROM `documents` WHERE `document_type_id`=18";
$bus_two = mysql_query($bus_one);


echo "<table style='text-align: left; width:100% ;' border='1'  cellpadding='2' cellspacing='2'><tbody><tr>
      <td><table align='left' style='text-align: left; width: ;' border='1'  cellpadding='2' cellspacing='2'><tbody>";

 while($busq_doc_indv = mysql_fetch_row($bus_two))
   {


 echo "<tr><td style='background-color: rgb(255, 255, 0);'>".$busq_doc_indv[0]."<br/></td></tr>";
 
   }
echo "</td></tr></table><table align='right' style='text-align: left; width:20% ;' border='1'  cellpadding='2' cellspacing='2'>
<tr><td><iframe src='http://www.google.com.mx' name='' width='450' height='500' scrolling='auto' frameborder='1' transparency></iframe></td></tr></tbody></tbody></table></table>";
*/
//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 

//while fetch row
while ($enlaceB=mysql_fetch_row($linkB)){

  //  echo "obj.options[obj.options.length] = new Option('$enlaceB[0] $enlaceB[1]','$enlaceB[1]');\n";

}
 
 }
 
 elseif ($tipo_docactual[0] == $tipodocs_enlazados[1]){
//desplegar enlazadoA
$LinkA2 = "SELECT `name`, `id` FROM  `documents` WHERE  `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[0];
$LinkB2 = mysql_query($LinkA2);


while ($enlaceA=mysql_fetch_row($LinkB2)){


  //  echo "obj.options[obj.options.length] = new Option('$enlaceA[0] $enlaceA[1]','$enlaceA[1]');\n";

}
 }
//;  $sessionID = $session->destroy($userDetails["userID"]);




?>