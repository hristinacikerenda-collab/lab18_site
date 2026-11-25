<?php

require_once "shablon_class.php";

class FrontPageContent extends Modules
{
    private $articles;
    private $page;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->articles = $this->article->getAllSortDate();
        $this->page = isset($this->data["page"]) ? (int)$this->data["page"] : 1;
        if ($this->page <= 0) $this->notFound();
    }

    protected function getTitle()
    {
        if ($this->page > 1) return "Довідник по PHP - Сторінка " . $this->page;
        else return "Довідник по PHP";
    }

    protected function getDescription()
    {
        return "Довідник PHP функцій";
    }

    protected function getKeyWords()
    {
        return "довідник PHP, довідник PHP функцій";
    }

    protected function getTop()
    {
        return $this->getTemplate("main_article");
    }

    protected function getMiddle()
    {
        return $this->getBlogArticles($this->articles, $this->page);
    }

    protected function getBottom()
    {
        return $this->getPagination(count($this->articles), $this->config->count_blog, $this->config->address);
    }
}
