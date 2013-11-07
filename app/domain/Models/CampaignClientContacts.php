<?php namespace Models;

use Core\Input;
use Core\Database;

class CampaignClientContacts extends Database
{
    public static function create()
    {
        $instance = new self;

        $instance->query('INSERT INTO campaign_client_contact (campaign_client_id, contact_name, notes) VALUES (?, ?, ?)', array(
            Input::get('campaign_client_id'), Input::get('contact_name'), Input::get('notes')
        ));
    }

    public static function update($id)
    {
        $instance = new self;

        $instance->query("UPDATE campaign_client_contact SET contact_name=?, notes=? WHERE id=?", array(
            Input::get('contact_name'), Input::get('notes'), $id

        ));
    }

    public static function delete($id)
    {
        $instance = new self;

        $instance->query("DELETE FROM campaign_client_contact WHERE id=?", array($id));
    }
} 