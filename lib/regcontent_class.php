<?php

require_once "shablon_class.php";

class RegContent extends Modules
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    protected function getTitle()
    {
        return "Форма реєстрації на сайті";
    }

    protected function getDescription()
    {
        return "Форма реєстрації користувача на сайті";
    }

    protected function getKeyWords()
    {
        return "реєстрація, реєстрація на сайті";
    }

    protected function getMiddle()
    {
        $sr["login"] = $_SESSION["login"] ?? "";
        $sr["message"] = $this->getMessage();
        return $this->getReplaceTemplate($sr, "form_reg");
    }
}
