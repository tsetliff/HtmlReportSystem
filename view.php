<?php
require_once("config.php");

$Report = new Report($_REQUEST['report']);
echo($Report->renderForView());
