<?php

class DBConn {

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "ereserv";
    private $db;
    private $table;


    public function __construct($table = "") {
        $this->table = $table; // on inittialise la valeur de la table
        try {
            // $this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function setTable($table) {
        $this->table = $table;
    }

    public function db() {
        return $this->db;
    }
    
    private function validateData($data) {
        // Implement validation logic here
        // Example: Check for data types, lengths, etc.
        // Return true if valid, otherwise false
        return true;
    }

    private function bindParams($stmt, $params) {
        foreach ($params as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue(':'.$key, $value, PDO::PARAM_INT);
            } else if (is_bool($value)) {
                $stmt->bindValue(':'.$key, $value, PDO::PARAM_BOOL);
            } else {
                $stmt->bindValue(':'.$key, $value, PDO::PARAM_STR);
            }
        }
    }

    public function create($data) {
        $columns = implode(', ', array_keys($data));
        // $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);

        try {
            $this->bindParams($stmt, $data);
            if ($stmt->execute()) {
                $id = $this->db->lastInsertId();
                return (int) $id; // à ce niveau on retourne l'id, car elle ne vaudra jamais 0 et faux
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Update Error: " . $e->getMessage();
            // Log::error("Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        $setClause = "";
        foreach ($data as $column => $value) {
            $setClause .= "$column = :$column, ";
        }
        $setClause = rtrim($setClause, ', ');
        $data["id"] = $id;

        $sql = "UPDATE $this->table SET $setClause WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        try {
            $this->bindParams($stmt, $data);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Update Error: " . $e->getMessage();
            // Log::error("Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        try {
            $this->bindParams($stmt, array("id" => $id));
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Delete Error: " . $e->getMessage();
            // Log::error("Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function get($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $this->bindParams($stmt, array("id" => $id));
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : null;
    }

    public function all() {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    // au niveau du selectWhere, on retourne un tableau de données
    public function where($attr, $op, $val) {
        if (!in_array($op, array('=', '!=', '<', '>', '<=', '>=', 'LIKE')))
            return [];
        $sql = "SELECT * FROM $this->table WHERE $attr $op :val";
        $stmt = $this->db->prepare($sql);
        $this->bindParams($stmt, array("val" => $val));
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function whereAll($conditions) {
        $whereClauses = array();
        $params = array();

        foreach ($conditions as $condition) {
            list($attr, $op, $val) = $condition;
            if (!in_array($op, array('=', '!=', '<', '>', '<=', '>=', 'LIKE')))
                return [];
            $whereClauses[] = "$attr $op :$attr";
            $params["$attr"] = $val;
        }

        $whereClause = implode(' AND ', $whereClauses);

        $sql = "SELECT * FROM $this->table WHERE $whereClause";
        $stmt = $this->db->prepare($sql);
        $this->bindParams($stmt, $params);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function closeConnection() {
        $this->db = null;
    }

    public function __destruct(){
        $this->closeConnection();
    }

}