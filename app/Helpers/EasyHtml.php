<?php

namespace App\Helpers;

class EasyHtml
{
    /**
     * function make
     *
     * @param string $content
     * @return \Illuminate\Support\HtmlString
     */
    public static function make(string $content = ''): \Illuminate\Support\HtmlString
    {
        return new \Illuminate\Support\HtmlString($content);
    }
}
