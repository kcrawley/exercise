<?php namespace Core;

class Session
{
    protected static $instance;
    protected $sessionName = 'app_client';
    protected $flash = false;

    public function __construct()
    {
        session_name($this->sessionName);

        if(session_id() == '') {
            session_start();
        }

        if (isset($_SESSION[$this->sessionName]) === false) {
            $_SESSION[$this->sessionName] = array();
        }

        // destroys flash data after use
        if ($this->flash === false) {
            if (isset($_SESSION[$this->sessionName]['flashed'])) {
                unset($_SESSION[$this->sessionName]['flashed']);
                unset($_SESSION[$this->sessionName]['flashData']);
            }
        }
    }

    public static function setupInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Session;
        }
    }

    public static function get($key = null)
    {
        self::setupInstance();

        if (is_null($key)) {
            return $_SESSION[self::$instance->sessionName];
        } elseif (isset($_SESSION[self::$instance->sessionName][$key])) {
            return $_SESSION[self::$instance->sessionName][$key];
        } elseif (isset($_SESSION[self::$instance->sessionName]['flashData'][$key])) {
            return $_SESSION[self::$instance->sessionName]['flashData'][$key];
        } else {
            return '';
        }
    }

    public static function flash($key, $value)
    {
        self::setupInstance();

        self::$instance->flash = true;
        $_SESSION[self::$instance->sessionName]['flashed'] = true;
        $_SESSION[self::$instance->sessionName]['flashData'][$key] = $value;
    }

    public static function set($key, $value)
    {
        self::setupInstance();

        $_SESSION[self::$instance->sessionName][$key] = $value;
    }

    public static function has($key)
    {
        self::setupInstance();

        return isset($_SESSION[self::$instance->sessionName][$key]);
    }

    public static function destroy($key)
    {
        self::setupInstance();

        if (self::has($key)) {
            unset($_SESSION[self::$instance->sessionName][$key]);
        }
    }

    public static function flashInputs()
    {
        foreach (Input::all() as $key => $val) {
            self::flash($key, $val);
        }
    }
}