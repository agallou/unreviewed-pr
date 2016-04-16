<?php

require_once __DIR__.'/../vendor/autoload.php';

$container = require __DIR__ . "/../config/container.php";

$app = new DI\Bridge\Silex\Application($containerBuilder);

if (1 == $app['app.debug']) {
    $app['debug'] = true;
}

$app->register(new \Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->get('/capabilities', "controllers.hipchat.capabilities:action");
$app->post('/installed', "controllers.hipchat.install:action");
$app->get('/configure', "controllers.hipchat.configure:action");

$app->get('/glance', "controllers.hipchat.glance:action")
    ->after($app['middleware.send_cors'])
;

$app->get('/sidebar', "controllers.hipchat.webPanel:action")
    ->after($app['middleware.send_cors'])
;

$app->get('/login_github', "controllers.github.login:action");
$app->match('/github/webhook', 'controllers.github.webhook:action');

$app->get('/app/list_repositories', "controllers.app.list_repositories:action")
    ->before($app['middleware.needs_subscriber'])
    ->before($app['middleware.needs_github_token'])
;

$app->run();
