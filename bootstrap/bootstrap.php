<?php

use components\App;
use components\Router;
use components\Session;

$session = new Session();

$app = new App();

$router = new Router();
$router->handle();

$session->removeRequestSessions();