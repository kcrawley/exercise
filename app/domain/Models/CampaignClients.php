<?php namespace Models;

use Core\Database;
use Core\Input;

class CampaignClients extends Database
{
    /**
     * Returns an array of client data to populate the view
     *
     * @return mixed
     */
    public static function fetchAllClients()
    {
        $instance = new self;

        $clients = $instance->query('SELECT * FROM campaign_client');

        // traverses through the initial query grabbing associations. NOTE: i would use an ORM for this now, such as
        // ActiveRecord or Eloquent but for the purpose of this project I'm using libraries/stuff I've written myself
        // (jquery/bootstrap excluded)
        foreach ($clients as &$client) {
            $clientContacts = $instance->query('SELECT id, contact_name, notes
            FROM campaign_client_contact WHERE campaign_client_id = ?', array($client->id));

            foreach ($clientContacts as $clientContact) {
                $client->clientContacts[] = $clientContact;
            }

            $campaignProjectTypes = $instance->query('SELECT id, project_name, notes
            FROM campaign_project_type WHERE campaign_client_id = ?', array($client->id));

            foreach ($campaignProjectTypes as $campaignProjectType) {
                $client->campaignProjectTypes[] = $campaignProjectType;
            }
        }

        return $clients;
    }

    public static function validateName($_name, $_id = 0)
    {
        $instance = new self;

        return $instance->query('SELECT COUNT(*) as count FROM campaign_client WHERE name = ? AND id != ? LIMIT 1',
            array($_name, $_id));
    }

    public static function create()
    {
        $instance = new self;

        $instance->query('INSERT INTO campaign_client (name, notes) VALUES (?, ?)', array(
            Input::get('name'), Input::get('notes')
        ));
    }

    public static function update($id)
    {
        $instance = new self;

        $instance->query("UPDATE campaign_client SET name=?, notes=? WHERE id=?", array(
            Input::get('name'), Input::get('notes'), $id

        ));
    }

    public static function delete($id)
    {
        $instance = new self;

        $instance->query("DELETE FROM campaign_client WHERE id=?", array($id));
    }
} 