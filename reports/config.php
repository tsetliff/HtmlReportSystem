<?php
require_once('vendor/autoload.php');
require_once("library/includes.php");

/**
 * Configuration
 */

define('INSTALL_LOCATION', '/var/www/html');
define('WEB_ROOT', 'https://192.168.1.13/');
define('RESOURCE_LOCATION', INSTALL_LOCATION . '/resources');

/**
 * Data Sources
 *
 * It is very important to create read only users on your databases for this
 * program to access.
 */

$DS = new DataSource_MySQL("Local MySQL Test");
$DS->setParameter('server', 'localhost');
$DS->setParameter('username', 'testuser');
$DS->setParameter('password', '');
$DS->setParameter('database', 'test');

/**
 * You can probably just leave this driver here all of the time.
 * To use it just upload a tab or comma seperated file to the CSV Data Sources directory.
 */
$DS = new DataSource_Csv("CSV Files");
$DS->setParameter('ResourceLocation', 'CSV Data Sources');
$DS->setParameter('database', 'test');

/**
 * Internal database connection
 *
 * Used for authentication information and such in this report software.
 */
$db = new Zend\Db\Adapter\Adapter(array(
    'driver'   => 'Mysqli',
    'database' => 'reports',
    'host'     => 'localhost',
    'username' => 'reports',
    'password' => 'reportsPassword',
    'options' => array('buffer_results' => true)
));

require_once("library/auth.php");