<?php

require_once "shablon_class.php";

class SearchContent extends Modules
{
    private $words;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->words = $this->data["words"] ?? "";
    }

    protected function getTitle()
    {
        return "Результати пошуку: " . $this->words;
    }

    protected function getDescription()
    {
        return $this->words;
    }

    protected function getKeyWords()
    {
        return mb_strtolower($this->words);
    }

    protected function getMiddle()
    {
        $results = $this->article->searchArticles($this->words);
        if ($results === false) return $this->getTemplate("search_notfound");

        $text = "";
        for ($i = 0; $i < count($results); $i++) {
            $sr["link"] = $this->config->address . "?view=article&id=" . $results[$i]["id"];
            $sr["title"] = $results[$i]["title"];
            $text .= $this->getReplaceTemplate($sr, "search_item");
        }
        $new_sr["search_item"] = $text;
        return $this->getReplaceTemplate($new_sr, "search_result");
    }
}
