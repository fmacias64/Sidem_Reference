<?php
/**
 * $Id: editMetaDataBL.php,v 1.8 2004/11/26 21:10:43 nbm Exp $
 *
 * Edit MetaData entry.
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
 * @version $Revision: 1.8 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.docfieldmanagement.metadatamanagement
 */

require_once("../../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fDocFieldID', 'fForStore', 'fMetaDataID', 'fMetaDataName', 'fOldMetaDataName', 'fSelected');

if (checkSession()) {
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternListBox.inc");
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternEditableListFromQuery.inc");
    require_once("editMetaDataUI.inc");
    require_once("$default->fileSystemRoot/lib/security/Permission.inc");
    require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentField.inc");
    require_once("$default->fileSystemRoot/lib/documentmanagement/MetaData.inc");
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");
    require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
    require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/foldermanagement/folderUI.inc");
    require_once("$default->fileSystemRoot/presentation/Html.inc");

    $oPatternCustom = & new PatternCustom();
    if(isset($fDocFieldID)) {        
	        // post back on DocField select from manual edit page
	        $oPatternCustom->setHtml(getSelectMetaDataPage($fDocFieldID,$fMetaDataID));
	        $main->setFormAction($_SERVER["PHP_SELF"] . "?fSelected=1");	    
        	//$oPatternCustom->setHtml(getEditMetaDataFailPage($fDocFieldID));        
    } else {
        // if nothing happens...just reload edit page
        $oPatternCustom->setHtml(getSelectFieldPage(null));
        $main->setFormAction($_SERVER["PHP_SELF"]);
    }

    if(isset($fSelected)) {
        
	        $oPatternCustom->setHtml(getEditMetaDataPage($fDocFieldID,$fMetaDataID));
	        $main->setFormAction($_SERVER["PHP_SELF"] . "?fForStore=1");       
    }

    if(isset($fForStore)) {
        if($fMetaDataName != "") {
            $oMetaData = new MetaData($fDocFieldID,$fMetaDataName);
            $oMetaData->setMetaDataID($fDocFieldID,$fOldMetaDataName);
            if($oMetaData->update()) {
                $oPatternCustom->setHtml(getSuccessPage($fDocFieldID));
            } else {
                $oPatternCustom->setHtml(getFailPage($fDocFieldID));
            }
        } else {
            $oPatternCustom->setHtml(getTextPage($fDocFieldID));
        }
    }

    //render the page
    $main->setCentralPayload($oPatternCustom);
    $main->setHasRequiredFields(true);    
    $main->render();
}
?>
