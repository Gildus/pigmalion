<?php
include_once __DIR__.'/../src/parte2/employees/vendor/autoload.php';

$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4("Pigmalion\\Parte1\\Problem1\\", __DIR__.'/../src/parte1/problem1', true);
$classLoader->addPsr4("Pigmalion\\Parte1\\Problem2\\", __DIR__.'/../src/parte1/problem2', true);
$classLoader->addPsr4("Pigmalion\\Parte1\\Problem3\\", __DIR__.'/../src/parte1/problem3', true);
$classLoader->register();