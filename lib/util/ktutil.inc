<?php

/**
 * $Id: ktutil.inc,v 1.6 2005/07/20 18:20:04 nbm Exp $
 *
 * Small non-domain-specific utility functions
 *
 * Copyright (c) 2004 Jam Warehouse http://www.jamwarehouse.com
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
 * @version $Revision: 1.6 $
 * @author Neil Blakey-Milner <nbm@jamwarehouse.com>, Jam Warehouse (Pty) Ltd, South Africa
 */

// {{{ KTUtil
class KTUtil {
    function extractGPC () {
        foreach (func_get_args() as $var) {
            if (array_key_exists($var, $_REQUEST)) {
                $GLOBALS["$var"] = $_REQUEST["$var"];
            }
        }
    }

    function strToBool ($sString, $null = false, $empty = false) {
        $sString = strtoupper($sString);
        if ($sString == "Y") {
            return true;
        } elseif (($sString == "N")) {
            return false;
        } elseif (($sString == "ON")) {
            return true;
        } elseif (($sString == "OFF")) {
            return false;
        } elseif (($sString == "")) {
            return $empty;
        } else {
            return $null;
        }
    }

    function intToBool ($sString) {
        $iInt = (int)$sString;
        return $iInt !== 0;
    }


    function anyToBool ($sString, $null = false) {
        if (is_bool($sString)) {
            return $sString;
        }

        if (is_numeric($sString)) {
            return KTUtil::intToBool($sString);
        }

        if (is_string($sString)) {
            if (KTUtil::strToBool($sString) === true) {
                return true;
            }
        }

        if (is_null($sString)) {
            return $null;
        }

        return false;
    }

    function randomString($length=16, $sRandom="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"){
        $sString = "";
        $iCurLen = 0;
        $iRandomLen = strlen($sRandom);
        while ($length > $iCurLen) {
            $sString .= substr($sRandom, mt_rand(0, $iRandomLen -1), 1);
            $iCurLen++;
        }
        return $sString;
    }

    function arrayGet($aArray, $sKey, $mDefault = null) {
        if (array_key_exists($sKey, $aArray)) {
            return $aArray[$sKey];
        }
        return $mDefault;
    }

    function requestValue($sKey, $mDefault = null) {
        return KTUtil::arrayGet($_REQUEST, $sKey, $mDefault);
    }

    // {{{ whereToString
    /**
     * Convert an array of parameterised strings to a single
     * parameterised string.
     *
     * Return null in case of an empty array.
     */
    function whereToString($aWhere) {
        $aStrings = array();
        $aParams = array();
        foreach ($aWhere as $oSomething) {
            if (is_string($oSomething)) {
                $aStrings[] = $oSomething;
            } else if (is_array($oSomething)) {
                $aStrings[] = $oSomething[0];
                $aParams = array_merge($aParams, $oSomething[1]); 
            } else {
                return PEAR::raiseError("Weird WhereClause passed");
            }
        }
        if (count($aStrings) === 0) {
            return null;
        }
        return array(join(" AND ", $aStrings), $aParams);
    }
    // }}}
}
// }}}

?>
