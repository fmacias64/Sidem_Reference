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
	
	
	function PatternMetaData2($sNewMetaDataField, $sNewFormName, $sNewValue = null, $sTabliux = null, $sParametriux = null) {
		$this->sMetaDataField = $sNewMetaDataField;
		$this->sFormName = $sNewFormName;
		$this->sValue = $sNewValue;
                $this->sTabla = $sTabliux;
                $this->sParametro = $sParametriux;
	}
	
	
	function render() {
		global $default;

		if (strcmp($this->sParametro,"Paterno")){
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
				}

}
}
?>
