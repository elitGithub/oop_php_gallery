<?php


namespace Gallery;

use PDO;

require_once 'config.inc.php';

class Database
{
    /**
     * @var
     */
    protected $db;
    protected $stmt;

    /**
     * Database constructor.
     */
    public function __construct() {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    }

    public function query($query) {
        $this->stmt = $this->db->prepare($query);
    }

    /**
     * @param $param
     * @param $value
     * @param null $type
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
            $this->stmt->bindValue($param, $value, $type);
        }
    }

    /**
     * Execute a prepared query
     */
    public function execute() {
        $this->stmt->execute();
    }

    /**
     * @return mixed
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
