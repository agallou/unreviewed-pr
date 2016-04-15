<?php

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->useAutowiring(false);

$containerBuilder->addDefinitions(__DIR__ . '/parameters.php');
$containerBuilder->addDefinitions(__DIR__ . '/container_db.php');
$containerBuilder->addDefinitions(__DIR__ . '/container_model.php');
$containerBuilder->addDefinitions(__DIR__ . '/container_controllers.php');

return $containerBuilder->build();
