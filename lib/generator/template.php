<?php

namespace nakazawa\ttgbtsv\Generator;

class Template {
    const NO = '{{no}}';
    const METHOD = '{{method}}';
    const ENCODED_METHOD = '{{{method}}}';
    const CONTEXT = '{{context}}';
    const ENCODED_CONTEXT = '{{{context}}}';
    const OPTIONS = '{{options}}';
    const SPECIAL_CHAR = '_';

    private $template;
    private $before_option_text;


    public function __construct($template) {
        $this->template = $template;
        $this->before_option_text = $this->get_before_text_of_replace_option();
    }

    public function convert($opts) {
        if (count($opts) < 3) return false;
        return $this->replace_all($opts);
    }

    protected function replace_all($opts){
        $text = $this->template;
        $text = str_replace(self::ENCODED_METHOD, $this->encode_method_string($opts[1]), $text);
        $text = str_replace(self::ENCODED_CONTEXT, $this->encode_context_string($opts[2]), $text);
        $text = str_replace(self::NO, $opts[0], $text);
        $text = str_replace(self::METHOD, $opts[1], $text);
        $text = str_replace(self::CONTEXT, $opts[2], $text);
        if (count($opts) > 2) {
            $text = str_replace(self::OPTIONS,
                implode("\n".$this->before_option_text, array_splice($opts, 3)),
                $text);
        }
        return $text;
    }

    protected function get_before_text_of_replace_option() {
        $regex = '/(.*?)'.preg_replace('/(\{|\})/', '\\\\$1', self::OPTIONS).'/';
        if (preg_match($regex, $this->template, $matches)) {
            return $matches[1];
        }
        return false;
    }

    protected function encode_method_string($str) {
        return preg_replace('/\(\)\s*$/', '', $str);
    }

    protected function encode_context_string($str) {
        $str = str_replace(' ', '_', $str);
        $str = str_replace('　', '__', $str);
        $str = preg_replace('/[^\d\w_-]/', self::SPECIAL_CHAR, $str);
        return $str;
    }
}