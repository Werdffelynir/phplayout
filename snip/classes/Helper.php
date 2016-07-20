<?php


class Helper
{

    static public function post($key = null, $clear = true)
    {
        if (func_num_args() === 0)
            return $_POST;
        else {
            if (isset($_POST[$key])) {
                if ($clear)
                    return trim(strip_tags($_POST[$key]));
                else return $_POST[$key];
            }
        }
        return false;
    }

    static public function cookies($name, $value = null)
    {
        $argsNum = func_num_args();
        $argsValues = func_get_args();

        if ($argsNum == 1)
            return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;

        return call_user_func_array('setcookie', $argsValues);
    }

    static public function session($name, $value = null)
    {
        if (!isset($_SESSION))
            session_start();

        # session var set
        if (func_num_args() == 2)
            return ($_SESSION[$name] = $value);

        # session var get
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }


}
