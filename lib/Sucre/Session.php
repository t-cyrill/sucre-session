<?php
namespace Sucre;

class Session {
    private static $onetime_values;
    private static $permanent_values;

    const ONETIME_KEY = '__onetime_values';

    /**
     * セッションを扱うための初期化を行う
     *
     * このメソッドの呼び出しにより、session_startが行われます。
     */
    public static function init($regenerate = false)
    {
        if (session_id() === '') {
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
     * 一時的な値を取得する
     */
    public static function getFlash($key)
    {
        return isset(self::$onetime_values[$key]) ? self::$onetime_values[$key] : null;
    }

    /**
     * 一時的な値を設定する
     */
    public static function setFlash($key, $value)
    {
        self::$onetime_values[$key] = $value;
        $_SESSION[self::ONETIME_KEY][$key] = $value;
    }

    /**
     * セッション変数の値を取得する
     */
    public static function get($key)
    {
        return isset(self::$permanent_values[$key]) ? self::$permanent_values[$Key] : null;
    }

    /**
     * セッション変数に値を設定する
     */
    public static function set($key, $value)
    {
        self::$permanent_values[$key] = $value;
        $_SESSION[$key] = $value;
    }

    /**
     * セッションIdを取得する
     */
    public static function getId()
    {
        return session_id();
    }

    /**
     * セッションIdを設定する
     */
    public static function setId($id)
    {
        session_id($id);
    }

    /**
     * セッションIdを再生成する
     */
    public static function regenerateId($delete_old = true)
    {
        session_regenerate_id($delete_old);
    }

    /**
     * セッションを完全に破棄する
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
