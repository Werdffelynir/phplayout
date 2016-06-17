<?php

/**
 * Class Layout.
 * new Layout( [ 'path' => '', 'template' => '' ] )
 * ->render( $view [, $data [, $callback]] )
 * ::value( $name [, $value] )
 * ->setPosition($position, $view [, $data [, $callback]] )
 * ::outPosition($position [, $returned] )
 * ->outTemplate( [$returned] )
 */
class Layout 
{
    /**
     * Default configuration
     * @var array
     */
    private $defConfig = [
        'path' => __DIR__,
        'template' => 'template.php',
    ];

    /**
     * Global template values store
     * @var array
     */
    static private $templateValues = [];

    /**
     * Positions store
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
     * Render partial view, merge variables with (array) $data and pass $data across $callback function
     * @param $view
     * @param array $data
     * @param $callback
     * @return bool|string
     */
    public function render($view, array $data = [], callable $callback = null)
    {
        if($view_path = $this->realFile($view)) {

            if($callback) {
                $callback_result = $callback($data);
                if(is_array($callback_result))
                    $data = $callback_result;
            }

            ob_start();
            extract((array) $data);
            require($view_path);
            return ob_get_clean();
        }else
            return false;
    }

    /**
     * Set or get global values
     * @param $name
     * @param null $value
     * @return null
     */
    static public function value($name, $value = null)
    {
        return $value === null
            ? (isset(self::$templateValues[$name]) ? self::$templateValues[$name]:null)
            : self::$templateValues[$name] = $value;
    }

    /**
     * Set $view to $position (look - outPosition())
     * @param $position
     * @param $view
     * @param array $data
     * @param $callback
     */
    public function setPosition($position, $view, array $data = [], $callback = null)
    {
        self::$positionsData[$position] = $this->render($view, $data, $callback);
    }

    /**
     * Output view into place,
     * from position store.  (for assign look - setPosition())
     * @param $position
     * @param bool $returned
     * @return null
     */
    static public function outPosition($position, $returned = false)
    {
        $view = isset(self::$positionsData[$position]) ? self::$positionsData[$position] : null;
        if($returned)
            return $view;
        echo $view;
    }

    /**
     * Output Template
     * @param bool $returned
     * @return bool|string
     */
    public function outTemplate($returned = false)
    {
        $template = $this->render($this->defConfig['template'], self::$templateValues);
        if($returned) return $template;
        else
            echo $template;
    }

    /**
     * Return full file path
     * @param $file
     * @return bool|string
     */
    private function realFile($file)
    {
        $file = rtrim(str_replace('\\', '/', $this->defConfig['path']),'/') . '/' . trim($file, '/');

        if(substr($file, -4) !== '.php')
            $file .= '.php';

        return is_file($file) ? $file : false;
    }


}


