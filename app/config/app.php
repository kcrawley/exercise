<?php

use Core\Config;

return array(
    'basePath'          => '', // change this to the actual install path (ex. /test)
    'viewPath'          => '/app/views', // location of our views
    'viewStoragePath'   => Config::get('path') . '/app/storage/views/', // storage path
    'debug'             => false // doesn't really do anything
);