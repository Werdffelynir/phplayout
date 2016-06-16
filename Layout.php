<?php


class Layout 
{
    /**
     * @var array
     */
    private $defConfig = [
        'path' => __DIR__,
        'template' => 'template.php',
    ];

    /**
     * @var array
     */
    static private $templateValues = [];

    /**
     * @var array
     */
    static private $positionsData = [];

    /**
     * Layout constructor.
     * @param $config
     */
    public function __construct($config)
    {
        foreach($this->defConfig as $dcKey => $dcVal) {
            if(!empty($config[$dcKey]))
                $this->defConfig[$dcKey] = $config[$dcKey];
        }
    }

    /**
     * @param $position
     * @param $view
     * @param array $data
     */
    public function render($position, $view, array $data = [])
    {
        self::$positionsData[$position] = $this->part($view, $data);
    }

    /**
     * @param $view
     * @param array $data
     * @return bool|string
     */
    public function part($view, array $data = [])
    {
        if($view_path = $this->realFile($view)) {
            ob_start();
            extract($data);
            require($view_path);
            return ob_get_clean();
        }else
            return false;
    }

    /**
     * @param $position
     * @param bool $returned
     * @return null
     */
    static public function output($position, $returned = false)
    {
        $view = isset(self::$positionsData[$position]) ? self::$positionsData[$position] : null;
        if($returned)
            return $view;
        echo $view;
    }

    static public function value($name, $value = null)
    {
        return $value === null
            ? (isset(self::$templateValues[$name]) ? self::$templateValues[$name]:null)
            : self::$templateValues[$name] = $value;
    }
    /**
     * @param $file
     * @return bool|string
     */
    public function realFile($file)
    {
        $file = rtrim(str_replace('\\', '/', $this->defConfig['path']),'/') . '/' . trim($file, '/');

        if(substr($file, -4) !== '.php')
            $file .= '.php';

        return is_file($file) ? $file : false;
    }

    /**
     * @param bool $returned
     * @return bool|string
     */
    public function outputTemplate($returned = false)
    {
        $template = $this->part($this->defConfig['template'], self::$templateValues);
        if($returned) return $template;
        else
            echo $template;
    }

}


