<?php
/**
 * @author Ram
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authentication
{
    /*
     * Get userInfo
     */
    function get_user_info($platform = PLATFORM)
    {
        if ($platform == '') {
            $platform = PLATFORM;
        }

        return isset($_SESSION[$platform]['user_info']) ? $_SESSION[$platform]['user_info'] : FALSE;
    }

    /**
     * @param $user_info
     * @param $platform
     * @return bool
     */
    function set_authentication($user_info, $platform = PLATFORM)
    {
        if ($platform == '') {
            $platform = PLATFORM;
        }

        $_SESSION[$platform]['user_info'] = $user_info;
        return true;
    }

    /**
     * Unset auth
     */
    function unset_authentication($platform = PLATFORM)
    {
        if ($platform == '') {
            $platform = PLATFORM;
        }

        unset($_SESSION[$platform]['user_info']);
        return true;
    }

    function set_data($key, $value, $platform = PLATFORM)
    {
        if ($platform == '') {
            $platform = PLATFORM;
        }

        $_SESSION[$platform][$this->get_key($key)] = $value;
        return true;
    }

    function get_data($key, $platform = PLATFORM)
    {
        if ($platform == '') {
            $platform = PLATFORM;
        }

        return isset($_SESSION[$platform][$this->get_key($key)]) ? $_SESSION[$platform][$this->get_key($key)] : FALSE;
    }

    function unset_data($key, $platform = PLATFORM)
    {
        if ($platform == '') {
            $platform = PLATFORM;
        }

        unset($_SESSION[$platform][$this->get_key($key)]);
        return true;
    }

    function set_cookie($name, $value = null, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        if ($expire == null) {
            $expire = time() + 60 * 60 * 24 * 30;
        }
        setcookie($this->get_key($name), $value, $expire, $path, $domain, $secure, $httponly);
    }

    function get_cookie($key)
    {
        return isset($_COOKIE[$this->get_key($key)]) ? $_COOKIE[$this->get_key($key)] : FALSE;
    }

    function unset_cookie($key)
    {
        $this->setCookie($key, '', time() - 3600);
        $this->setCookie($key, '', time() - 3600, '/');
        unset($_COOKIE[$this->get_key($key)]);
    }

    function get_key($key)
    {
        return md5('QWERTY!@#$%^' . $key);
    }
}