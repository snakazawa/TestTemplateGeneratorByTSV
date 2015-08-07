<?php

namespace CLI;

class Usage {
    public static $messages = [];

    const EXE_PATH_TEMP = '{{exe_path}}';

    public static function getMessage($name, $exe_path) {
        return str_replace(self::EXE_PATH_TEMP, $exe_path, self::$messages[$name]);
    }
}

Usage::$messages['main'] = <<<EOT
TestTemplateGeneratorByTSV
==========================
テストコンディションが列挙されたTSVファイルからテストコードのテンプレートを生成する。

Usage: {{exe_path}} <command> ...

    <command>
    --generate   : テストテンプレートを生成する。既存のテストコードへの追記も行える。
    --replace    : 既存のテストファイルの名前を修正する。
    --tomarkdown : TSVファイルをマークダウン形式に変換する。

example: php {{exe_path}} --generate -s test/test.tsv -o output.txt -t template/junit.txt

note: TSVファイルは1列目がテストNo、2列目に対象メソッド、3列目に説明、4列目以降にオプションを記述する。

EOT;

Usage::$messages['--generate'] = <<<EOT
Usage: {{exe_path}} --generate -s <source_file> -o <output_file> -t <template_file> [options...]
TSVからテストテンプレートの生成する

    -s <source_file>   : テストコンディションが列挙されたTSVファイルを指定する。 (required)
    -o <output_file>   : テストテンプレートの出力先ファイル指定する。 (required)
    -t <template_file> : テストコードのテンプレートファイルを指定する。 (required)
    [options]
    -a               : 既存のファイルに追記する。既に記述されているテストケースは追記しない。oオプションが指定されている必要がある。
    --header <num>   : ヘッダーの行数を指定する。（default: 1）

EOT;

Usage::$messages['--replace'] = <<<EOT
Usage: {{exe_path}} --replace -s <source_file> -o <output_file> -t <template_file> [options...]
既存のテストファイルの名前を修正する。

    -s <source_file>  : テストコンディションが列挙されたTSVファイルを指定する。 (required)
    -o <output_file>  : 修正対象のテストコードファイルを指定する。(required)
    -t <template_file> : テストコードのテンプレートファイルを指定する。 (required)
    [options]
    --header <num>   : ヘッダーの行数を指定する。（default: 1）

EOT;
