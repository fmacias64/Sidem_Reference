<?php

require_once("../../../../config/dmsDefaults.php");


if (checkSession()) {

require_once("../../../../lib/util/sanitize.inc");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");

echo $_SESSION["userID"];

	$status = "";

	if($_POST["action"]== "upload")

	 {
	$tamaño = $_FILES["file"]["size"];
	$tipo = $_FILES["file"]["type"];
	$archivo = $_FILES["file"]["name"];
	$prefijo = substr(md5(uniqid(rend())),0,6);


	if ($archivo != "")
	{
	$destino = "/usr/local/apache_1.3.41/htdocs/FichasBD/branches/SY/tmp/".$prefijo."_".$archivo;

	if(copy($_FILES["archivo"]["tmp_name"],$destino))
	{
	$status = "Archivo subido: <b>".$archivo."</b>";
 	}
	else
	 {
	$status = "ERORO AL SUBIR EL ARCHIVO!!";
	 }

	}

	else
	 {
	$status = "ERORO AL SUBIR EL ARCHIVO!!";
	 }
	 }


 }





?>