<?php
/**
 * $Id: listUsersBL.php,v 1.13 2004/12/20 10:56:28 nbm Exp $
 *
 * List users.
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
 * @version $Revision: 1.13 $
 * @author Omar Rahbeeni, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.usermanagement
 */

require_once("../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fGroupID', 'fName');

require_once("$default->fileSystemRoot/lib/users/User.inc");    
require_once("$default->fileSystemRoot/lib/security/Permission.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");    
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternTableSqlQuery.inc");    
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternListBox.inc");    
require_once("$default->fileSystemRoot/presentation/Html.inc");
require_once("listUsersUI.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/administration/adminUI.inc");

if (checkSession()) {	
    $oPatternCustom = & new PatternCustom();
    if (Permission::userIsUnitAdministrator() && !$fGroupID) {
    	// #3519 select a group in your unit if you're a unit administrator and none has been selected
	    $sql = $default->db;
        /*ok*/ $sQuery = array("SELECT group_id FROM $default->groups_units_table WHERE unit_id = ? ORDER BY group_id", User::getUnitID($_SESSION["userID"]));
	    $sql->query($sQuery);
	    if ($sql->next_record()) {
	        $fGroupID = $sql->f("group_id");
	    }
    } else {
    	$default->log->info("fGroupID=$fGroupID");
    }
    $oPatternCustom->setHtml(getPage($fGroupID, $fName));
	require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
	$main->setCentralPayload($oPatternCustom);
	$main->setFormAction($_SERVER['PHP_SELF']);	
    $main->render();	
}
?>
