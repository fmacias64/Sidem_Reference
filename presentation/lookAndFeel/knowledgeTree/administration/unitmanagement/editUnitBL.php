<?php
/**
 * $Id: editUnitBL.php,v 1.9 2004/11/26 21:10:48 nbm Exp $
 *
 * Edit a unit.
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
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.unitmanagement
 */
require_once("../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fForStore', 'fUnitID', 'fUnitName');

if (checkSession()) {
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternListBox.inc");
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternEditableListFromQuery.inc");
    require_once("editUnitUI.inc");
    require_once("$default->fileSystemRoot/lib/security/Permission.inc");
    require_once("$default->fileSystemRoot/lib/unitmanagement/Unit.inc");
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");
    require_once("$default->fileSystemRoot/lib/foldermanagement/Folder.inc");
    require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/foldermanagement/folderUI.inc");
    require_once("$default->fileSystemRoot/presentation/Html.inc");


    $oPatternCustom = & new PatternCustom();

    // if a new unit has been added
    // coming from manual edit page
    if (isset($fForStore)) {
        
        $oUnit = Unit::get($fUnitID);
        
        $oUnit->setName($fUnitName);
                
        if ($fUnitName== "") {
            $oPatternCustom->setHtml(getEditPageFail());
        }elseif ($oUnit->update()) {
            // if successfull print out success message
            $oPatternCustom->setHtml(getEditPageSuccess());
        } else {
            // if fail print out fail message
            $oPatternCustom->setHtml(getEditPageFail());
        }
    } else if (isset($fUnitID)) {
        // post back on Unit select from manual edit page
        $oPatternCustom->setHtml(getEditPage($fUnitID));
        $main->setFormAction($_SERVER["PHP_SELF"] . "?fForStore=1&fUnitID=$fUnitID");
    } else {
        // if nothing happens...just reload edit page
        $oPatternCustom->setHtml(getEditPage(null));
        $main->setFormAction($_SERVER["PHP_SELF"]);
    }
    //render the page
    $main->setCentralPayload($oPatternCustom);
    $main->render();
}
?>
