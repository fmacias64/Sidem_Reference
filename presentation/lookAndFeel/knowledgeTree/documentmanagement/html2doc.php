<?php
require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {
       $letra = $_GET["letra"];
	include("html_to_doc.inc.php");
	
	$htmltodoc= new HTML_TO_DOC();
	
//	$htmltodoc->createDoc("<h1>hola que onda</h1>","test",1);
	$htmltodoc->createDocFromURL("http://proveedores.intelect.com.mx/FichasBD/branches/SY/control.php?action=getword&letra=".$letra,"test2",1);
	//echo hola;
}

?>