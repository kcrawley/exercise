<?php namespace Core;

use Exception;

class View
{
    protected $viewStoragePath;

    public function __construct()
    {
        $this->viewStoragePath = Config::get('app.viewStoragePath');
        $this->cleanUp();
    }

    /**
     * Static facade accessor to makeView();
     *
     * @param $view
     * @param array $data
     * @throws \Exception
     * @return string
     */
    public static function make($view, $data = array())
    {
        $view = file_get_contents(
            Config::get('path').
            Config::get('app.viewPath').
            '/' . $view . '.php');

        if ($view === false) {
            throw new Exception('Unable to locate view resource' . $view);
        } else {
            $model = new View;

            return $model->generateView($view, $data);
        }
    }

    /**
     * Utilizes the output buffer function in PHP to fully execute a PHP script
     * with data array/objects injected through extract().
     *
     * @param $__path string containing full path to a php file
     * @param $__data array containing data that is used in the loaded php
     * @return string
     */
    protected function makeView($__path, $__data)
    {
        ob_start();

        extract($__data);

        include $__path;

        return ob_get_clean();
    }

    /**
     * Creates a compiled version of the view requested and returns the results of the make() method call.
     *
     * @param $view
     * @param array $data
     * @throws Exception
     * @return string
     */
    public function generateView($view, array $data)
    {
        $fileName = md5(time() . rand(1000,9999));

        $this->writeFile($view, $fileName);

        return $this->makeView($this->viewStoragePath . $fileName, $data);
    }

    /**
     * Stores the newly generated view used by the make method.
     *
     * @param $view
     * @param $fileName
     */
    protected function writeFile($view, $fileName)
    {
        $handle = fopen($this->viewStoragePath . $fileName, 'w');

        fwrite($handle, $view);

        fclose($handle);
    }

    /**
     * Scrubs the view generator storage directory for stale data. Purges anything > 10 minute old.
     */
    protected function cleanUp()
    {
        if ($handle = opendir($this->viewStoragePath)) {
            while (false !== ($file = readdir($handle))) {
                if ((time()-filectime($this->viewStoragePath.$file)) > 600) {
                    if ($file !== '..' AND $file !== '.') {

                        unlink($this->viewStoragePath.$file);
                    }
                }
            }
        }
    }
}