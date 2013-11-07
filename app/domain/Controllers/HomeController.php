<?php namespace Controllers;

use Core\View;

class HomeController extends BaseController
{
    public function loadLanding()
    {
        $data = array(
            'pageTitle' => 'Welcome!'
        );

        return View::make('landingPage', $data);
    }
} 