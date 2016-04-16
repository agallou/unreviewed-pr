<?php

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->useAutowiring(false);

$containerBuilder->addDefinitions(__DIR__ . '/parameters.php');
$containerBuilder->addDefinitions(__DIR__ . '/container/db.php');
$containerBuilder->addDefinitions(__DIR__ . '/container/github.php');
$containerBuilder->addDefinitions(__DIR__ . '/container/hipchat.php');
$containerBuilder->addDefinitions(__DIR__ . '/container/model.php');
$containerBuilder->addDefinitions(__DIR__ . '/container/controllers.php');
$containerBuilder->addDefinitions(__DIR__ . '/container/middleware.php');


return $containerBuilder->build();
