<?php

use Core\Config;

function view_path()
{
    return Config::get('path') . Config::get('app.viewPath');
}