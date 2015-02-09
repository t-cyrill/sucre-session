<?php
namespace Sucre;

class Session {
    private static $onetime_values,
                   $permanent_values,
                   $regenerated = false;

    const ONETIME_KEY = '__onetime_values';

    /**
     * Sucre::Session's initializer
     * This function call session_start() if not initialized
     *
     * @param bool $regenerate true: call self::regenerateId();
     */
    public static function init($regenerate = false)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($regenerate) {
            self::regenerateId();
        }

        self::$onetime_values = isset($_SESSION[self::ONETIME_KEY]) ? $_SESSION[self::ONETIME_KEY] : array();
        unset($_SESSION[self::ONETIME_KEY]);

        self::$permanent_values = $_SESSION;

        $_SESSION[self::ONETIME_KEY] = array();
    }

    /**
     * Get onetime value
     *
     * @param mixed $key key name
     * @return mixed value or null if not set
     */
    public static function getFlash($key)
    {
        return isset(self::$onetime_values[$key]) ? self::$onetime_values[$key] : null;
    }

    /**
     * Set onetime value
     *
     * @param mixed $key key name
     * @param mixed $value value
     */
    public static function setFlash($key, $value)
    {
        self::$onetime_values[$key] = $value;
        $_SESSION[self::ONETIME_KEY][$key] = $value;
    }

    /**
     * Get $_SESSION value
     *
     * @return mixed value or null if not set
     */
    public static function get($key)
    {
        return isset(self::$permanent_values[$key]) ? self::$permanent_values[$key] : null;
    }

    /**
     * Set $_SESSION value
     */
    public static function set($key, $value)
    {
        self::$permanent_values[$key] = $value;
        $_SESSION[$key] = $value;
    }

    /**
     * Alias session_id
     */
    public static function getId()
    {
        return session_id();
    }

    /**
     * Alias session_id($id)
     *
     * @param mixed $id new settion id
     */
    public static function setId($id)
    {
        session_id($id);
    }

    /**
     * Alias session_regenerate_id($delete_old)
     *
     * @param bool $delete_old [=true]
     */
    public static function regenerateId($delete_old = true)
    {
        self::$regenerated = true;
        session_regenerate_id($delete_old);
    }

    /**
     * Get session_id regenerated status
     */
    public static function regenerated()
    {
        return self::$regenerated;
    }

    /**
     * Drop session
     */
    public static function destroy()
    {
        $_SESSION = array();
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();
    }
}
