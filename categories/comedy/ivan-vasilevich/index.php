<?php

$levels = '';
while (!is_file($levels . 'root.txt')) {
    $levels .= '../';
}
require_once $levels . 'func/gi.php';

$page = new Controller($levels);
$page->build();
