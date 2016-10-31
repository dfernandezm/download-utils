<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 02/09/2015
 * Time: 22:48
 */

namespace Morenware\DutilsBundle\Util;


class GeneralUtils {

    public static function endsWith($target, $suffix) {
        return strrpos($target, $suffix, strlen($target) - strlen($suffix)) !== false;
    }

    public static function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

}