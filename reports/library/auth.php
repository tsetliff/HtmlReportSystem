<?php

use Zend\Authentication\Adapter\DbTable as AuthAdapter;

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
echo($result->getIdentity());
print_r($adapter->getResultRowObject());

if (!$result->isValid()) {
    echo("no authenticated :-/");
    die('dead');
} else {
    echo("got it!");
}