<?php namespace Models;

use Core\Input;
use Core\Database;

class CampaignProjectTypes extends Database
{
    public static function create()
    {
        $instance = new self;

        $instance->query('INSERT INTO campaign_project_type (campaign_client_id, project_name, notes) VALUES (?, ?, ?)',
            array(Input::get('campaign_client_id'), Input::get('project_name'), Input::get('notes')
        ));
    }

    public static function update($id)
    {
        $instance = new self;

        $instance->query("UPDATE campaign_project_type SET project_name=?, notes=? WHERE id=?",
            array(Input::get('project_name'), Input::get('notes'), $id
        ));
    }

    public static function delete($id)
    {
        $instance = new self;

        $instance->query("DELETE FROM campaign_project_type WHERE id=?", array($id));
    }
}