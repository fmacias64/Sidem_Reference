<?php
/**
 * $Id: addWebsiteSuccess.php,v 1.9 2004/11/26 21:10:48 nbm Exp $
 *
 * Add a website success page.
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
 * @package administration.websitemanagement
 */

require_once("../../../../../config/dmsDefaults.php");

global $default;

if(checkSession()) {
    // include the page template (with navbar)
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");

    $Center .= renderHeading(_("Add Website"));
    $Center .= "<TABLE BORDER=\"0\" CELLSPACING=\"2\" CELLPADDING=\"2\">\n";
    $Center .= "<tr>\n";
    if($_REQUEST['fWebSiteID'] != -1) {
        $Center .= "<td><b>" . _("New Website Added SuccessFully") . "!<b></td>\n";
    } else {
        $Center .= "<td><b>" . _("Addition Unsuccessful") . "</b>...</td>\n";
        $Center .= "</tr>\n";
        $Center .= "<tr></tr>\n";
        $Center .= "<tr></tr>\n";
        $Center .= "<tr>\n";
        $Center .= "<td>" . _("Please Check for duplicates!") . "</td>\n";
        $Center .= "</tr>\n";
        $Center .= "<tr>\n";
    }

    $Center .= "<tr></tr>\n";
    $Center .= "<tr></tr>\n";
    $Center .= "<tr></tr>\n";
    $Center .= "<tr></tr>\n";
    $Center .= "<tr>\n";
    $Center .= "<td align = right><a href=\"$default->rootUrl/control.php?action=addWebsite\">".
               "<img src=\"" . KTHtml::getBackButton() . "\" border = \"0\"></a></td>\n";
    $Center .= "</tr>\n";
    $Center .= "</table>\n";


    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml($Center);
    $main->setCentralPayload($oPatternCustom);
    $main->render();
}
?>
