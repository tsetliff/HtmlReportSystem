<?php
/**
 * Being a tiny program and all I'm just going to list everything that needs to be loaded
 */
define('CLASS_DIRECTORY', 'classes');

require_once(CLASS_DIRECTORY . "/DataSource.php");
require_once(CLASS_DIRECTORY . "/DataSource_Csv.php");
require_once(CLASS_DIRECTORY . "/DataSource_MySQL.php");
require_once(CLASS_DIRECTORY . "/Report.php");
require_once(CLASS_DIRECTORY . "/Report_Edit.php");
