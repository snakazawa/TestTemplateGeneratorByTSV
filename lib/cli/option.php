<?php

namespace CLI;

class Option {
    public static $options = 'ao:s:t:';
    public static $longopts = [
        'generate',
        'replace',
        'header:'
    ];

    public static $requires = [
        's', 'o', 't'
    ];

    public static $defaults = [
        'a' => false,
        'header' => 1
    ];

    public static function getopt() {
        $opts = getopt(self::$options, self::$longopts);

        if (!self::check_requires($opts)) { return false; }

        self::set_defaults($opts);

        return $opts;
    }

    private static function check_requires($opts) {
        foreach (self::$requires as $key) {
            if (!array_key_exists($key, $opts)) { return false; }
        }
        return true;
    }

    private static function set_defaults(&$opts) {
        foreach (self::$defaults as $key => $val) {
            if (!array_key_exists($key, $opts)) {
                $opts[$key] = $val;
            }
        }
        return $opts;
    }
}
