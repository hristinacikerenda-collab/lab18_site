<?php

require_once "config_class.php";
require_once "user_class.php";
require_once "database_class.php";

class Manage
{
    private $config;
    private $user;
    private $data;
    private $db;

    public function __construct($db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->config = new Config();
        $this->user = new User($db);
        $this->data = $this->secureData(array_merge($_POST, $_GET));
        $this->db = $db;
    }

    private function secureData($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) $data[$key] = $this->secureData($value);
            else $data[$key] = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
        }
        return $data;
    }

    public function redirect($link)
    {
        header("Location: $link");
        exit;
    }

    // реєстрація нового користувача
    public function regUser()
    {
        $link_reg = $this->config->address . "?view=reg";
        $captcha = $this->data["captcha"] ?? "";
        $login = $this->data["login"] ?? "";
        $_SESSION["login"] = $login; // запам'ятовуємо логін, щоб підставити у форму

        // 1. перевірка капчі
        $rand = $_SESSION["rand"] ?? "";
        unset($_SESSION["rand"]);
        if ($rand === "" || (string)$rand !== (string)$captcha) {
            return $this->returnMessage("ERROR_CAPTCHA", $link_reg);
        }

        // 2. перевірка логіна
        if (!$this->user->isValidLogin($login)) return $this->returnMessage("INVALID_LOGIN", $link_reg);
        if ($this->user->isExistsUser($login)) return $this->returnMessage("EXISTS_LOGIN", $link_reg);

        // 3. перевірка пароля
        $password = $this->data["password"] ?? "";
        if ($password === "") return $this->returnMessage("EMPTY_PASSWORD", $link_reg);
        $password = $this->hashPassword($password);

        // 4. додаємо користувача в БД
        $result = $this->user->addUser($login, $password, time());
        if ($result) {
            unset($_SESSION["login"]);
            return $this->returnPageMessage("SUCCESS_REG", $this->config->address . "?view=message");
        }
        return $this->unknownError($link_reg);
    }

    // вхід на сайт
    public function login()
    {
        $r = $this->config->address;
        $login = $this->data["login"] ?? "";
        $password = $this->hashPassword($this->data["password"] ?? "");
        if ($this->user->checkUser($login, $password)) {
            $_SESSION["auth_login"] = $login;
            unset($_SESSION["error_auth"]);
        } else {
            $_SESSION["error_auth"] = "AUTH_ERROR";
        }
        return $r;
    }

    public function logout()
    {
        unset($_SESSION["auth_login"]);
        return $this->config->address;
    }

    private function hashPassword($password)
    {
        return md5($password . $this->config->secret);
    }

    private function unknownError($r)
    {
        return $this->returnMessage("UNKNOWN_ERROR", $r);
    }

    private function returnMessage($message, $r)
    {
        $_SESSION["message"] = $message;
        return $r;
    }

    private function returnPageMessage($message, $r)
    {
        $_SESSION["page_message"] = $message;
        return $r;
    }
}
