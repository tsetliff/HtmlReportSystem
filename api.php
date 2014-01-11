<?php
require_once("config.php");
/**
 * This file is intended to simply serve resources.
 *
 * Resources are served through this file so that in the future they may have additional ACL
 * control or be placed in a different management system.
 */
//$resource = $_REQUEST['resource'];
if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
} else {
    $action = 'view';
}