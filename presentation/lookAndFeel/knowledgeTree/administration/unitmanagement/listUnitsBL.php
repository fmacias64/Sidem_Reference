<?php
/**
 * $Id: listUnitsBL.php,v 1.9 2004/11/26 21:10:48 nbm Exp $
 *
 * List units.
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
 * @author Omar Rahbeeni, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.unitmanagement
 */
require_once("../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fOrganisationID');

require_once("$default->fileSystemRoot/lib/users/User.inc");    
require_once("$default->fileSystemRoot/lib/security/Permission.inc");
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");    
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternTableSqlQuery.inc");    
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternListBox.inc");    
require_once("$default->fileSystemRoot/presentation/Html.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/administration/adminUI.inc");
require_once("listUnitsUI.inc");

if (checkSession()) {	
    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getPage($fOrganisationID));
	require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
	$main->setCentralPayload($oPatternCustom);
	$main->setFormAction($_SERVER['PHP_SELF']);	
    $main->render();	
}
?>
