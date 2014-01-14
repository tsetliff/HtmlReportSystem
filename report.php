<?php
require_once("config.php");

if ($_REQUEST['action'] == 'edit') {
    $Report = new Report_Edit($_REQUEST['report']);
} else {
    $Report = new Report($_REQUEST['report']);
}

echo($Report->render());
