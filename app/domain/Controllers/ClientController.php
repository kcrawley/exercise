<?php namespace Controllers;

use Core\Response;
use Models\CampaignClients;

class ClientController extends BaseController
{
    public function getClients()
    {
        $data = CampaignClients::fetchAllClients();

        return Response::json(array('package' => $data));
    }
}