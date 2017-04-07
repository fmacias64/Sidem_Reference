<?php

require_once("../../../../../config/dmsDefaults.php");

KTUtil::extractGPC('fNewsID');

require_once("$default->fileSystemRoot/lib/dashboard/DashboardNews.inc");

/**
 * $Id: displayNewsImage.php,v 1.6 2004/11/26 21:10:48 nbm Exp $
 *
 * Displays a news item image.
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
 * @version $Revision: 1.6 $
 * @author Michael Joseph <michael@jamwarehouse.com>, Jam Warehouse (Pty) Ltd, South Africa
 * @package dashboard.news
 */
 
if (isset($fNewsID)) {
	$oNews = DashboardNews::get($fNewsID);
	$oNews->displayImage();
}
?>
