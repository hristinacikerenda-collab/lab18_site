<?php

require_once "shablon_class.php";

class MessageContent extends Modules
{
    private $message_title;
    private $message_text;

    public function __construct($db)
    {
        parent::__construct($db);
        $name = $_SESSION["page_message"] ?? "";
        unset($_SESSION["page_message"]);
        if ($name === "") $this->notFound();
        $this->message_title = $this->message->getTitle($name);
        $this->message_text = $this->message->getText($name);
    }

    protected function getTitle()
    {
        return $this->message_title;
    }

    protected function getDescription()
    {
        return $this->message_text;
    }

    protected function getKeyWords()
    {
        return mb_strtolower($this->message_text);
    }

    protected function getMiddle()
    {
        $sr["title"] = $this->message_title;
        $sr["text"] = $this->message_text;
        return $this->getReplaceTemplate($sr, "message");
    }
}
