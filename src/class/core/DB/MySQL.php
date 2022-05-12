<?php

namespace core\DB;

use core\DB\Exception\DBException;

class MySQL extends DB {
    /**
     * @return self
     * @throws DBException
     */
    public function connect() : self {
        global $DB_LOG;

        if(!$this->host)
            throw new DBException("Cannot connect to database, Missing database host!");

        if(!$this->name)
            throw new DBException("Cannot connect to database, Missing database name!");

        if(!$this->user)
            throw new DBException("Cannot connect to database, Missing database username!");

        //current time in microseconds as a floating point
        $t1 = microtime(true);

        $this->db = mysqli_connect($this->host, $this->user, $this->pass)
            or $this->my_die("Unable to connect to database: " . mysqli_connect_error());
        $this->setConnected(true);
        mysqli_select_db($this->db, $this->name) or $this->my_die("Unknown database: {$this->name}");
        $this->db_sql("set names 'utf8'");
        mysqli_autocommit($this->db, false);

        $DB_LOG[] = "connect time: " . (microtime(true) - $t1);
        $this->begin_transaction();

        return $this;
    }

    public function disconnect() : void {
        if($this->isConnected()) {
            $this->commit(false);
            mysqli_close($this->db);
            $this->connected = false;
        }
    }

    /**
     * @param string $query
     * @param int $from
     * @param int|null $count
     * @return mixed[]
     */
    public function query(string $query, int $from = 1, int $count = null) : array {
        $result = $this->db_sql($query);

        $data = [];
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = $row;
        }
        mysqli_free_result($result);

        return $data;
    }

    public function insert(string $table, array $insert) {
        $sql = "INSERT INTO $table";

        $i = $j = 0;
        $into = "";
        $values = " VALUES ";
        foreach ($insert as $k => $v) {
            if(is_array($v)) {
                $j = 0;
                $i == 0 ? ($comma2 = "") : ($comma2 = ", ");
                $values .= $comma2;
                foreach ($v as $k2 => $v2) {
                    $j == 0 ? ($comma = "(") : ($comma = ", ");
                    if($i == 0)
                        $into .= $comma . $k2;

                    $values .= $comma . $v2;
                    $j++;
                }
                if($i == 0)
                    $into .= ") ";

                $values .= ")";
            } else {
                 $i == 0 ? ($comma = "(") : ($comma = ", ");
                 $into .= $comma . $k;
                 $values .= $comma . $v;
            }
            $i++;
        }

        if(!$j) {
            $into .= ") ";
            $values .= ")";
        }
        $sql .= $into . $values;

        return $this->db_sql($sql);
    }

    public function update(string $table, array $set, string $where = "") {
        $sql = "UPDATE $table SET ";
        $i = 0;
        foreach ($set as $k => $v) {
            $i == 0 ? ($comma = "") : ($comma = ", ");
            $sql .= $comma . $k . "=" . $v;
            $i++;
        }
        $where = $where ? " WHERE $where" : "";
        $sql .= $where;

        return $this->db_sql($sql);
    }

    public function delete(string $table, string $where) {
        $where = $where ? " WHERE $where" : "";

        return $this->db_sql("DELETE FROM $table $where");
    }

    public function db_sql(string $query) {
        global $DB_LOG;

        if(!$this->isConnected())
            $this->connect();

        $t1 = microtime(true);
        $result = @mysqli_query($this->db, $query);
        if($result === false) {
            $this->my_die(sprintf("Error code: %s - %s : %s", mysqli_errno($this->db), mysqli_error($this->db), $query));
        }

        $DB_LOG[] = sprintf("%s time: %s", $query, microtime(true) - $t1);

        return $result;
    }

    public function begin_transaction() : void {
        $this->db_sql("START TRANSACTION");
    }

    public function commit(bool $startNew = false) : void {
        if($this->isConnected()) {
            mysqli_commit($this->db);
            if($startNew)
                $this->begin_transaction();
        }
    }

    public function rollback(bool $startNew = false) : void {
        if($this->isConnected()) {
            mysqli_rollback($this->db);
            if($startNew)
                $this->begin_transaction();
        }
    }

    public function last_id() {
        return mysqli_insert_id($this->db);
    }
}
