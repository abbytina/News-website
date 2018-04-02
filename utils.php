<?php
/**
 * Created by PhpStorm.
 * User: ivoth
 * Date: 2018/3/31
 * Time: 21:12
 */
 header('content-type:text/html;charset=utf-8');
class Utils
{
    public static function formatApi($code, $msg = '', $data = null, $extends = array())
    {
        $arr = array(
            'code' => $code,
            'msg' => $msg,
            'data' => array()
        );
        if (!is_null($data)) {
            $arr['data'] = $data;
        }
        if (!empty($extends) && is_array($extends)) {
            $arr = array_merge($arr, $extends);
        }

        return json_encode_no_zh($arr);
    }

    /**
     * @param $name
     * @param null $value
     * @return mixed
     */
    public static function session($name, $value = null)
    {
        session_start();
        if (is_array($name)) {
            foreach ($name as $i => $item) {
                $_SESSION[$i] = $item;
            }
            return;
        }
        if (empty($value)) {
            return $_SESSION[$name];
        }
        $_SESSION[$name] = $value;
    }

    /**
     * @return bool
     */
    public static function isLogin()
    {
        $session = self::session('userInfo');
        return empty($session);
    }

    public static function getUserInfo()
    {
        if (self::isLogin()) {
            exit(self::formatApi(401, '未登录'));
        }
        return self::session('userInfo');
    }
}