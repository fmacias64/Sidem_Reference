<?php
require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");
require_once("$default->fileSystemRoot/fecha.php");

/**
 * $Id: NavBar.inc,v 1.43 2005/01/27 10:18:57 nbm Exp $
 *
 * Contains all the functions to create the Navbar.
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
 * @version $Revision: 1.43 $
 * @author Mukhtar Dharsey, Jam Warehouse (Pty) Ltd, South Africa
 * @package lib.visualpatterns
 */
class NavBar {
    //variable used to pass highlighting
    var $home;
    var $mdocs;
    var $subscriptions;
    var $asearch;
    var $admin;
    var $prefs;
    var $help;
    var $logout;
    var $nwColourbar;
    var $sSection;

    /**  variables used for searching */
    var $sBrowseType;
    var $iFolderID;
    var $iDocumentID;
    var $sCategoryName;
    var $iDocTypeID;

    function NavBar($sTmpBrowseType, $iTmpFolderID, $iTmpDocumentID, $sTmpCategoryName, $iTmpDocTypeID) {
        global $default;

        $this->sBrowseType = $iTmpBrowseType;
        $this->iFolderID = $iTmpFolderID;
        $this->iDocumentID = $iTmpDocumentID;
        $this->sCategoryName = $sTmpCategoryName;
        $this->iDocTypeID = $iTmpDocTypeID;

        $this->mdocs = "$default->graphicsUrl/navbar/mdocs/norm.gif";
        $this->home = "$default->graphicsUrl/navbar/home/norm.gif";
        $this->subscriptions = "$default->graphicsUrl/navbar/subscriptions/norm.gif";
        $this->asearch = "$default->graphicsUrl/navbar/asearch/norm.gif";
        $this->admin = "$default->graphicsUrl/navbar/admin/norm.gif";
        $this->prefs = "$default->graphicsUrl/navbar/prefs/norm.gif";
        $this->help = "$default->graphicsUrl/navbar/help/norm.gif";
        $this->logout = "$default->graphicsUrl/navbar/logout/norm.gif";

        $this->mdocsClass = "dash";
        $this->homeClass = "dash";
        $this->subscriptionsClass = "dash";
        $this->asearchClass = "dash";
        $this->adminClass = "dash";
        $this->prefsClass = "dash";
        $this->helpClass = "dash";
        $this->logoutClass = "dash";
    }

    /**
     * gets the url for the colour bar
     *
     * @param The section that needs to be highlighted
     */
    function getNWColourbar() {
        return $this->nwColourBar;
    }

    /**
     * sets a highlighted section varaibles
     *
     * @param The section that needs to be highlighted
     */
    function setHighlightedSection($section) {
        global $default;
        $this->sSection = $section;

        // check for highlighting..and highlight as required
        if($section == "General") {
            $this->home = "$default->graphicsUrl/navbar/home/over.gif";
            $this->nwColourBar = "$default->graphicsUrl/navbar/home/def.gif";
            $this->homeClass = "dashactive";
        }

        if(($section == "Manage Documents") || ($section == "Manage Categories") || ($section == "Manage Document Types")) {
            $this->mdocs = "$default->graphicsUrl/navbar/mdocs/over.gif";
            $this->nwColourBar = "$default->graphicsUrl/navbar/mdocs/def.gif";
            $this->mdocsClass = "dashactive";
        }
		if($section == "Discussion Threads" )  {
            $this->mdocs = "$default->graphicsUrl/navbar/mdocs/over.gif";
            $this->nwColourBar = "$default->graphicsUrl/navbar/mdocs/def.gif";
            $this->mdocsClass = "dashactive";
        }

        if($section == "Subscriptions") {
            $this->subscriptions = "$default->graphicsUrl/navbar/subscriptions/over.gif";
            $this->nwColourBar = "$default->graphicsUrl/navbar/subscriptions/def.gif";
            $this->subscriptionsClass = "dashactive";
        }

        if(($section == "Standard Search") || ($section == "Advanced Search")) {
            $this->asearch = "$default->graphicsUrl/navbar/asearch/over.gif";
            $this->nwColourBar = "$default->graphicsUrl/navbar/asearch/def.gif";
            $this->asearchClass = "dashactive";
        }

        if(substr($section, -14) == "Administration") {
            $this->admin = "$default->graphicsUrl/navbar/admin/over.gif";
            $this->nwColourBar = "$default->graphicsUrl/navbar/admin/def.gif";
            $this->adminClass = "dashactive";
        }

        if($section == "Preferences") {
            $this->prefs = "$default->graphicsUrl/navbar/prefs/over.gif";
            $this->nwColourBar = "$default->graphicsUrl/navbar/prefs/def.gif";
            $this->prefsClass = "dashactive";
        }

        if($section == "Help") {
            $this->help = "$default->graphicsUrl/navbar/help/over.gif";
            $this->nwColourBar = "$default->graphicsUrl/navbar/help/def.gif";
            $this->helpClass = "dashactive";
        }

        if($section == "Logout") {
            $this->logout = "$default->graphicsUrl/navbar/logout/over.gif";
            $this->nwColourBar = "$default->graphicsUrl/navbar/logout/def.gif";
            $this->logoutClass = "dashactive";
        }
    }

    /**
     * this function creates the navbar for a specific page...
     */
    function render() {
        global $default;

        //set up headings for row 1 and 2
        $heading = "$default->graphicsUrl/heading.gif";
        $hStretched = "$default->graphicsUrl/hrepeat.gif";

        // set colour pics for row 4 of navbar
        $colourHome = "$default->graphicsUrl/navbar/home/colour.gif";
        $colourmdocs = "$default->graphicsUrl/navbar/mdocs/colour.gif";
        $coloursubscriptions = "$default->graphicsUrl/navbar/subscriptions/colour.gif";
        $colourasearch = "$default->graphicsUrl/navbar/asearch/colour.gif";
        $colouradmin = "$default->graphicsUrl/navbar/admin/colour.gif";
        $colourprefs = "$default->graphicsUrl/navbar/prefs/colour.gif";
        $colourhelp = "$default->graphicsUrl/navbar/help/colour.gif";
        $colourlogout = "$default->graphicsUrl/navbar/logout/colour.gif";

        // get list of sections
        $aTopMenuLinks = array(generateControllerUrl("dashboard"),
                               generateControllerUrl($default->siteMap->getDefaultAction("Manage Documents")),
                               generateControllerUrl($default->siteMap->getDefaultAction("Subscriptions")),
                               generateControllerUrl($default->siteMap->getDefaultAction("Advanced Search")),
                               generateControllerUrl($default->siteMap->getDefaultAction("Administration")),
                               generateControllerUrl($default->siteMap->getDefaultAction("Preferences")),
                               "help",
                               generateControllerUrl($default->siteMap->getDefaultAction("Logout")));

        // create array of images for navbar sections
        $aTopMenuImages = array($this->home,
                                $this->mdocs,
                                $this->subscriptions,
                                $this->asearch,
                                $this->admin,
                                $this->prefs,
                                $this->help,
                                $this->logout);

        $aTopMenuClasses = array($this->homeClass,
                                $this->mdocsClass,
                                $this->subscriptionsClass,
                                $this->asearchClass,
                                $this->adminClass,
                                $this->prefsClass,
                                $this->helpClass,
                                $this->logoutClass);

        $aTopMenuWords = array(
            _("Dashboard"),
            _("Browse Collections"),
            _("Subscriptions"),
            _("Advanced Search"),
            _("Admin"),
            _("Preferences"),
            _("Help"),
            _("Logout"),
        );

        $aTopMenuColourClass = array(
            "dashboard",
            "browse",
            "subscriptions",
            "asearch",
            "admin",
            "prefs",
            "help",
            "logout",
        );

        // create array of menu colour images
        $aColourMenuImages = array($colourHome,$colourmdocs,$coloursubscriptions,$colourasearch,$colouradmin,$colourprefs,$colourhelp,$colourlogout);

        if ($default->useTextButtons === false) {
            //set up the links
            for ($i = 0; $i < count($aTopMenuLinks); $i++) {
                if (strcmp($aTopMenuLinks[$i], "help") == 0) {
                    $sTopMenu .= "<td width=\"10\"><a href=\"#\" onClick=\"javascript:helpWindow();\"><img src=\"" . $aTopMenuImages[$i] . "\" border=\"0\" /></a></td>\n";
                    $sColourMenu .= "<td width=\"10\"><a href=\"#\" onClick=\"javascript:helpWindow();\"><img src=\"" . $aColourMenuImages[$i] . "\" border=\"0\" /></a></td>\n";
                } else {
                    $sTopMenu .= "<td width=\"10\">" . (strlen($aTopMenuLinks[$i]) > 0 ? "<a href=\"" . $aTopMenuLinks[$i] . "\">" : "") . "<img src=\"" . $aTopMenuImages[$i] . "\" border=\"0\" /></a></td>\n";
                    $sColourMenu .= "<td width=\"10\">" . (strlen($aTopMenuLinks[$i]) > 0 ? "<a href=\"" . $aTopMenuLinks[$i] . "\">" : "") . "<img src=\"" . $aColourMenuImages[$i] . "\" border=\"0\"/></a></td>\n";
                }
            }
        } else {
            for ($i = 0; $i < count($aTopMenuLinks); $i++) {
                if (strcmp($aTopMenuLinks[$i], "help") == 0) {
                    $sTopMenu .= "<td valign=\"top\"><a href=\"#\" onClick=\"javascript:helpWindow();\"><span class=\"" . $aTopMenuClasses[$i] . "\">" . strtoupper($aTopMenuWords[$i]) . "</span></a></td>\n";
                    $sColourMenu .= "<td valign=\"top\" class=\"colour_" . $aTopMenuColourClass[$i] . "\"><a href=\"#\" onClick=\"javascript:helpWindow();\"><span>&nbsp;</span></a></td>\n";
                } else {
                    $sTopMenu .= "<td valign=\"top\">" . (strlen($aTopMenuLinks[$i]) > 0 ? "<a href=\"" . $aTopMenuLinks[$i] . "\">" : "") . "<span class=\"" . $aTopMenuClasses[$i] . "\">" . strtoupper($aTopMenuWords[$i]) . "</span></a></td>\n";
                    $sColourMenu .= "<td valign=\"top\" class=\"colour_" . $aTopMenuColourClass[$i] . "\">" . (strlen($aTopMenuLinks[$i]) > 0 ? "<a href=\"" . $aTopMenuLinks[$i] . "\">" : "") . "<span>&nbsp;</span></a></td>\n";
                }
            }
        }

        $toRender = new PatternCustom;
/**
        // build the nav bar
        $bar  = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"608\">\n";
        $bar .= "\t<tr height=\"30\">\n";
              $bar .= "\t\t<td valign=\"top\" width=\"100%\" colspan=\"2\" bgcolor=\"#1A4383\"><img src=\"$heading\"/><img src=\"$default->graphicsUrl/logo.jpg\" width=\"30\" height=\"36\" style=\"border-right:3px solid white;\"/></td>\n";        
        $bar .= "\t</tr>\n";
        $bar .= "\t<tr height=\"30\">\n";
        $bar .= "\t\t<td colspan=\"2\" bgcolor=\"#1A4383\" width=\"100%\">";
        $bar .= "<img align=\"absmiddle\" src=\"$default->graphicsUrl/arrow.gif\" ></img>\n";

        $bar .= "<INPUT type=\"hidden\" name=\"fForStandardSearch\" value=\"no\" />\n ";
        //disable the search bar if we are browsing search results
        if ((strcmp($this->sSection,"Standard Search") == 0) || (strcmp($this->sSection,"Advanced Search") == 0)) {
            $bar .= "<INPUT type=\"hidden\" name=\"fSearchText\"/>\n ";
        } else {
            $bar .= "<INPUT type=\"text\" name=\"fSearchText\" width=\"30\" height = \"10\" onKeyPress=\"return checkKeyPressed(event, validateStandardSearch, '" . $default->rootUrl . "/control.php')\"/>\n";
            (isset($this->iFolderID) ? $bar .= "<INPUT type=\"hidden\" name=\"fFolderID\" value=\"" . $this->iFolderID . "\"  />\n " : $bar .= "");
            (isset($this->iDocumentID) ? $bar .= "<INPUT type=\"hidden\" name=\"fDocumentID\" value=\"" . $this->iDocumentID . "\"  />\n " : $bar .= "");
            (isset($this->sCategoryName) ? $bar .= "<INPUT type=\"hidden\" name=\"fCategoryName\" value=\"" . $this->sCategoryName . "\"  />\n " : $bar .= "");
            (isset($this->iDocTypeID) ? $bar .= "<INPUT type=\"hidden\" name=\"fDocTypeID\" value=\"" . $this->iDocTypeID . "\"  />\n " : $bar .= "");
            //this next line works in IE, and Netscape 4.79 up, but NOT Netscape 4.79
            //$bar .= "<INPUT type=\"image\" onClick=\"return validateStandardSearch('" . $default->rootUrl . "/control.php')\" src=\"$default->graphicsUrl/search.gif\" align = \"absmiddle\" border=\"0\" />\n";
            //replaced with this line            
            $bar .= "<a href=\"#\" onClick=\"return validateStandardSearch('" . $default->rootUrl . "/control.php')\"><img align=\"absmiddle\" src=\"$default->graphicsUrl/search.gif\" border=\"0\" /></a>";
            
        }
	      $bar .= "\t\t</td>\n";
        $bar .= "\t</tr>\n";
        // $bar .= "<tr height=30><td ><table cellspacing=0 cellpadding=0 border=0><tr>$sTopMenu</tr>\n"; 
        $bar .= "<tr><td><table cellspacing=0 cellpadding=0 border=0><tr>$sTopMenu</tr>\n";
        $bar .= "<tr>$sColourMenu</tr></table></td></tr>\n";
        $bar .= "</table>\n";

        //set the bar as html to object
        $toRender->setHtml($bar);


 */

	// ************ NUEVO MENU HECHO EN FLASH *****************//
	//======== menu creado para admin ===========>>
/**
if ($_SESSION["userID"]==1){

$toRender = new PatternCustom;

 $bar.= "<center><img src=\"$default->graphicsUrl/top.gif\" border=\"0\" height='120' width='560'/></center>";
$bar.="<div align=right>";
$bar.=fecha();
$bar.="</div>";
 $bar.="<hr>";
$bar.="<center>";
$bar.= "<div id=\"changecolor-round-parallelogram_id1\" onload=\"AdjustMenu('changecolor-round-parallelogram1','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram1','false',0,0)\"> >123 Flash Menu Placeholder. </div>";
$bar.="<script type=\"text/javascript\">";
$bar.="var fo = new FlashObject(\"$default->graphicsUrl/navbarnvo.swf\",\"changecolor-round-parallelogram1\",\"560\",\"22\",\"6\",\"#FFFFFF\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram_id1\");
document.getElementById('changecolor-round-parallelogram1').style.width=\"560px\";
//document.getElementById('changecolor-round-parallelogram1').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram1').style.zIndex=\"10\"";
$bar.="</script>";
$bar.="</center>";
 $bar.="<hr>";

 $bar .= "<INPUT type=\"hidden\" name=\"fForStandardSearch\" value=\"no\" />\n ";
        //disable the search bar if we are browsing search results
        if ((strcmp($this->sSection,"Standard Search") == 0) || (strcmp($this->sSection,"Advanced Search") == 0)) {
            $bar .= "<INPUT type=\"hidden\" name=\"fSearchText\"/>\n ";
        } else {
	  // $bar .= "<INPUT type=\"text\" name=\"fSearchText\" width=\"30\" height = \"10\" onKeyPress=\"return checkKeyPressed(event, validateStandardSearch, '" . $default->rootUrl . "/control.php')\"/>\n";
            (isset($this->iFolderID) ? $bar .= "<INPUT type=\"hidden\" name=\"fFolderID\" value=\"" . $this->iFolderID . "\"  />\n " : $bar .= "");
            (isset($this->iDocumentID) ? $bar .= "<INPUT type=\"hidden\" name=\"fDocumentID\" value=\"" . $this->iDocumentID . "\"  />\n " : $bar .= "");
            (isset($this->sCategoryName) ? $bar .= "<INPUT type=\"hidden\" name=\"fCategoryName\" value=\"" . $this->sCategoryName . "\"  />\n " : $bar .= "");
            (isset($this->iDocTypeID) ? $bar .= "<INPUT type=\"hidden\" name=\"fDocTypeID\" value=\"" . $this->iDocTypeID . "\"  />\n " : $bar .= "");
            //this next line works in IE, and Netscape 4.79 up, but NOT Netscape 4.79
            //$bar .= "<INPUT type=\"image\" onClick=\"return validateStandardSearch('" . $default->rootUrl . "/control.php')\" src=\"$default->graphicsUrl/search.gif\" align = \"absmiddle\" border=\"0\" />\n";
            //replaced with this line            
	    // $bar .= "<a href=\"#\" onClick=\"return validateStandardSearch('" . $default->rootUrl . "/control.php')\"><img align=\"absmiddle\" src=\"$default->graphicsUrl/search.gif\" border=\"0\" /></a>";
            
	}
}
*/
//============= menu creado para ususario ===========>>
/**
else{
$toRender = new PatternCustom;

 $bar.= "<center><img src=\"$default->graphicsUrl/top.gif\" border=\"0\" height='140' width='600'/></center>";
$bar.="<div align=right>";
$bar.=fecha();
$bar.="</div>";
 $bar.="<hr>";
$bar.="<center>";
$bar  .= " <div id=\"changecolor-round-parallelogram2\" onload=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" onresize=\"AdjustMenu('changecolor-round-parallelogram2','false',0,0)\" >123 Flash Menu Placeholder.</div>";
$bar .= "<script type=\"text/javascript\">";
$bar .= "var fo = new FlashObject(\"$default->graphicsUrl/navbarusuario.swf\",\"changecolor-round-parallelogram2\",\"400\",\"22\",\"6\",\"#FFFFFF\");
    fo.addParam(\"menu\",\"false\");
    fo.addParam(\"quality\",\"best\");
    fo.addParam(\"scale\",\"noscale\");
    fo.addParam(\"salign\",\"LT\");
    fo.addParam(\"wmode\", \"transparent\");
    fo.write(\"changecolor-round-parallelogram2\");
document.getElementById('changecolor-round-parallelogram2').style.width=\"400px\";
//document.getElementById('changecolor-round-parallelogram2').style.position=\"absolute\";
document.getElementById('changecolor-round-parallelogram2').style.zIndex=\"10\"";
$bar .= "</script>";
$bar.="</center>";
 $bar.="<hr>";
}
 $bar .= "<INPUT type=\"hidden\" name=\"fForStandardSearch\" value=\"no\" />\n ";
        //disable the search bar if we are browsing search results
        if ((strcmp($this->sSection,"Standard Search") == 0) || (strcmp($this->sSection,"Advanced Search") == 0)) {
            $bar .= "<INPUT type=\"hidden\" name=\"fSearchText\"/>\n ";
        } else {
	  // $bar .= "<INPUT type=\"text\" name=\"fSearchText\" width=\"30\" height = \"10\" onKeyPress=\"return checkKeyPressed(event, validateStandardSearch, '" . $default->rootUrl . "/control.php')\"/>\n";
            (isset($this->iFolderID) ? $bar .= "<INPUT type=\"hidden\" name=\"fFolderID\" value=\"" . $this->iFolderID . "\"  />\n " : $bar .= "");
            (isset($this->iDocumentID) ? $bar .= "<INPUT type=\"hidden\" name=\"fDocumentID\" value=\"" . $this->iDocumentID . "\"  />\n " : $bar .= "");
            (isset($this->sCategoryName) ? $bar .= "<INPUT type=\"hidden\" name=\"fCategoryName\" value=\"" . $this->sCategoryName . "\"  />\n " : $bar .= "");
            (isset($this->iDocTypeID) ? $bar .= "<INPUT type=\"hidden\" name=\"fDocTypeID\" value=\"" . $this->iDocTypeID . "\"  />\n " : $bar .= "");
            //this next line works in IE, and Netscape 4.79 up, but NOT Netscape 4.79
            //$bar .= "<INPUT type=\"image\" onClick=\"return validateStandardSearch('" . $default->rootUrl . "/control.php')\" src=\"$default->graphicsUrl/search.gif\" align = \"absmiddle\" border=\"0\" />\n";
            //replaced with this line            
	    // $bar .= "<a href=\"#\" onClick=\"return validateStandardSearch('" . $default->rootUrl . "/control.php')\"><img align=\"absmiddle\" src=\"$default->graphicsUrl/search.gif\" border=\"0\" /></a>";
            
	}

//=============================<<<<< Termina menu creado para usuario <<<===============


 $toRender->setHtml($bar);

*/




                     /**aaaaaaaaaaaaaaaaaaaaaaaaaaaa  */




        //render the object
        return $this->getSearchValidationJavaScript() . $toRender->render();

    }

    function getSearchValidationJavaScript() {
        $sToRender = "\n\n<SCRIPT LANGUAGE=\"javascript\">\n ";
        $sToRender .= "<!--\n";

        $sToRender .= '
// From http://www.severnsolutions.co.uk/twblog/archive/2003/09/14/keypressevents
function checkKeyPressed(evt, func, params)
{
  evt = (evt) ? evt : (window.event) ? event : null;
  if (evt)
  {
    var charCode = (evt.charCode) ? evt.charCode :
                   ((evt.keyCode) ? evt.keyCode :
                   ((evt.which) ? evt.which : 0));
    if (charCode == 13) return func(params);
  }
  return true;
}';

        $sToRender .= "function validateStandardSearch(newAction) {\n";        
        $sToRender .= "\tif (!(validRequired(document.MainForm.fSearchText, 'Search text'))) {\n";
        $sToRender .= "\t\treturn false;\n\t}\n";
        $sToRender .= "\telse {\n";
        $sToRender .= "\t\tsetActionAndSubmitSearch(newAction);\n";        
        $sToRender .= "\t}\n";
        $sToRender .= "}\n";
        $sToRender .= "//-->\n";
        $sToRender .= "</SCRIPT>\n\n";
        return $sToRender;
    }
}
?>
