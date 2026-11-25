<?php
require_once __DIR__ . "/config_class.php";

class DataBase
{
    private Config $config;
    private ?mysqli $mysqli = null;

    public function __construct()
    {
        $this->config = new Config();
        mysqli_report(MYSQLI_REPORT_OFF);
        $conn = @new mysqli(
            $this->config->host,
            $this->config->user,
            $this->config->password,
            $this->config->db
        );
        if ($conn->connect_error) {
            exit("Помилка підключення до бази даних: " . htmlspecialchars($conn->connect_error));
        }
        $conn->set_charset("utf8mb4");
        $this->mysqli = $conn;
    }

    private function getTable(string $table_name): string
    {
        return $this->config->db_prefix . $table_name;
    }

    private function escape($value): string
    {
        return $this->mysqli->real_escape_string((string)$value);
    }

    // вибірка: SELECT поля FROM таблиця [WHERE ...] [ORDER BY ...]
    public function select(string $table_name, array $fields, string $where = "", string $order = "", bool $up = true)
    {
        $sql = "SELECT " . implode(", ", $fields) . " FROM `" . $this->getTable($table_name) . "`";
        if ($where !== "") $sql .= " WHERE " . $where;
        if ($order !== "") $sql .= " ORDER BY `" . $order . "` " . ($up ? "ASC" : "DESC");

        $res = $this->mysqli->query($sql);
        if (!$res) return false;
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    private function query(string $sql): bool
    {
        return (bool)$this->mysqli->query($sql);
    }

    public function insert(string $table_name, array $new_values): bool
    {
        $fields = array();
        $values = array();
        foreach ($new_values as $field => $value) {
            $fields[] = "`" . $field . "`";
            $values[] = "'" . $this->escape($value) . "'";
        }
        return $this->query("INSERT INTO `" . $this->getTable($table_name) . "` (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ")");
    }

    public function updateOnID(string $table_name, int $id, array $upd_fields): bool
    {
        if (!$this->existsID($table_name, $id)) return false;
        $set = array();
        foreach ($upd_fields as $field => $value) {
            $set[] = "`" . $field . "` = '" . $this->escape($value) . "'";
        }
        return $this->query("UPDATE `" . $this->getTable($table_name) . "` SET " . implode(", ", $set) . " WHERE `id` = " . (int)$id);
    }

    public function setFieldOnID(string $table_name, int $id, string $field, $value): bool
    {
        return $this->updateOnID($table_name, $id, array($field => $value));
    }

    public function deleteOnID(string $table_name, int $id): bool
    {
        if (!$this->existsID($table_name, $id)) return false;
        return $this->query("DELETE FROM `" . $this->getTable($table_name) . "` WHERE `id` = " . (int)$id);
    }

    public function deleteAll(string $table_name): bool
    {
        return $this->query("DELETE FROM `" . $this->getTable($table_name) . "`");
    }

    public function getAll(string $table_name, string $order = "", bool $up = true)
    {
        return $this->select($table_name, array("*"), "", $order, $up);
    }

    // усі записи, у яких поле має задане значення (крок 1 у database_class)
    public function getAllOnField(string $table_name, string $field, $value, string $order = "", bool $up = true)
    {
        return $this->select($table_name, array("*"), "`" . $field . "` = '" . $this->escape($value) . "'", $order, $up);
    }

    // ID останнього вставленого запису (крок 1 у database_class)
    public function getLastID(string $table_name): int
    {
        $data = $this->select($table_name, array("MAX(`id`) AS max_id"));
        return $data ? (int)$data[0]["max_id"] : 0;
    }

    public function getElementOnID(string $table_name, $id)
    {
        if (!$this->existsID($table_name, $id)) return false;
        $data = $this->select($table_name, array("*"), "`id` = " . (int)$id);
        return $data ? $data[0] : false;
    }

    public function getField(string $table_name, string $field_out, string $field_in, $value_in)
    {
        $data = $this->select($table_name, array("`" . $field_out . "`"), "`" . $field_in . "` = '" . $this->escape($value_in) . "'");
        return $data ? $data[0][$field_out] : false;
    }

    public function getFieldOnID(string $table_name, $id, string $field)
    {
        if (!$this->existsID($table_name, $id)) return false;
        return $this->getField($table_name, $field, "id", $id);
    }

    public function getCount(string $table_name): int
    {
        $data = $this->select($table_name, array("COUNT(`id`) AS cnt"));
        return $data ? (int)$data[0]["cnt"] : 0;
    }

    public function getRandomElements(string $table_name, int $count)
    {
        $sql = "SELECT * FROM `" . $this->getTable($table_name) . "` ORDER BY RAND() LIMIT " . (int)$count;
        $res = $this->mysqli->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : false;
    }

    public function isExists(string $table_name, string $field, $value): bool
    {
        $data = $this->select($table_name, array("`id`"), "`" . $field . "` = '" . $this->escape($value) . "'");
        return $data && count($data) > 0;
    }

    // перевірка існування ідентифікатора в таблиці
    private function existsID(string $table_name, $id): bool
    {
        if (!preg_match("/^[1-9][0-9]*$/", (string)$id)) return false;
        $data = $this->select($table_name, array("`id`"), "`id` = " . (int)$id);
        return $data && count($data) > 0;
    }

    // ---------- пошук по сайту (крок 23) ----------
    public function search(string $table_name, string $words, array $fields)
    {
        $words = mb_strtolower(trim(strip_tags($words)));
        if ($words === "") return false;

        $arraywords = preg_split("/\s+/u", $words);

        // умова: будь-яке слово зустрічається в будь-якому з полів
        $conditions = array();
        foreach ($arraywords as $word) {
            $like = addcslashes($this->escape($word), "%_");
            foreach ($fields as $field) {
                $conditions[] = "`" . $field . "` LIKE '%" . $like . "%'";
            }
        }

        $results = $this->select($table_name, array("*"), implode(" OR ", $conditions));
        if (!$results) return false;

        $data = array();
        foreach ($results as $row) {
            $row["relevant"] = $this->getRelevantForSearch($row, $fields, $arraywords);
            $data[] = $row;
        }
        return $this->orderResultSearch($data, "relevant");
    }

    // релевантність = скільки разів слова з пошуку трапились у полях запису
    private function getRelevantForSearch(array $result, array $fields, array $arraywords): int
    {
        $relevant = 0;
        foreach ($fields as $field) {
            $text = mb_strtolower(strip_tags((string)$result[$field]));
            foreach ($arraywords as $word) {
                $relevant += mb_substr_count($text, $word);
            }
        }
        return $relevant;
    }

    // сортування за спаданням релевантності
    private function orderResultSearch(array $data, string $order): array
    {
        usort($data, function ($a, $b) use ($order) {
            return $b[$order] <=> $a[$order];
        });
        return $data;
    }

    public function __destruct()
    {
        if ($this->mysqli) $this->mysqli->close();
    }
}
