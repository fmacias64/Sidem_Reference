<?php
/**
 * $Id: editDocFieldLookupsBL.php,v 1.4 2005/07/21 08:14:38 nbm Exp $
 *
 * Edit document field lookups.
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
 * @version $Revision: 1.4 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.docfieldmanagement
 */

require_once("../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fDocFieldID');

if (checkSession()) {
    require_once("editDocFieldLookupsUI.inc");
    require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentField.inc");
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");    
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");

    $oPatternCustom = & new PatternCustom();

    if(isset($fDocFieldID)) { 
        $oDocField = DocumentField::get($fDocFieldID);
        if ($oDocField->getHasLookup()){
	        // do a check to see both drop downs selected
            $oPatternCustom->setHtml(getPage($oDocField));
        } else {
            $_SESSION["KTErrorMessage"][] = _("Document Field is not Lookup enabled.");
            exit(controllerRedirect("listDocFields"));
        }
    } else {
        $_SESSION["KTErrorMessage"][] = _("No document field lookup selected");
        exit(controllerRedirect("listDocFields"));
    }

    // render page
    $main->setCentralPayload($oPatternCustom);
    $main->render();
}
?>
