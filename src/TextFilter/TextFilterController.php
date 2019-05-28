<?php

namespace Mada\TextFilter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

class TextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response
        return $this->app->response->redirect("textfilter/bbcode");
    }
    
    /**
     * Use bbcode and nl2br to alter final text
     */
    public function bbcodeActionGet() : object
    {
        $page = $this->app->page;
        $text = "[b]Bold text[/b] [i]Ital\nic text[/i] [url=http://dbwebb.se]a link to dbwebb[/url]";

        $title = "Textfilter";        

        $filter = new \Mada\TextFilter\MyTextFilter();
        $html = $filter->parse($text, ["bbcode", "nl2br"]);

        $data = [
            "html" => $html,
        ];

        $page->add("textfilter/header");
        $page->add("textfilter/bbcode", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Use clickable to alter final text
     */
    public function linkActionGet() : object
    {
        $page = $this->app->page;
        $title = "Textfilter";

        $filter = new \Mada\TextFilter\MyTextFilter();
        $text = file_get_contents(__DIR__ . "/clickable.txt");
        $html = $filter->parse($text, ["link"]);

        $data = [
            "html" => $html,
        ];

        $page->add("textfilter/header");
        $page->add("textfilter/link", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Use markdown to alter final text
     */
    public function markdownActionGet() : object
    {
        $page = $this->app->page;
        $title = "Textfilter";

        $filter = new \Mada\TextFilter\MyTextFilter();
        $text = file_get_contents(__DIR__ . "/sample.md");
        $html = $filter->parse($text, ["markdown"]);

        $data = [
            "html" => $html,
        ];

        $page->add("textfilter/header");
        $page->add("textfilter/markdown", $data);

        return $page->render([
            "title" => $title,
        ]);
    }
}
