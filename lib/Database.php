<?php

class Database {

    protected $db = null;
    protected $config = array();
    protected $statement;
    protected $fetchMode = \PDO::FETCH_ASSOC;

    public function __construct() {
        if ($this->db !== null) {
            return $this->db;
        }
        $config = Config::getConfig("db");
        $this->db = new PDO($config['dsn'], $config['username'], $config['password']);
        if (!$this->db) {
            $errors = $this->statement->errorInfo();
            print 'DB error: ' . $errors[2];
            die();
        }
        else
            return $this->db;
    }

    public function __destruct() {
        $this->db = null;
    }

    public function execute(array $parameters = array()) {
        $this->getStatement()->execute($parameters);
        if ($this->statement->errorCode() == 0) {
            return $this;
        } else {
            $errors = $this->statement->errorInfo();
            print 'DB error: ' . $errors[2] . '<br>';
            print_r($this->statement->queryString);
            die();
        }
    }

    public function getStatement() {
        if ($this->statement === null) {
            print "There is no PDOStatement object for use.";
            die();
        }
        return $this->statement;
    }

    public function prepare($sql, array $options = array()) {
        $this->statement = $this->db->prepare($sql, $options);
        return $this;
    }

    public function countAffectedRows() {
        return (int) $this->getStatement()->rowCount();
    }

    public function getLastInsertId($name = null) {
        return $this->db->lastInsertId($name);
    }

    public function fetch($fetchStyle = null, $cursorOrientation = null, $cursorOffset = null) {
        if ($fetchStyle === null) {
            $fetchStyle = $this->fetchMode;
        }
        return $this->getStatement()->fetch($fetchStyle, $cursorOrientation, $cursorOffset);
    }

    public function fetchAll($fetchStyle = null, $column = 0) {
        if ($fetchStyle === null) {
            $fetchStyle = $this->fetchMode;
        }
        return $fetchStyle === \PDO::FETCH_COLUMN ? $this->getStatement()->fetchAll($fetchStyle, $column) : $this->getStatement()->fetchAll($fetchStyle);
    }

    public function selectComplex($table, \Builder $builder = NULL) {
        $bindings = array();
        $where = " ";
        $sql = "SELECT * FROM " . $table;
        if ($builder != NULL) {
            $where = $builder->compile();
            $bindings = array_merge($builder->getBindings(), $bindings);
        }
        $sql = "SELECT * FROM " . $table . $where;
        $this->prepare($sql)->execute($bindings);
        return $this;
    }

    public function select($table, array $bind = array(), $boolOperator = "AND") {
        if ($bind) {
            $where = array();
            foreach ($bind as $col => $value) {
                unset($bind[$col]);
                $bind[":" . $col] = $value;
                $where[] = $col . " = :" . $col;
            }
        }
        $sql = "SELECT * FROM " . $table
                . (($bind) ? " WHERE "
                        . implode(" " . $boolOperator . " ", $where) : " ");
        $this->prepare($sql)->execute($bind);
        return $this;
    }

    public function insert($table, array $bind) {
        $cols = implode(", ", array_keys($bind));
        $values = implode(", :", array_keys($bind));
        foreach ($bind as $col => $value) {
            unset($bind[$col]);
            if (!isset($value))
                $value = null;
            $bind[":" . $col] = $value;
        }
        $sql = "INSERT INTO " . $table
                . " (" . $cols . ")  VALUES (:" . $values . ")";
        return (int) $this->prepare($sql)->execute($bind)->getLastInsertId();
    }

    public function insertMultiple($table, array $cols, array $values) {
        $colms = implode(", ", $cols);
        $bind = array();
        $result = array();
        $i = 0;
        foreach ($values as $person) {
            foreach ($cols as $col) {
                $bind[$i][":" . $col . $i] = $person[$col];
            }
            $result = array_merge($bind[$i], $result);
            $i++;
        }
        $sql = "INSERT INTO {$table} ( {$colms} ) VALUES " . self::joinValues($bind);
        return (int) $this->prepare($sql)->execute($result)->countAffectedRows();
    }

    private function joinValues($items) {
        $vals = array();
        foreach ($items as $value) {
            if (is_array($value)) {
                $str = "( ";
                $keys = array_keys($value);
                $str .= implode(", ", $keys);
                $str .= " )";
                $vals[] = $str;
            }
        }
        return implode(", ", $vals);
    }

    public function update($table, array $bind, $where = "") {
        $set = array();
        foreach ($bind as $col => $value) {
            unset($bind[$col]);
            $bind[":" . $col] = $value;
            $set[] = $col . " = :" . $col;
        }
        $sql = "UPDATE " . $table . " SET " . implode(", ", $set)
                . (($where) ? " WHERE " . $where : " ");
        return (int) $this->prepare($sql)->execute($bind)->countAffectedRows();
    }

// incoming array( 'id' => x, 'time_fk' => xy, 'note' => 'notes are new', 'last_modified' =>
    public function upsert($table, $bind, $conditionkeys, $insert_keys, $update_keys) {
        $srcTable = "SRC";
        $cols = implode(", ", array_keys($bind));
        $values = implode(", :", array_keys($bind));
        $updateset = array();
        $insertval = array();
        $oncond = array();
        foreach ($bind as $col => $value) {
            unset($bind[$col]);
            $bind[":" . $col] = $value;
        }
        foreach ($insert_keys as $ikey) {
//          $bind[":insert{$ikey}"] = $bind[":{$ikey}"];
            $insertval[] = ":insert{$ikey}";
        }
        foreach ($update_keys as $ukey) {
//          $bind[":update{$ukey}"] = $bind[":{$ukey}"];
            $updateset[] = "{$ukey} = {$srcTable}.{$ukey}";
        }
        foreach ($conditionkeys as $ckey) {
            $oncond[] = "{$table}.{$ckey} = {$srcTable}.{$ckey}";
        }
        $sql = "MERGE INTO {$table} " .
                "USING (SELECT :{$values}) as {$srcTable} ( {$cols} ) " .
                "ON ( " . implode(" AND ", $oncond) . " ) " .
                "WHEN MATCHED THEN " .
                "UPDATE SET " . implode(',', $updateset) . " " .
                "WHEN NOT MATCHED THEN " .
                "INSERT (" . implode(',', $insert_keys) . ") " .
                "VALUES ( {$srcTable}." . implode(", {$srcTable}.", $insert_keys) . ");";
        return (int) $this->prepare($sql)->execute($bind)->countAffectedRows();
    }

    public function delete($table, $where = "") {
        $sql = "DELETE FROM " . $table . (($where) ? " WHERE " . $where : " ");
        return (int) $this->prepare($sql)->execute()->countAffectedRows();
    }

    public function deleteMultiple($table, Builder $blder) {
        $where = '';
        if (!is_null($blder)) {
            $where = $blder->compile();
        }
        $sql = "DELETE FROM " . $table . $where;
        return (int) $this->prepare($sql)->execute($blder->getBindings())->countAffectedRows();
    }

    public function rawQuery($query, array $params = array()) {
        return $this->prepare($query)->execute($params);
    }

}

?>
