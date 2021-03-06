<?php
/**
 * $Id: UnitOrganisationLink.inc,v 1.12 2005/01/03 11:36:48 nbm Exp $
 *
 * Represents a unit, organisation link as per the database table units_organisations_link.
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
 * @version $Revision: 1.12 $
 * @author Rob Cherry, Jam Warehouse (Pty) Ltd, South Africa
 * @package lib.unitmanagement
 */
class UnitOrganisationLink extends KTEntity {
	
	/** primary key of object */
	var $iId;
	/** primary key of unit to which unit is linked */
	var $iUnitID;
	/** primary key of group to which group is linked */
	var $iOrgID; 
	
	
	function UnitOrganisationLink($iNewUnitID,$iNewOrgID) {
		//object not created in database yet
		$this->iId = -1;
		$this->iOrgID = $iNewOrgID;
		$this->iUnitID = $iNewUnitID;
	}
	
	/**
	* Get the object's primary key
	*
	* @return int object's primary key
	*
	*/
	function getID() {
		return $this->iId;
	}
	
	/**
	* Get the primary key of the org to which the unit is linked
	*
	* @return int primary key of org to which unit is linked
	*
	*/
	function getOrgID() {
		return $this->iOrgID;
	}
	
	/**
	* Set the primary key of the org to which the unit is linked
	*
	* @param 	int		Primary key of group to which unit is ilinked
	*
	*/
	function setOrgID($iNewValue) {
		$this->iOrgID = $iNewValue;
	}
	
	/**
	* Get the primary key of the unit to which the org is linked
	*
	* @return int primary key of unit to which the org is linked
	*
	*/
	function getUnitID() {
		return $this->iUnitID;
	}
	
	/**
	* Set the primary key of the unit to which the org is linked
	*
	* @param 	int		Primary key of unit to which the org is linked
	*
	*/
	function setUnitID($iNewValue) {
		$this->iUnitID = $iNewValue;
	}

    function _fieldValues () {
        return array(
            'unit_id' => $this->iUnitID,
            'organisation_id' => $this->iOrgID,
        );
    }

    function _table () {
        global $default;
        return $default->units_organisations_table;
    }
	
	/**
	* Create the current object in the database
	*
	* @return boolean on successful store, false otherwise and set $_SESSION["errorMessage"]
	*
	*/
	function create() {
		global $default, $lang_err_database, $lang_err_object_exists;
		//if the object hasn't been created
		if ($this->iId < 0) {
			
			$sql = $default->db;
			$query = "SELECT unit_id FROM $default->units_organisations_table WHERE unit_id = ? AND organisation_id = ?";/*ok*/
            $params = array($this->iUnitID, $this->iOrgID);
    		$sql->query(array($query, $params));
   			$rows = $sql->num_rows($sql);
        
  			if ($rows > 0) {
				$_SESSION["errorMessage"] = "UnitOrganisationlink::The id " . $this->iUnitID . " is already exist!";
				return false;
       		}
        }
        return parent::create();
	}
	
	/**
	* Static function.
	* Given a groups_units_link primary key it will create a 
	* UnitsOrganisationsLink object and populate it with the 
	* corresponding database values
	*
	* @return UnitsOrganisationsLink populated UnitsOrganisationLink object on successful query, false otherwise and set $_SESSION["errorMessage"]
	*/
	function & get($iUnitOrganisationLinkID) {
		global $default;	
		$sql = $default->db;
		$result = $sql->query(array("SELECT * FROM $default->units_organisations_table WHERE id = ?", $iUnitOrganisationLinkID));/*ok*/
		if ($result) {
			if ($sql->next_record()) {
				$oUnitOrganisationLink = & new UnitOrganisationLink($sql->f("unit_id"),$sql->f("organisation_id") );
				$oUnitOrganisationLink->iId = $iUnitOrganisationLinkID;
				return $oUnitOrganisationLink;
			}
			return false;
		}
		$_SESSION["errorMessage"] = $lang_err_database;
		return false;
	}

/**
	* Static function
	* Get a list of web documents
	*
	* @param 	String		Where clause (not required)
	*
	* @return Array array of UnitOrganisationLink objects, false otherwise and set $_SESSION["errorMessage"]
	*/
	function getList($sWhereClause = null) {
            return KTEntityUtil::getList(UnitOrganisationLink::_table(), 'UnitOrganisationLink', $sWhereClause);
	}
	
	/**
     * static function
     *
     * test to see if unit belongs to org
     *
     * @param   false or a value
     */
	function unitBelongsToOrg($unitId) {
		global $default;
		return lookupField("$default->units_organisations_table", "organisation_id", "unit_id", $unitId );
	}
	
	/*
     * static function
     *
     * sets the id of the unitorg using their unit id
     *
     * @param   String
     *   The unit_ID
     *   
     */
	function setUnitOrgID($unitId) {
		global $default;
		$id = lookupID($default->units_organisations_table, "unit_id",  $unitId);
		$this->iId= $id;
	}
	
	function getByUnitID($unitId) {
		global $default;
		$sql = $default->db;
		$result = $sql->query(array("SELECT * FROM $default->units_organisations_table WHERE unit_id = ?", $unitId));/*ok*/
		if ($result) {		    	
			if ($sql->next_record()) {
				$oUnitOrganisationLink = & UnitOrganisationLink::get($sql->f("id"));
				return $oUnitOrganisationLink;	        		
			} else { 
				return false;
			}
		} else { 
			return false; 
		}
	}
}
?>
