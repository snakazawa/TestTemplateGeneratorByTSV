<?php

namespace CLI;

require_once __DIR__.'/option.php';
require_once __DIR__.'/usage.php';

class CLI {
    public static $commands = ['--generate', '--replace'];

    const REQUIRE_LENGTH = 6; // require command, -s source_file and -o output_file

    public static function run($argc, $argv) {
        $res = self::parse_args($argc, $argv);
        if ($res['status'] === false) {
            fputs(STDERR, Usage::getMessage($res['command'], $argv[0]));
            return false;
        }

        return true;
    }

    public static function parse_args($argc, $argv) {
        $res = [
            'status' => false,
            'command' => 'main'
        ];

        // command
        if ($argc < 2) { return $res; }
        $command = $argv[1];
        if (array_search($command, self::$commands) === false) { return $res; }
        $res['command'] = $command;

        // other args
        if ($argc < self::REQUIRE_LENGTH) { return $res; }
        $opts = $res['opts'] = Option::getopt();
        if ($argc === false) { return $res; }

        // source_file
        $source_handle = self::open_file($opts['s'], 'r');
        if ($source_handle === false) { return $res; }
        $res['source_handle'] = $source_handle;

        // output_file
        $output_handle = self::open_file($opts['o'], $opts['a'] ? 'r+' : 'w');
        if ($output_handle === false) { return $res; }
        $res['output_handle'] = $output_handle;

        // success!
        $res['status'] = true;

        return $res;
    }

    private function open_file($path, $mode) {
        $source_handle = fopen($path, $mode);
        if ($source_handle === false) {
            fputs(STDERR, 'Error: '.$path.' could not opened');
        }
        return $source_handle;
    }
}