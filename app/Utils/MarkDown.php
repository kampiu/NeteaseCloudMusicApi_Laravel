<?php
/**
 * Created by PhpStorm.
 * Author: KAM
 * Date: 2019/5/20
 * Time: 9:06
 */

namespace App\Utils;

use Parsedown;
use League\HTMLToMarkdown\HtmlConverter;


class MarkDown
{
    protected $htmlConverter;
    protected $markdownConverter;

    public function __construct()
    {
        $this->htmlConverter = new HtmlConverter();

        $this->markdownConverter = new Parsedown();
    }

    public function convertMarkdownToHtml($markdown)
    {
        return $this->markdownConverter->setBreaksEnabled(true)->text($markdown);
    }

    public function convertHtmlToMarkdown($html)
    {
        return $this->htmlConverter->convert($html);
    }

}