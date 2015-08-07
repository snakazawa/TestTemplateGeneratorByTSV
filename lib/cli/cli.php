<?php

namespace CLI;

use Generator\Generate;
use Generator\Replace;
use Util\File;

require_once __DIR__.'/option.php';
require_once __DIR__.'/usage.php';
require_once __DIR__.'/../util/file.php';
require_once __DIR__.'/../generator/generate.php';
require_once __DIR__.'/../generator/replace.php';

class CLI {
    public static $commands = ['--generate', '--replace'];

    const REQUIRE_LENGTH = 8; // require command, -s source_file and -o output_file -t template_file

    public static function run($argc, $argv) {
        $res = self::run_wrap($argc, $argv);
        File::close_all();
        return $res;
    }

    private static function run_wrap($argc, $argv) {
        $res = self::parse_args($argc, $argv);
        if ($res['status'] === false) {
            fputs(STDERR, Usage::getMessage($res['command'], $argv[0]));
            return false;
        }

        switch ($res['command']) {
            case '--generate':
                Generate::run($res['opts']);
                break;
            case '--replace':
                Replace::run($res['opts']);
                break;
            default:
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
        $source_handle = File::open($opts['s'], 'r');
        if ($source_handle === false) { return $res; }
        $res['opts']['source_handle'] = $source_handle;

        // output_file
        $output_handle = File::open($opts['o'], $opts['a'] ? 'r+' : 'w');
        if ($output_handle === false) { return $res; }
        $res['opts']['output_handle'] = $output_handle;

        // template file
        $template_handle = File::open($opts['t'], 'r');
        if ($template_handle === false) { return $res; }
        $res['opts']['template_handle'] = $template_handle;

        // success!
        $res['status'] = true;

        return $res;
    }
}