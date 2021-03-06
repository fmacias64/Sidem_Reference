<?php
/**
 * $Id: editPrefsSuccess.php,v 1.3 2003/08/12 10:07:15 michael Exp $
 *
 * Edit user preferences success page.
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
 * @version $Revision: 1.3 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package preferences
 */

require_once("../../../../config/dmsDefaults.php");
require_once("editUserPrefsUI.inc");

global $default;

if(checkSession()) {

    // include the page template (with navbar)
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");

    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml(getEditPageSuccess());
    $main->setCentralPayload($oPatternCustom);
    $main->render();

}
?>