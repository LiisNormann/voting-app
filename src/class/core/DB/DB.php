<?php

namespace core\DB;

use core\DB\Exception\DBException;

/**
 * andmebaasi ühenduse loomiseks ja andmebaasiga suhtlemiseks
 * @author Liis Normann
 */
class DB {
    /**
     * database name
     * @var mixed
     */
    protected $db;

    /**
     * database host uri
     * @var string
     */
    protected $host;

    /**
     * database name
     * @var string
     */
    protected $name;

    /**
     * database username
     * @var string
     */
    protected $user;

    /**
     * database password
     * @var string
     */
    protected $pass;

    /**
     * connection state
     * @var bool
     */
    protected $connected;

    /**
     * construct the database object
     * @param string $host
     * @param string $name
     * @param string $user
     * @param string $pass
     */
    public function __construct(string $host, string $name, string $user, string $pass = "") {
        echo "andmebaasi ühenduse loomine";
        $this->host = $host;
        $this->name = $name;
        $this->user = $user;
        $this->pass = $pass;

        $this->connect();
    }

    /**
     * overridden by subclasses
     * @return void
     */
    protected function connect() {

    }

    /**
     * throw an error
     * @param $message
     * @throws DBException
     */
    protected function my_die($message) {
        throw new DBException($message);
    }

    protected function isConnected() : bool {
        return $this->connected;
    }

    protected function setConnected($connected) : self {
        $this->connected = $connected;

        return $this;
    }
}


