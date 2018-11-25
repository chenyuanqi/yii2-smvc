<?php

namespace common\helpers;

final class RegularHelper
{
    /**
     * 验证
     *
     * @param string $type 方法类型
     * @param string $value 值
     * @return false|int
     */
    public static function verify($type, $value)
    {
        return preg_match(self::$type() , $value);
    }
    /**
     * 手机号码正则
     *
     * @return string
     */
    public static function mobile()
    {
        return '/^[1][3456789][0-9]{9}$/';
    }

    /**
     * 电话正则
     * 格式为：XXXX-XXXXXXX，XXXX-XXXXXXXX，XXX-XXXXXXX，XXX-XXXXXXXX，XXXXXXX，XXXXXXXX
     *
     * @return string
     */
    public static function telephone()
    {
        return '/^(\(\d{3,4}\)|\d{3,4}-)?\d{7,8}$/';
    }

    /**
     * 身份证正则
     *
     * @return string
     */
    public static function identityCard()
    {
        return '/^\d{15}|\d{}18$/';
    }

    /**
     * 密码正则
     * 密码以字母开头，长度在 6-18 之间，只能包含字符、数字和下划线
     *
     * @return string
     */
    public static function password()
    {
        return '/^[a-zA-Z]\w{5,17}$/';
    }
}
