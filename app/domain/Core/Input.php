<?php namespace Core;

class Input {
    public static function get($key)
    {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        } else {
            return '';
        }
    }

    public static function has($key)
    {
        if (isset($_REQUEST[$key])) {
            return true;
        } else {
            return false;
        }
    }

    public static function all()
    {
        $inputs = array();

        foreach ($_REQUEST as $key => $val) {
            $inputs[$key] = $val;
        }

        return $inputs;
    }

    public static function serialize($params)
    {
        $outputString = '';

        $stringer = function($key, $val) {
            return $key . '=' . $val . '&';
        };

        $formString = function($string) {
            return '?' . substr($string, 0, -1);
        };

        foreach($params as $key => $val) {
            $outputString .= $stringer($key, $val);
        }

        return $formString($outputString);
    }
}