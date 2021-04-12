<?php
namespace app\utils;

class Text
{
    public static function highlight($text_highlight, $text_search)
    {
        if (!$text_highlight) {
            return $text_search;
        }
        return preg_replace('#' . preg_quote($text_highlight) . '#i', '<text style="background-color:#FFFF66; color:#FF0000;">\\0</text>', $text_search);
    }
}