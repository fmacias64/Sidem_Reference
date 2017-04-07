<?php
/**
 * $Id: addLinkTypeSuccess.php,v 1.1 2005/06/13 21:31:40 nbm Exp $
 *
 * Add a document link type success page.
 *
 * Copyright (c) 2005 Jam Warehouse http://www.jamwarehouse.com
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
 * @version $Revision: 1.1 $
 * @author Neil Blakey-Milner, Jam Warehouse (Pty) Ltd, South Africa
 */

require_once("../../../../../config/dmsDefaults.php");

require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");

KTUtil::extractGPC('fLinkID');

if(checkSession()) {

    // include the page template (with navbar)
    $Center .= renderHeading(_("Add Link Type"));
    $Center .= "<TABLE BORDER=\"0\" CELLSPACING=\"2\" CELLPADDING=\"2\">\n";
    $Center .= "<tr>\n";
    if ($fLinkID != -1) {
        $Center .= "<td><b>" . _("New Link Type Added Successfully") . "!<b></td></tr>\n";
    } else {
        $Center .= "<td><b>" . _("Addition Unsuccessful") . "</b>...</td>\n";
        $Center .= "</tr>\n";
        $Center .= "<tr></tr>\n";
        $Center .= "<tr></tr>\n";
        $Center .= "<tr>\n";
        $Center .= "<td>Please Check Name and Rank for duplicates!</td>\n";
        $Center .= "</tr>\n";
        $Center .= "<tr>\n";
        $Center .="<td>&nbsp;</td>\n";
    }

    $Center .= "<tr></tr>\n";
    $Center .= "<tr></tr>\n";
    $Center .= "<tr></tr>\n";
    $Center .= "<tr></tr>\n";
    $Center .= "<tr>\n";
    $Center .= "<td align = right><a href=\"$default->rootUrl/control.php?action=addLinkType\"><img src=\"" . KTHtml::getBackButton() . "\" border = \"0\" /></a></td>\n";
    $Center .= "</tr>\n";
    $Center .= "</table>\n";

    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml($Center);
    $main->setCentralPayload($oPatternCustom);
    $main->render();
}
?>
