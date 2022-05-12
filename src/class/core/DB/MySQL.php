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

        return $this;
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
}
