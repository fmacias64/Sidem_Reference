<?php
/**
 * $Id: PhysicalDocumentManager.inc,v 1.38 2005/06/09 21:02:47 nbm Exp $
 *
 * Contains all functions required to upload, alter and
 * delete a physical document.
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
 * @version $Revision: 1.38 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package lib.documentmanagement 
 */

// used for well-known MIME deterministic techniques
if (!extension_loaded('fileinfo')) {
    @dl('fileinfo.' . PHP_SHLIB_SUFFIX);
}

	/****
Funcion creadora de mapa individuo
	 **/
	function yeah(){echo "yeah";}
	////////////////////

function findividuo($ppath,$oDocument,$que,$docllama ) {
  global $default;
 $gestor = fopen($ppath, $que);

$iddoc= $docllama;
$oDocument = & Document::get($iddoc);
$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$iddoc;
$indv_rel1 = mysql_query($indv_rel);


 while($indv_rel2 = mysql_fetch_row($indv_rel1))
{
$bandtipo=1;
 

 
 if ($indv_rel2[2]==8) {
    $nam=$indv_rel2[3];
    $bandtipo=0;
}
 if ($indv_rel2[2]==21 ){
   $appat=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==22){
   $apmat=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==23 ){
    $fech=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==58 ){
    $mail=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==96 ){
    $resum=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==57 ){
    $tel=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==63 ){
    $rel1=$indv_rel2[3];
$bandtipo=0;
}

if ($indv_rel2[2]==64 ){
    $rel2=$indv_rel2[3];
$bandtipo=0;
}

if ($indv_rel2[2]==65 ){
    $rel3=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==69 ){
    $gen=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==54 ){
    $cit=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==100 ){
    $cit1=$indv_rel2[3];
$bandtipo=0;
}
if ($indv_rel2[2]==101 ){
    $cit2=$indv_rel2[3];
$bandtipo=0;
}
}

 
 $docs= "img/".$oDocument->getFileName();
   
  $tama=filesize($docs);

$genero0= "SELECT value FROM `document_fields_link` WHERE `document_field_id`=69  AND `document_id`=".$iddoc;
$genero1 = mysql_query($genero0);
$genero2 = mysql_fetch_row($genero1);

//$Nom = "http://proveedores.intelect.com.mx/FichasBD/branches/Sidem/Documents/Root%20Folder/Default%20Unit/SIDEM/Individuo/".$oDocument->getFileName();

 $Nom = " http://proveedores.intelect.com.mx/FichasBD/branches/Sidem/Documents". $oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName();

           fwrite($gestor, '<map version="0.8.1" >');
fwrite($gestor, "\n");
 fwrite($gestor, '<!-- To view this file, download free mind mapping software FreeMind from http://freemind.sourceforge.net --> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274726484516" ID="Freemind_Link_1266442485" MODIFIED="1274726484516" TEXT="'.$nam.'&nbsp; '.$appat.'&nbsp; '.$apmat.'"> ');
fwrite($gestor, "\n");

//=============>> INSERTAR IMAGEN INDIVIDUO =========>>>>
 if ($tama >= 10){

fwrite($gestor, '<node CREATED="1274726560189" ID="Freemind_Link_1279689037" MODIFIED="1274731872010" POSITION="left" TEXT="&lt;html&gt;&lt;img src=&quot;'.$Nom.'&quot;&gt; "/> ');
 }
 else
if ($genero2[0]=="Femenino")
{
fwrite($gestor, '<node CREATED="1274726560189" ID="Freemind_Link_1279689037" MODIFIED="1274731872010" POSITION="left" TEXT="&lt;html&gt;&lt;img src=&quot;http://proveedores.intelect.com.mx/FichasBD/branches/Sidem/presentation/lookAndFeel/knowledgeTree/documentmanagement/nofotof.jpg&quot;&gt; "/> ');
 }
 else
   {
fwrite($gestor, '<node CREATED="1274726560189" ID="Freemind_Link_1279689037" MODIFIED="1274731872010" POSITION="left" TEXT="&lt;html&gt;&lt;img src=&quot;http://proveedores.intelect.com.mx/FichasBD/branches/Sidem/Documents/Root Folder/Default Unit/SIDEM/Individuo/nofoto.jpg&quot;&gt; "/> ');
}

//fwrite($gestor, '<node CREATED="1274726560189" ID="Freemind_Link_1279689037" MODIFIED="1274731872010" POSITION="left" TEXT="&lt;html&gt;&lt;img src=&quot;http://www.arrolladoscaseros.com.ar/v1/images/16.jpg&quot;&gt; "/> ');

//"http://proveedores.intelect.com.mx/FichasBD/branches/Sidem/Documents". $oDocument->generateFullFolderPath($oDocument->getFolderID())."/".$oDocument->getFileName()
//========================<<<< TERMINA INSERTAR IMAGEN <<<=================
fwrite($gestor, "\n");

 fwrite($gestor, '<node CREATED="1274726544449" ID="_" MODIFIED="1274726552543" POSITION="left" TEXT="Datos Personales"> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274727244482" ID="Freemind_Link_1898276060" MODIFIED="1274727255598" TEXT="Fecha de Nacimiento: '.$fech.'"/> ');
 fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274727259629" ID="Freemind_Link_1365853795" MODIFIED="1274727274490" TEXT="Nacionalidad: '.$cit.'"> ');

fwrite($gestor, "\n");

 fwrite($gestor, '<node CREATED="1274731484668" ID="Freemind_Link_143094117" MODIFIED="1274731493223" TEXT="Nacionalidad 1: '.$cit1.'"/> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274731499027" ID="Freemind_Link_231161259" MODIFIED="1274731504715" TEXT="Nacionalidad 2: '.$cit2.'"/> ');
fwrite($gestor, "\n");
 fwrite($gestor, '</node> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274727277041" ID="Freemind_Link_523770694" MODIFIED="1274727284185" TEXT="Tel&#xe9;fono: '.$tel.'"/> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274727286487" ID="Freemind_Link_1871153717" MODIFIED="1274727292060" TEXT="E-mail: '.$mail.'"/> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274727293821" ID="Freemind_Link_835127681" MODIFIED="1274727298847" TEXT="Genero: '.$gen.'"/> ');
fwrite($gestor, "\n");
 $resum=str_replace('"', "''", $resum);
 $resumen_html=utf8_encode($resum);
 fwrite($gestor, '<node CREATED="1274727301428" FOLDED="true" ID="Freemind_Link_63763403" MODIFIED="1274727311168" TEXT="Resumen Ejecutivo: "> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274727320886" ID="Freemind_Link_1164883218" MODIFIED="1274727325890" TEXT="'.$resumen_html.'"/> ');
fwrite($gestor, "\n");
 fwrite($gestor, '</node> ');
fwrite($gestor, "\n");
 fwrite($gestor, '</node> ');
fwrite($gestor, "\n");
//----------------------------
// id doc tipo 18 (individuo), del nodo anterior , el tipo 4 (trayectoria), el id del mapa, y el numero random
 $numrr=rand(100000,200000);
 $nom_mapa=explode("/",$ppath);
 $posNombre=count($nom_mapa)-1;
 
 
 $nombre_nodo="NTRAY_".$iddoc."_4_".$nom_mapa[$posNombre].$numrr;
$enlace= "http://".$default->serverName.$default->rootUrl."/control.php?action=modifymindmap&idd=".$iddoc."&tipo= 4&numinstr=1&elmapa=".$nom_mapa[$posNombre]."&idnodo=".$nombre_nodo;
//fwrite($gestor, '<!---'.print_r($nom_mapa,true)." ### ".count($nom_mapa).'--> ');
fwrite($gestor, '<node CREATED="1274726578281" ID="'.$nombre_nodo.'" LINK="'.$enlace.'" MODIFIED="1274731944034" POSITION="right" TEXT="&lt;html&gt;&lt;a href=&quot;#&quot;&gt;Trayectoria &lt;/a&gt;"/> ');
fwrite($gestor, "\n");

$nombre_nodo="NREL_".$iddoc."_20_".$nom_mapa[$posNombre].$numrr;
$enlace= "http://".$default->serverName.$default->rootUrl."/control.php?action=modifymindmap&idd=".$iddoc."&tipo=20&numinstr=5&elmapa=".$nom_mapa[$posNombre]."&idnodo=".$nombre_nodo;



 fwrite($gestor, '<node CREATED="1274726656461" ID="'.$nombre_nodo.'" LINK="'.$enlace.'" MODIFIED="1274731740381" POSITION="right" TEXT="Relaciones"/> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274726769137" ID="Freemind_Link_316879233" LINK="http://www.google.com/" MODIFIED="1274731788162" POSITION="right" TEXT="Domicilios"/> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274726805198" ID="Freemind_Link_1876460424" LINK="http://www.google.com/" MODIFIED="1274731802458" POSITION="right" TEXT="Eventos"/> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274726819714" ID="Freemind_Link_1766366765" LINK="http://www.google.com/" MODIFIED="1274731812289" POSITION="right" TEXT="Preferencias"/> ');
fwrite($gestor, "\n");
 fwrite($gestor, '<node CREATED="1274727040921" ID="Freemind_Link_878549994" LINK="http://www.google.com/" MODIFIED="1274731829310" POSITION="right" TEXT="Multimedia"/> ');
fwrite($gestor, "\n");
 fwrite($gestor, '</node> ');
fwrite($gestor, "\n");
 fwrite($gestor, '</map> ');


           fclose($gestor);
	   return true;
}

class PhysicalDocumentManager {
	
	/**
	* Upload and store a new document
	*	
	* @param 	The document object being uploaded
	* @param 	Primary key of folder in which document will be stored
	* @param 	Document description (should be passed through as a form variable)
	* @param	Temporary path of file on server (get from $aFileArray['fFile']['tmp_name'])
	*
	* @return boolean true on successful upload and storage, false otherwise and set $_SESSION["errorMessage"]
	*
	* @todo add URL functionality
	*/
	function uploadPhysicalDocument($oDocument, $iFolderID, $sDescription, $sTmpFilePath) {
		global $lang_fileexists, $lang_err_upload, $lang_err_database;				
		//find the path on the system where the document should be stored
        $sDocumentFileSystemPath = $oDocument->getPath();
		//$dbg="update debugg set uno =" .'"'."ARCH  ".$sTmpFilePath.'"'."where llave=1";
		//$r2 = mysql_query($dbg); 
		//copy the file accross
		if (copy($sTmpFilePath, $sDocumentFileSystemPath)) {						
			//remove the temporary file
			unlink($sTmpFilePath);
			if (file_exists($sDocumentFileSystemPath)) {
				return true;
			} else {
				return false;
			}		
		} else {
			$_SESSION["errorMessage"] = $lang_err_upload;
			return false;
		}
	}

// udf    



	function uploadPhysicalDocument_felipe($oDocument, $iFolderID, $sDescription, $sTmpFilePath,$docllama) {
		global $lang_fileexists, $lang_err_upload, $lang_err_database;				
		//find the path on the system where the document should be stored
        $sDocumentFileSystemPath = $oDocument->getPath();
	$raizArchivos="/home/graciela/public_html/";
		
		//copy the file accross
	if($oDocument->getDocumentTypeID()==52){
	 
	  findividuo($sDocumentFileSystemPath,$oDocument,"w",$docllama);
         
	   if (file_exists($sDocumentFileSystemPath)) {
				return true;
			} else {
				return false;
	   }		
	
	} else if (touch( $sDocumentFileSystemPath)) {						
			//remove the temporary file
			//unlink($sTmpFilePath);
			if (file_exists($sDocumentFileSystemPath)) {
				return true;
			} else {
				return false;
			}		
		} else {
			$_SESSION["errorMessage"] = $lang_err_upload;
			return false;
		}
	}
    



    /**
     * Renames a document on the filesystem
     *
     * @param object the document to rename
     * @param string the new document filename
     * @return true on success, false on failure
     */
    function renamePhysicalDocument($oDocument, $sNewFileName) {
        global $default;
      
        // create new and old paths
        $sDocumentFileSystemPath = $oDocument->getPath();
        $sNewDocumentFileSystemPath = Folder::getFolderPath($oDocument->getFolderID()) . "/" . $sNewFileName;
        $default->log->debug("renaming $sDocumentFileSystemPath to $sNewDocumentFileSystemPath");
        // move it
        return rename($sDocumentFileSystemPath, $sNewDocumentFileSystemPath);
    }
    
	/**
	* Stream a document to a client over http
	*
	* @param 	Primary key of document to stream
	*
	* @return int number of bytes read from file on success or false otherwise;
	*
	* @todo investigate possible problem in MSIE 5.5 concerning Content-Disposition header
	*/
	function downloadPhysicalDocument($iDocumentID) {
            //get the document
            $oDocument = & Document::get($iDocumentID);
            //get the path to the document on the server
            $sDocumentFileSystemPath = $oDocument->getPath();
            if (file_exists($sDocumentFileSystemPath)) {
                //set the correct headers
                header("Content-Type: " .
                        PhysicalDocumentManager::getMimeTypeName($oDocument->getMimeTypeID()));
                header("Content-Length: ". $oDocument->getFileSize());
                header("Content-Disposition: attachment; filename=\"" . $oDocument->getFileName() . "\"");
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header("Cache-Control: must-revalidate");
                header("Content-Location: ".$oDocument->getFileName());

                readfile($sDocumentFileSystemPath);
            } else {
        	return false;
            }
	}
    
    /**
	 * Stream a particular version of a document to a client over http
	 *
	 * @param 	Primary key of document to stream
	 * @param 	Primary key of document to stream
	 * @return int number of bytes read from file on success or false otherwise;
 	 */
	function downloadVersionedPhysicalDocument($iDocumentID, $sVersion) {
            //get the document
            $oDocument = & Document::get($iDocumentID);
            //get the path to the document on the server
            $sDocumentFileSystemPath = $oDocument->getPath() . "-$sVersion";
            if (file_exists($sDocumentFileSystemPath)) {
                //set the correct headers
                header("Content-Type: " .
                        PhysicalDocumentManager::getMimeTypeName($oDocument->getMimeTypeID()));
                header("Content-Length: ".  filesize($sDocumentFileSystemPath));
                // prefix the filename presented to the browser to preserve the document extension
                header('Content-Disposition: attachment; filename="' . "$sVersion-" . $oDocument->getFileName() . '"');
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header("Cache-Control: must-revalidate");
                header("Content-Location: ".$oDocument->getFileName());
                readfile($sDocumentFileSystemPath);
            } else {
                return false;
            }
        }
    
	/**
 	 * Move a document to a new folder
	 *
	 * return boolean true on successful move, false otherwhise
	 */
	function moveDocument($sOldDocumentPath, $oDocument, $oFolder) {
		global $default;
		
		// current document path
		$sCurrentPath = $sOldDocumentPath;
		
		// the destination path
		$sDestinationFolderPath = Folder::getFolderPath($oFolder->getID()) . $oDocument->getFileName();

		// find all the previous versions of this document and move them
		// ie. interrogate transaction history for all CHECKIN transactions and retrieve the versions
		// FIXME: refactor array getOldVersionPaths($iDocumentID)??
		
		$sql = $default->db;
        $sQuery = "SELECT DISTINCT version FROM $default->document_transactions_table WHERE document_id = ? AND transaction_id = ?";/*ok*/
        $aParams = array($oDocument->getID(), CHECKOUT);
		$result = $sql->query(array($sQuery, $aParams));
        if ($result) {
            while ($sql->next_record()) {
            	$sVersion = $sql->f("version");
            	if ($sVersion <> $oDocument->getVersion()) {
					$sSourcePath = $sCurrentPath . "-" . $sVersion;
					$sDestinationPath = $sDestinationFolderPath . "-" . $sVersion;
					// move it to the new folder
					$default->log->info("PhysicalDocumentManager::moveDocument moving $sSourcePath to $sDestinationPath");
					if (!PhysicalDocumentManager::move($sSourcePath, $sDestinationPath)) {
						// FIXME: can't bail now since we don't have transactions- so we doggedly continue deleting and logging errors					
						$default->log->error("PhysicalDocumentManager::moveDocument error moving $sSourcePath to $sDestinationPath; documentID=" . $oDocument->getID() . "; folderID=" . $oFolder->getID());
					}
            	}
            }
        } else {
        	$default->log->error("PhysicalDocumentManager::moveDocument error looking up document versions, id=" . $oDocument->getID());
        }	

		// now move the current version		
		if (PhysicalDocumentManager::move($sCurrentPath, $sDestinationFolderPath)) {
			return true;
		} else {
			$default->log->error("PhysicalDocumentManager::moveDocument couldn't move $sCurrentPath to $sDestinationFolderPath, documentID=" . $oDocument->getID());
			return false;
		}
	}
	

	/**
	 * Move a file
	 *
	 * @param string source path
	 * @param string destination path
	 */
	function move($sOldDocumentPath, $sNewDocumentPath) {
		global $default;
		if (file_exists($sOldDocumentPath)) {
			//copy the file	to the new destination
			if (copy($sOldDocumentPath, $sNewDocumentPath)) {
				//delete the old one
				unlink($sOldDocumentPath);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}		
	}
	
	
	/**
	 * Deletes a document- moves it to the Deleted/ folder
	 *
	 * return boolean true on successful move, false otherwhise
	 */
	function delete($oDocument) {
		global $default;
		// current document path
		$sCurrentPath = $oDocument->getPath();
		
		// check if the deleted folder exists and create it if not
		$sDeletedPrefix = $default->documentRoot . "/Deleted";
		if (!file_exists($sDeletedPrefix)) {
            mkdir($sDeletedPrefix, 0755);
        }
		
		// move the file to the deleted folder, prefixed by its document id
		$sDeletedPrefix = $default->documentRoot . "/Deleted/" . $oDocument->getID() . "-" . $oDocument->getFileName();

		// find all the previous versions of this document and move them
		// ie. interrogate transaction history for all CHECKIN transactions and retrieve the versions
		// FIXME: refactor
		$sql = $default->db;
        $sQuery = "SELECT DISTINCT version FROM $default->document_transactions_table WHERE document_id = ? AND transaction_id = ?";/*ok*/
        $aParams = array($oDocument->getID(), CHECKOUT);
		$result = $sql->query(array($sQuery, $aParams));
        if ($result) {
            while ($sql->next_record()) {
            	$sVersion = $sql->f("version");
            	if ($sVersion <> $oDocument->getVersion()) {
					$sVersionedPath = $sCurrentPath . "-" . $sVersion;
					$sDeletedPath = $sDeletedPrefix . "-" . $sVersion;
					// move it to the deleted folder
					$default->log->info("PhysicalDocumentManager::delete moving $sVersionedPath to $sDeletedPath");
					if (!PhysicalDocumentManager::move($sVersionedPath, $sDeletedPath)) {
						$default->log->error("PhysicalDocumentManager::delete error moving $sVersionedPath to $sDeletedPath; documentID=" . $oDocument->getID());
						// FIXME: can't bail now since we don't have transactions- so we doggedly continue deleting and logging errors
					}
            	}
            }
        } else {
        	$default->log->error("PhysicalDocumentManager::delete error looking up document versions, id=" . $oDocument->getID());
        }	

		// now move the current version		
		if (PhysicalDocumentManager::move($sCurrentPath, $sDeletedPrefix)) {
			return true;
		} else {
			$default->log->error("PhysicalDocumentManager::delete couldn't move $sCurrentPath to $sDeletedPath, documentID=" . $oDocument->getID());
			return false;
		}
	}

	/**
	 * Completely remove a document from the Deleted/ folder
	 *
	 * return boolean true on successful move, false otherwhise
	 */	
	function expunge($oDocument) {
		global $default;
		// deleted document path
		$sDeletedPrefix = $default->documentRoot . "/Deleted/" . $oDocument->getID() . "-" . $oDocument->getFileName();
		
		// find all the previous versions of this document and delete them
		// ie. interrogate transaction history for all CHECKIN transactions and retrieve the versions
		// FIXME: refactor
		$sql = $default->db;
        $sQuery = "SELECT DISTINCT version FROM $default->document_transactions_table WHERE document_id = ? AND transaction_id = ?";/*ok*/
        $aParams = array($oDocument->getID(), CHECKOUT);
		$result = $sql->query(array($sQuery, $aParams));
        if ($result) {
            while ($sql->next_record()) {
            	$sVersion = $sql->f("version");
            	if ($sVersion <> $oDocument->getVersion()) {
					$sExpungePath = $sDeletedPrefix . "-" . $sVersion;
					// zap it
					$default->log->info("PhysicalDocumentManager::expunge rm'ing $sExpungePath");
					if (file_exists($sExpungePath)) {
						if (!unlink($sExpungePath)) {
							$default->log->error("PhysicalDocumentManager::expunge error deleting $sExpungePath; documentID=" . $oDocument->getID());
							// FIXME: can't bail now since we don't have transactions- so we doggedly continue deleting and logging errors
						}
					} else {
						$default->log->error("PhysicalDocumentManager::expunge can't rm $sExpungePath because it doesn't exist");
					}
            	}
            }
        } else {
        	$default->log->error("PhysicalDocumentManager::expunge error looking up document versions, id=" . $oDocument->getID());
        }	

		if (file_exists($sDeletedPrefix)) {
			// now delete the current version
			if (unlink($sDeletedPrefix)) {
				$default->log->info("PhysicalDocumentManager::expunge  unlinkied $sDeletedPrefix");			
				return true;
			} else {
				$default->log->info("PhysicalDocumentManager::expunge couldn't unlink $sDeletedPrefix");
				if (file_exists($sDeletedPrefix)) {
					return false;
				} else {
					return true;
				}
			}
		} else {
			$default->log->info("PhysicalDocumentManager::expunge can't rm $sDeletedPrefix because it doesn't exist");
			return true;
		}
	}
	
	/**
	 * Restore a document from the Deleted/ folder to the specified folder
	 *
	 * return boolean true on successful move, false otherwhise
	 */	
	function restore($oDocument) {
		global $default;
		
		// deleted document path (includes previous versions)
		$sDeletedPath = $default->documentRoot . "/Deleted/" . $oDocument->getID() . "-" . $oDocument->getFileName();
				
		// build the path to the new folder
		$sRestorePath = Folder::getFolderPath($oDocument->getFolderID()) . "/" . $oDocument->getFileName();
				
		// find all the previous versions of this document and move them
		// ie. interrogate transaction history for all CHECKIN transactions and retrieve the versions
		// FIXME: refactor
		$sql = $default->db;
        $sQuery = "SELECT DISTINCT version FROM $default->document_transactions_table WHERE document_id = ? AND transaction_id = ?";/*ok*/
        $aParams = array($oDocument->getID(), CHECKOUT);
		$result = $sql->query(array($sQuery, $aParams));
        if ($result) {
            while ($sql->next_record()) {
            	$sVersion = $sql->f("version");
            	if ($sVersion <> $oDocument->getVersion()) {
					$sVersionedDeletedPath = $sDeletedPath . "-" . $sVersion;
					$sVersionedRestorePath = $sRestorePath . "-" . $sVersion;
					// move it to the new folder
					$default->log->info("PhysicalDocumentManager::restore moving $sVersionedDeletedPath to $sVersionedRestorePath");
					if (!PhysicalDocumentManager::move($sVersionedDeletedPath, $sVersionedRestorePath)) {
						$default->log->error("PhysicalDocumentManager::restore error moving $sVersionedDeletedPath to $sVersionedRestorePath; documentID=" . $oDocument->getID());
						// FIXME: can't bail now since we don't have transactions- so we doggedly continue restoring and logging errors
					}
            	}
            }
        } else {
        	$default->log->error("PhysicalDocumentManager::expunge error looking up document versions, id=" . $oDocument->getID());
        }
		
		// now move the current version		
		if (PhysicalDocumentManager::move($sDeletedPath, $sRestorePath)) {
			return true;
		} else {
			$default->log->error("PhysicalDocumentManager::restore couldn't move $sDeletedPath to $sRestorePath, documentID=" . $oDocument->getID());
			return false;
		}		
	}
	
	
	/**
	* View a document using an inline viewer
	*
	* @param 	Primary key of document to view
	*
	* @return int number of bytes read from file on success or false otherwise;
	*
	* @todo investigate possible problem in MSIE 5.5 concerning Content-Disposition header
	*/
	function inlineViewPhysicalDocument($iDocumentID) {
            //get the document
            $oDocument = & Document::get($iDocumentID);		
            //get the path to the document on the server
            $sDocumentFileSystemPath = $oDocument->getPath();
            if (file_exists($sDocumentFileSystemPath)) {
                header("Content-Type: application/octet-stream");
                header("Content-Length: ". $oDocument->getFileSize());
                // prefix the filename presented to the browser to preserve the document extension
                header('Content-Disposition: inline; filename="' . $oDocument->getFileName() . '"');
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header("Cache-Control: must-revalidate");
                header("Content-Location: ".$oDocument->getFileName());
                return readfile($sDocumentFileSystemPath);
            } else {
                return false;
            }
	}
	
	/**
	* Get the uploaded file information and place it into a document object
	*
	* @param	Array containing uploaded file information (use $aFileArray)
	* par		Primary key of folder into which document will be placed
	*
	* @return Document Document object containing uploaded file information
	*/
	function & createDocumentFromUploadedFile($aFileArray, $iFolderID) {
		//get the uploaded document information and put it into a document object		
		$oDocument = & new Document($aFileArray['name'], $aFileArray['name'], $aFileArray['size'], $_SESSION["userID"], PhysicalDocumentManager::getMimeTypeID($aFileArray['type'], $aFileArray['name']), $iFolderID);
		return $oDocument;	
	}

    /**
    * Strip all but the extension from a file. For instance, input of
    * 'foo.tif' would return 'tif'.
    *
    * @param string filename
    * @return string extension for given file, without filename itself
    */
    function stripAllButExtension($sFileName) {
        return strtolower(substr($sFileName, strpos($sFileName, ".")+1, strlen($sFileName) - strpos($sFileName, ".")));
    }

    /**
    * Get the mime type primary key for a specific mime type
    *
    * @param string detected mime type
    * @param string filename
    * @return int mime type primary key if found, else default mime type primary key (text/plain)
    */
    function getMimeTypeID($sMimeType, $sFileName) {
        global $default;
        $sql = $default->db;
        $bOfficeDocument = false;

        // application/msword seems to be set by all Office documents
        if ($sMimeType == "application/msword") {
            $bOfficeDocument = true;
        }
        
        if ($bOfficeDocument || (!$sMimeType)) {
          // check by file extension
          $sExtension = PhysicalDocumentManager::stripAllButExtension($sFileName);
          $sql->query(array("SELECT id FROM " . $default->mimetypes_table . " WHERE LOWER(filetypes) = ?", $sExtension));/*ok*/
          if ($sql->next_record()) {
              return $sql->f("id");
          }
        }
        
        // get the mime type id
        if (isset($sMimeType)) {
            $sql->query(array("SELECT id FROM " . $default->mimetypes_table . " WHERE mimetypes = ?", $sMimeType));/*ok*/
            if ($sql->next_record()) {
                return $sql->f("id");
            }
        }

        //otherwise return the default mime type
        return PhysicalDocumentManager::getDefaultMimeTypeID();
    }

	/**
	* Get the default mime type, which is text/plain
	*
	* @return int default mime type
	*
	*/
	function getDefaultMimeTypeID() {
		global $default;
		$sql = $default->db;		
		$sql->query("SELECT id FROM " . $default->mimetypes_table . " WHERE mimetypes = 'text/plain'");/*ok*/
		$sql->next_record();
		//get the mime type id
		return $sql->f("id");
	}

	function getMimeTypeName($iMimeTypeID) {
		global $default;
		$sql = $default->db;
		$sql->query(array("SELECT mimetypes FROM " . $default->mimetypes_table . " WHERE id = ?", $iMimeTypeID));/*ok*/
		if ($sql->next_record()) {
			return $sql->f("mimetypes");			
		}
		return "application/octet-stream";
	}

    /**
    * Try well-defined methods for getting the MIME type for a file on disk.
    * First try PECL's Fileinfo library, then try mime_content_type() builtin.
    * If neither are available, returns NULL.
    *
    * @param string file on disk
    * @return string mime time for given filename, or NULL
    */
    function getMimeTypeFromFile($sFileName) {
        if (extension_loaded('fileinfo')) {
            $res = finfo_open(FILEINFO_MIME);
            $sType = finfo_file($res, $sFileName);
        }

        if (!$sType && function_exists('mime_content_type')) {
            $sType = @mime_content_type($sFileName);
        }

        if ($sType) {
            return preg_replace('/;.*$/', '', $sType);
        }

        return NULL;
    }
}

?>
