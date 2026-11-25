<?php

require_once "config_class.php";
require_once "article_class.php";
require_once "section_class.php";
require_once "user_class.php";
require_once "menu_class.php";
require_once "banner_class.php";
require_once "message_class.php";

abstract class Modules
{
    protected $config;
    protected $article;
    protected $section;
    protected $user;
    protected $menu;
    protected $banner;
    protected $message;
    protected $data;

    public function __construct($db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->config = new Config();
        $this->article = new Article($db);
        $this->section = new Section($db);
        $this->user = new User($db);
        $this->menu = new Menu($db);
        $this->banner = new Banner($db);
        $this->message = new Message();
        $this->data = $this->secureData($_GET);
    }

    public function getContent()
    {
        $sr["title"] = $this->getTitle();
        $sr["meta_desc"] = $this->getDescription();
        $sr["meta_key"] = $this->getKeyWords();
        $sr["menu"] = $this->getMenu();
        $sr["auth_user"] = $this->getAuthUser();
        $sr["banners"] = $this->getBanners();
        $sr["top"] = $this->getTop();
        $sr["middle"] = $this->getMiddle();
        $sr["bottom"] = $this->getBottom();
        return $this->getReplaceTemplate($sr, "main");
    }

    abstract protected function getTitle();
    abstract protected function getDescription();
    abstract protected function getKeyWords();
    abstract protected function getMiddle();

    protected function getMenu()
    {
        // пункти меню беруться з таблиці menu й виводяться через шаблон menu_item.tpl
        $menu = $this->menu->getAll();
        $text = "";
        for ($i = 0; $i < count($menu); $i++) {
            $sr["title"] = $menu[$i]["title"];
            $sr["link"] = $menu[$i]["link"];
            $text .= $this->getReplaceTemplate($sr, "menu_item");
        }
        return $text;
    }

    protected function getAuthUser()
    {
        if (isset($_SESSION["auth_login"])) {
            $sr["login"] = htmlspecialchars($_SESSION["auth_login"], ENT_QUOTES, "UTF-8");
            return $this->getReplaceTemplate($sr, "user_panel");
        }

        $sr["message_auth"] = "";
        if (isset($_SESSION["error_auth"])) {
            $sr["message_auth"] = $this->message->getText($_SESSION["error_auth"]);
            unset($_SESSION["error_auth"]);
        }
        return $this->getReplaceTemplate($sr, "form_auth");
    }

    protected function getBanners()
    {
        $banners = $this->banner->getAll();
        $text = "";
        for ($i = 0; $i < count($banners); $i++) {
            $sr["code"] = $banners[$i]["code"];
            $text .= $this->getReplaceTemplate($sr, "banner");
        }
        return $text;
    }

    protected function getTop()
    {
        return "";
    }

    protected function getBottom()
    {
        return "";
    }

    protected function getBlogArticles($articles, $page)
    {
        // виводимо статті поточної сторінки (по count_blog штук)
        $text = "";
        $start = ($page - 1) * $this->config->count_blog;
        $end = (count($articles) > $start + $this->config->count_blog) ? $start + $this->config->count_blog : count($articles);
        for ($i = $start; $i < $end; $i++) {
            $sr["title"] = $articles[$i]["title"];
            $sr["intro_text"] = $articles[$i]["intro_text"];
            $sr["date"] = $this->formatDate($articles[$i]["date"]);
            $sr["link_article"] = $this->config->address . "?view=article&amp;id=" . $articles[$i]["id"];
            $text .= $this->getReplaceTemplate($sr, "article_intro");
        }
        return $text;
    }

    protected function formatDate($time)
    {
        return date("Y-m-d H:i:s", (int)$time);
    }

    protected function getMessage($message = "")
    {
        // системне повідомлення, збережене в сесії (наприклад, помилка реєстрації)
        if ($message == "") {
            $message = $_SESSION["message"] ?? "";
            unset($_SESSION["message"]);
        }
        if ($message == "") return "";
        $sr["message"] = $this->message->getText($message);
        return $this->getReplaceTemplate($sr, "message_string");
    }

    protected function getPagination($count, $count_on_page, $link)
    {
        // нумерація сторінок: 1, 2, 3 ... з посиланнями
        $count_pages = (int)ceil($count / $count_on_page);
        if ($count_pages <= 1) return "";

        $sr["number"] = 1;
        $sr["link"] = $link;
        $pages = $this->getReplaceTemplate($sr, "number_page");
        $sym = (strpos($link, "?") !== false) ? "&amp;" : "?";
        for ($i = 2; $i <= $count_pages; $i++) {
            $sr["number"] = $i;
            $sr["link"] = $link . $sym . "page=" . $i;
            $pages .= $this->getReplaceTemplate($sr, "number_page");
        }
        $els["number_pages"] = $pages;
        return $this->getReplaceTemplate($els, "pagination");
    }

    private function secureData($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) $data[$key] = $this->secureData($value);
            else $data[$key] = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
        }
        return $data;
    }

    protected function getTemplate($name)
    {
        $text = file_get_contents($this->config->dir_temp . $name . ".tpl");
        return str_replace("%address%", $this->config->address, $text);
    }

    protected function getReplaceTemplate($sr, $template)
    {
        return $this->getReplaceContent($sr, $this->getTemplate($template));
    }

    private function getReplaceContent($sr, $content)
    {
        $search = array();
        $replace = array();
        $i = 0;
        foreach ($sr as $key => $value) {
            $search[$i] = "%$key%";
            $replace[$i] = $value;
            $i++;
        }
        return str_replace($search, $replace, $content);
    }

    protected function redirect($link)
    {
        header("Location: $link");
        exit;
    }

    protected function notFound()
    {
        $this->redirect($this->config->address . "?view=notfound");
    }
}
