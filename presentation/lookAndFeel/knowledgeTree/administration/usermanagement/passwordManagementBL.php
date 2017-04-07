<?php
/**
 * $Id: passwordManagementBL.php,v 1.3 2004/11/26 21:10:48 nbm Exp $
 *
 * Change a user's password
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
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package administration.usermanagement
 */
 
require_once("../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fForUpdate', 'fNewPassword', 'fNewPasswordConfirm', 'fUserID');

if (checkSession()) {	
	require_once("$default->fileSystemRoot/lib/security/Permission.inc");	
	require_once("$default->fileSystemRoot/lib/users/User.inc");
	require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");
	require_once("$default->fileSystemRoot/lib/visualpatterns/PatternCustom.inc");
	require_once("$default->fileSystemRoot/presentation/Html.inc");
	require_once("passwordManagementUI.inc");	
	
	$oPatternCustom = & new PatternCustom();
	
	if (strcmp($default->authenticationClass,"DBAuthenticator") == 0) {
		//only update passwords if we are in db authentication mode
		 if (isset($fUserID)){
		 	if (Permission::userIsSystemAdministrator()) {
		 		$oUser = User::get($fUserID);
		 		//only the administrator is allowed to change passwords here	 			
			 	if (isset($fForUpdate)) {
			 		//execute the update and return to the edit page??
			 		if (strlen($fNewPassword) > 0 && strlen($fNewPasswordConfirm) > 0) {
			 			//if passwords have been entered
			 			if (strcmp($fNewPassword, $fNewPasswordConfirm) == 0) {
			 				//if the password and its confirmation are the same		 				
			 				$oUser->setPassword($fNewPassword);
			 				if ($oUser->update()) {
			 					//successful update		 				
			 					$oPatternCustom->setHtml(getPasswordUpdateSuccessPage());
			 				} else {
			 					//update failed
			 					$oPatternCustom->setHtml(getPage($oUser->getName()));
			 					$main->setErrorMessage(_("An error occured while attempting to update the user's password"));
								$main->setFormAction($_SERVER["PHP_SELF"] . "?fForUpdate=1&fUserID=$fUserID");							
			 				}
			 			} else {
			 				$oPatternCustom->setHtml(getPage($oUser->getName()));
			 				$main->setErrorMessage(_("The password and its confirmation do not match.  Please try again."));
							$main->setFormAction($_SERVER["PHP_SELF"] . "?fForUpdate=1&fUserID=$fUserID");		 						 				
			 			} 
			 		} else {
			 			$oPatternCustom->setHtml(getPage($oUser->getName()));
		 				$main->setErrorMessage(_("Blank passwords are not valid.  Please try again."));
						$main->setFormAction($_SERVER["PHP_SELF"] . "?fForUpdate=1&fUserID=$fUserID");		 			
			 		}	 		
			 	} else {					
			 		//show the page
					$oPatternCustom->setHtml(getPage($oUser->getName()));
					$main->setFormAction($_SERVER["PHP_SELF"] . "?fForUpdate=1&fUserID=$fUserID");			
			 	}
			} else {
				$main->setErrorMessage(_("Only an administrator can update a user password from here"));
			}
		 }
	} else {
		$oPatternCustom->setHtml(getPage($oUser->getName()));
		$main->setErrorMessage(_("Passwords can only be update in Knowledgew Tree when authentication is against the MySQL database, not against an LDAP server"));
		$main->setFormAction($_SERVER["PHP_SELF"]);
	}	
	//render the page
	$main->setCentralPayload($oPatternCustom);
	$main->render();	
}
?>
