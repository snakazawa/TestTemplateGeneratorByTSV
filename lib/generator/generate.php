<?php

namespace nakazawa\ttgbtsv\Generator;

use nakazawa\ttgbtsv\Util\File;

class Generate {
    public static function run($opts) {
        $tsv = File::read_tsv($opts['source_handle'], $opts['header']);
        $template = new Template(File::read($opts['t']));

        self::put_body($tsv, $opts['output_handle'], $template);
    }

    /**
     * @param $tsv
     * @param $handle
     * @param Template $template
     */
    protected static function put_body($tsv, $handle, $template) {
        foreach ($tsv['body'] as $row) {
            $text = $template->convert($row);
            if ($text !== false) {
                File::write($handle, $text."\n\n");
            }
        }
    }
}