<?php

use Zend\Authentication\Adapter\DbTable as AuthAdapter;

session_start();
if (!(isset($_SESSION['validated']) && $_SESSION['validated'])) {
    $adapter = new AuthAdapter(
        $db,
        'users',
        'username',
        'password',
        'MD5(CONCAT(?, password_salt))'
    );
    $adapter->setIdentity('admin');
    $adapter->setCredential('admin');

    $result = $adapter->authenticate($adapter);
    //echo($result->getIdentity());
    //print_r($adapter->getResultRowObject());
    if ($result->isValid()) {
        $_SESSION['validated'] = true;
    }
    echo("Validated from DB!");
}

if (!(isset($_SESSION['validated']) && $_SESSION['validated'])) {
    echo("Not authenticated, show auth screen.");
    die('dead');
} else {
    $_SESSION['validated'] = true;
}
// Gather all the data you need and close the session data so it doesn't create locking issues.
session_write_close();