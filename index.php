<?php
require "app/start.php";

// sets runtime path information
\Core\Config::set('path', __DIR__);

// runs application
$app = new \Core\App();
$app->run();