<?php

namespace nakazawa\ttgbtsv\Util;

class File {
    public static $handles = [];

    public static function open($path, $mode) {
        $handle = fopen($path, $mode);
        if ($handle === false) {
            fputs(STDERR, 'Error: '.$path.' could not opened');
        }
        self::$handles[] = $handle;
        return $handle;
    }

    public static function close($handle) {
        if (fclose($handle)) {
            $pos = array_search($handle, self::$handles);
            if ($pos !== false) {
                unset(self::$handles[$pos]);
            }
        }
    }

    public static function close_all() {
        foreach (self::$handles as $handle) {
            self::close($handle);
        }
    }

    public static function read($path) {
        return file_get_contents($path);
    }

    public static function read_tsv($handle, $header_rows) {
        $header = '';
        $body = [];
        $collen = 0;

        for ($i = 0; $i < $header_rows; $i++) {
            if (($str = fgets($handle)) === false) { break; }
            $header = fgets($handle)."\n";
        }
        if ($header !== '') { $header .= "\n"; }

        while (($str = fgetcsv($handle, 1000, "\t","\"")) !== false) {
            $body[] = $str;
            $collen = max($collen, count($str));
        }

        return ['header' => $header, 'body' => $body, 'collen' => $collen];
    }

    public static function write($handle, $str) {
        fputs($handle, $str);
    }
}