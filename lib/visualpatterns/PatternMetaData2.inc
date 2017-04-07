<?php

require_once("PatternListBox2.inc");
/**
 * $Id: PatternMetaData.inc,v 1.9 2005/06/06 20:48:05 nbm Exp $
 *
 * Renders document field appropriately (as a listbox if required).
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
 * @version $Revision: 1.9 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package lib.visualpatterns
 */
class PatternMetaData2 {

        var $sTabla; 
	var $sMetaDataField;
	var $sFormName;
	var $sValue;
	/** 1 = drop down, 2 = text field */
	var $iType;
        var $sParametro;
	
	
	function PatternMetaData2($sNewMetaDataField, $sNewFormName, $sNewValue = null, $sTabliux = null, $sParametriux = null ) {
		$this->sMetaDataField = $sNewMetaDataField;
		$this->sFormName = $sNewFormName;
		$this->sValue = $sNewValue;
                $this->sTabla = $sTabliux;
                $this->sParametro = $sParametriux;
	}
	
	 //<input name="email" type="text" required="1" mask='email' onkeyup="Mayus(email)">

	function render($param) {
		global $default;

	if (!strcmp($param,"Fecha")){
$sToRender.="<script type='text/JavaScript' src='$default->rootUrl/lib/visualpatterns/calendario.js'></script>";
  $sToRender .= "<input onclick='scwShow(this,event);'".' type="text" size="30" name="%s" value="%s" />' ;
		                                       
return sprintf($sToRender, $this->sFormName,$this->sValue);
}

     else if (!strcmp($param,"Nombre")){
  
  $sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/lib/visualpatterns/validacion.js"></script><input type="text" size="50" name="%s" value="%s" onkeyup="Mayus(%s)" />' ;
		                                       
return sprintf($sToRender, $this->sFormName,$this->sValue, $this->sFormName);
	}

	else if (!strcmp($param,"Materno")){
  
  $sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/lib/visualpatterns/validacion.js"></script><input type="text" size="50" name="%s" value="%s" onkeyup="Mayus(%s)" />' ;
		                                       
return sprintf($sToRender, $this->sFormName,$this->sValue, $this->sFormName);
	}

	else if (!strcmp($param,"Organizacion")){
  
  $sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/lib/visualpatterns/validacion.js"></script><input type="text" size="50" name="%s" value="%s" onkeyup="Mayus(%s)" />' ;
		                                       
return sprintf($sToRender, $this->sFormName,$this->sValue, $this->sFormName);
	}

	else if (!strcmp($param,"Puesto")){
  
  $sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/lib/visualpatterns/validacion.js"></script><input type="text" size="50" name="%s" value="%s" onkeyup="Mayus(%s)" />' ;
		                                       
return sprintf($sToRender, $this->sFormName,$this->sValue, $this->sFormName);
	}
         
	//ONCLICK="return isEmailAddress(TextField,'TextField' )
else if (!strcmp($param,"E-MAIL")){
  
  $sToRender .= '<SCRIPT LANGUAGE="JavaScript">
function isEmailAddress(theElement, nombre_del_elemento )
{
var s = theElement.value;
var filter=/^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
if (s.length == 0 ) return true;
if (filter.test(s))
return true;
else
alert("Ingrese una direcci\u00F3n de correo v\u00E1lida");
theElement.focus();
return false;
}
</SCRIPT><input type="text" size="50" name="%s" value="%s" onchange="return isEmailAddress(%s,%s)" />' ;
		                                       
return sprintf($sToRender, $this->sFormName,$this->sValue, $this->sFormName, $this->sFormName);
	}
/**
else if	(!strcmp($param,"Telefono")){

$sToRender .= "<script language=\"JavaScript\">
<!--
var nav4 = window.Event ? true : false;
function acceptNum(evt){    
var key = nav4 ? evt.which : evt.keyCode;   
return (key <= 13 || (key>= 48 && key <= 57));
}
//-->
</script><input type='text' size='20' name='%s' value='%s' maxlength='12' onkeypress='return acceptNum(event)' />";

return sprintf($sToRender, $this->sFormName,$this->sValue, $this->sFormName);
}

*/
              		else if (strcmp($param,"Paterno")){
$explparam= explode("_",$param);
// aqui puede ir lo de k_instituto_organizacion
//

if ((!strcmp($explparam[0],"k")) && !(!strcmp($explparam[1],"zLugares")))
 {



//Abajo preparacion de unique_exception
//$sNombreForma=explode("_",$this->sFormName);
//$sToRender .= "\n<input type=\"hidden\" size=\"50\" name=\"unique_exception_$sNombreForma[0]\"  />"; 

// Fin unique_exception

//$sToRender .= "\n<input type=\"text\" size=\"50\" name=\"%s\" onkeyup=\"ajax_showOptions(this,'action=dynlist&tipo=22&getCountriesByLetters', ";
//$sToRender .= " '$default->rootUrl/control.php' ,event)\" />"; 


$nombreCampo=explode("_",$this->sFormName);
$nombreCampo[1]--;
$sNomCamp=$nombreCampo[0]."_".$nombreCampo[1];
if ($this->sValue > 0) {
$NombreEmpresa = "SELECT name FROM  `documents` WHERE status_id = 1 and id=".$this->sValue;
$NombreEmpresa2 = mysql_query($NombreEmpresa);
$NombreEmpresa3=mysql_fetch_row($NombreEmpresa2);
}
else
{$NombreEmpresa3[0]="";
}
//$sToRender .= "\n<input type=\"text\" size=\"50\" id=\"%s\" name=\"%s\" value=\"%s\" onload=\"CambiaCamp('".$sNomCamp."_ignorar"."','".$NombreEmpresa3[0]."')\" />";
//$sToRender .= "\n<input type=\"text\" size=\"50\" id=\"%s\" name=\"%s\" value=\"%s\" readonly />";
$sToRender .= "\n<input type=\"text\" size=\"50\" id=\"%s\" name=\"%s\" value=\"%s\" />";
$sToRender .= "<script type=\"text/javascript\">CambiaCamp('".$sNomCamp."_ignorar"."','".$NombreEmpresa3[0]."')</script>";




return sprintf($sToRender, $this->sFormName , $this->sFormName,$this->sValue);
}


// aqui termina lo de ajax de instituto/organizacion

if (!strcmp($explparam[1],"zLugares"))
{
if($this->sValue>0)
{
$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$this->sValue;
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$this->sValue;
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$this->sValue;
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);
$sToRender .= "<SELECT  ID=\"%s\" NAME=\"%s\"   SIZE=\"1\">";
 $sToRender .= "<OPTION VALUE=\"%s\">$dato1[0],$dato2[0], $dato3[0] </OPTION></SELECT>";
//$sToRender.="<input type='text' size='20' name='%s' value='%s' maxlength='12' />";

return sprintf($sToRender,$this->sFormName, $this->sFormName,$this->sValue, $this->sFormName);
}//si value es mayor a 0 arriba si no abajo
else
{
$sToRender .= "<SELECT ID=\"%s\" NAME=\"%s\"   SIZE=\"1\">";
 $sToRender .= "<OPTION VALUE=\"%s\">.</OPTION></SELECT>";
//$sToRender.="<input type='text' size='20' name='%s' value='%s' maxlength='12' />";

return sprintf($sToRender,$this->sFormName, $this->sFormName,$this->sValue, $this->sFormName);
}

}
else
{

				$sWhereClause = " document_type_id  = \"$this->sTabla\"";
				//	$sFromClause = "";

				// poner case dependiendo de que tabla se requiere desplegar en la captura
				$oPatternListBox = & new PatternListBox2("$default->document_table", "ST.name", "id", $this->sFormName);
                                
				//$oPatternListBox-> setCompositeDisplayName("id");
				$elqueriux = "SELECT name AS display, id AS value from documents WHERE document_type_id =\" $this->sTabla\"  AND status_id = 1";
                     $oPatternListBox-> setQuery($elqueriux);

				if ($this->sValue != null) {
					$oPatternListBox->setSelectedValue($this->sValue);
				}
				//	$oPatternListBox->setFromClause($sFromClause);
                $oPatternListBox->setWhereClause($sWhereClause);				
				return $oPatternListBox->render();
		}//else Lugares
}//if caso k = No paterno

		else{ 

		  $sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/ajax.js"></script>';
		  $sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/ajax-dynamic-list.js"></script>';
		  $sToRender .= '<script type="text/javascript" src="'.$default->rootUrl.'/lib/visualpatterns/validacion.js"></script>';
                  $sToRender .= "\n<input type=\"text\" size=\"50\" name=\"%s\" value=\"%s\" onchange='Mayus(%s)' onkeyup=\"ajax_showOptions(this,'action=dynlist&tipo=18&getCountriesByLetters', ";
$sToRender .= " '$default->rootUrl/control.php' ,event)\" />";
 


		                                       
return sprintf($sToRender, $this->sFormName,$this->sValue, $this->sFormName);
	      
		}

	}
}
?>
