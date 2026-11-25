<?php

require_once "shablon_class.php";

class ArticleContent extends Modules
{
    private $article_info;
    public $article_id;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->article_id = $this->data["id"] ?? 0;
        $this->article_info = $this->article->get($this->article_id);
        if (!$this->article_info) $this->notFound();
    }

    protected function getTitle()
    {
        return $this->article_info["title"];
    }

    protected function getDescription()
    {
        return $this->article_info["meta_desc"];
    }

    protected function getKeyWords()
    {
        return $this->article_info["meta_key"];
    }

    protected function getMiddle()
    {
        return $this->getArticle();
    }

    private function getArticle()
    {
        $sr["title"] = $this->article_info["title"];
        $sr["full_text"] = $this->article_info["full_text"];
        $sr["date"] = $this->formatDate($this->article_info["date"]);
        return $this->getReplaceTemplate($sr, "article");
    }
}
