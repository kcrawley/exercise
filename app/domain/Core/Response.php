<?php namespace Core;

class Response
{
    public static function json(array $output = array())
    {
        header('Content-Type: application/json');
        return json_encode($output);
    }
} 