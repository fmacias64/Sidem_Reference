<?php
require_once("$default->fileSystemRoot/lib/database/datetime.inc");
// define error levels
define("DEBUG", 0);
define("INFO", 1);
define("ERROR", 2);
/**
 * $Id: Log.inc,v 1.21 2005/01/24 09:58:40 nbm Exp $
 *
 * File logging class.
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
 * @version $Revision: 1.21 $
 * @author Michael Joseph <michael@jamwarehouse.com>, Jam Warehouse (Pty) Ltd, South Africa
 * @package lib
 */ 
class KTLegacyLog {
    /**
     * The minimum logging level- log everything with
     * this error level and higher
     */
    var $minimumLoggingLevel = INFO;

    /**
     * The directory to save logs to
     */
    var $logDirectory;

    /**
     * The file to log the output to
     */
    var $logFile;

    /**
     * Default constructor
     *
     * @param string the path to the logfile to write to
     * @param int the desired level to log at
     * @param string log file name prefix     
     */
    function KTLegacyLog($logDirectory, $logLevel = INFO, $sLogFilePrefix = "log") {
        $this->logDirectory = $logDirectory;
        $this->minimumLoggingLevel = $logLevel;
        $this->sLogFilePrefix = $sLogFilePrefix;
    }


    /**
     * Creates the log file from the current datetime
     */
    function initialiseLogFile() {
        global $default;
        if (!file_exists($this->logDirectory)) {
            $res = @mkdir($this->logDirectory, 0755);
            if ($res === false) {
                return new PEAR_Error('Failed to create log directory (check permissions)');
            }
        }
            
        $this->logFile = $this->logDirectory . "/" . $this->sLogFilePrefix . "-" . date("Y-m-d") . ".txt";
        if (!file_exists($this->logFile)) {
            $res = @touch($this->logFile);
            if ($res === false) {
                return new PEAR_Error('Failed to create log file (check permissions)');
            }
        }
        if (!is_writable($this->logFile)) {
            return new PEAR_Error('Cannot write to log file (check permissions)');
        }
    }

    /**
     * Log a debug entry
     *
     * @param string the message to write to the log file
     */
    function debug($logEntry) {
        $this->writeLog($this->prefixEntry($logEntry, "DEBUG"), DEBUG);
    }

    /**
     * Log an info entry
     *
     * @param string the message to write to the log file
     */
    function info($logEntry) {
        $this->writeLog($this->prefixEntry($logEntry, "INFO"), INFO);
    }

    /**
     * Log an error entry
     *
     * @param string the message to write to the log file
     */
    function error($logEntry) {
        $this->writeLog($this->prefixEntry($logEntry, "ERROR"), ERROR);
    }

    /**
     * Writes to the log file, checking that the log level is within
     * the minimum logging level
     *
     * @param string the message to write to the log file
     * @param int the error level to log at
     */
    function writeLog($logEntry, $logLevel) {
        if ($logLevel >= $this->minimumLoggingLevel) {
            if (@$fp = fopen($this->logFile, "a")) {
                fwrite($fp, $logEntry);
            }
            @fclose($fp);
        }
    }

    /**
     * Prefixes the log entry with the current date time, the logging level
     * and the page that called it
     *
     * @param string the message to write to the log file
     * @param int the error level to log at     
     */
    function prefixEntry($logEntry, $logLevel) {
        return getCurrentDateTime() . " (" . getenv("REMOTE_ADDR") . ") $logLevel: $logEntry\n";
    }
}
?>
