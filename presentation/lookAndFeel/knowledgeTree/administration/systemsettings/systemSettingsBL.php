<?php
/**
 * $Id: systemSettingsBL.php,v 1.11 2004/11/26 21:10:47 nbm Exp $
 *
 * Edit system settings.
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
 * @version $Revision: 1.11 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.systemsettings
 */
require_once("../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fForStore');

if (checkSession()) {
	require_once("$default->fileSystemRoot/lib/System.inc");
    require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");
    require_once("$default->fileSystemRoot/presentation/Html.inc");
    require_once("systemSettingsUI.inc");

    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
    $oPatternCustom = & new PatternCustom();
    
    if(isset($fForStore)) {
        $oSystem = $default->system;
        for($i = 0; $i < count($oSystem->aSettings); $i++) {
            $oSystem->set($oSystem->aSettings[$i], $_POST[$oSystem->aSettings[$i]]);
        }
        controllerRedirect("systemAdministration");
    } else {
        $oPatternCustom->setHtml(getPage());
        $main->setFormAction($_SERVER["PHP_SELF"]. "?fForStore=1");
    }
    $main->setCentralPayload($oPatternCustom);
    $main->render();
}
?>
