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
�e�X�g�R���f�B�V�������񋓂��ꂽTSV�t�@�C������e�X�g�R�[�h�̃e���v���[�g�𐶐�����B

Usage: {{exe_path}} <command> ...

    <command>
    --generate   : �e�X�g�e���v���[�g�𐶐�����B�����̃e�X�g�R�[�h�ւ̒ǋL���s����B
    --replace    : �����̃e�X�g�t�@�C���̖��O���C������B
    --tomarkdown : TSV�t�@�C�����}�[�N�_�E���`���ɕϊ�����B

example: php {{exe_path}} --generate -s test/test.tsv -o output.txt -t template/junit.txt

note: TSV�t�@�C����1��ڂ��e�X�gNo�A2��ڂɑΏۃ��\�b�h�A3��ڂɐ����A4��ڈȍ~�ɃI�v�V�������L�q����B

EOT;

Usage::$messages['--generate'] = <<<EOT
Usage: {{exe_path}} --generate -s <source_file> -o <output_file> -t <template_file> [options...]
TSV����e�X�g�e���v���[�g�̐�������

    -s <source_file>   : �e�X�g�R���f�B�V�������񋓂��ꂽTSV�t�@�C�����w�肷��B (required)
    -o <output_file>   : �e�X�g�e���v���[�g�̏o�͐�t�@�C���w�肷��B (required)
    -t <template_file> : �e�X�g�R�[�h�̃e���v���[�g�t�@�C�����w�肷��B (required)
    [options]
    -a               : �����̃t�@�C���ɒǋL����B���ɋL�q����Ă���e�X�g�P�[�X�͒ǋL���Ȃ��Bo�I�v�V�������w�肳��Ă���K�v������B
    --header <num>   : �w�b�_�[�̍s�����w�肷��B�idefault: 1�j

EOT;

Usage::$messages['--replace'] = <<<EOT
Usage: {{exe_path}} --replace -s <source_file> -o <output_file> -t <template_file> [options...]
�����̃e�X�g�t�@�C���̖��O���C������B

    -s <source_file>  : �e�X�g�R���f�B�V�������񋓂��ꂽTSV�t�@�C�����w�肷��B (required)
    -o <output_file>  : �C���Ώۂ̃e�X�g�R�[�h�t�@�C�����w�肷��B(required)
    -t <template_file> : �e�X�g�R�[�h�̃e���v���[�g�t�@�C�����w�肷��B (required)
    [options]
    --header <num>   : �w�b�_�[�̍s�����w�肷��B�idefault: 1�j

EOT;
