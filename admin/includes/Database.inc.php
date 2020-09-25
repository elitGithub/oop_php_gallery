<?php


namespace Gallery;

use Cassandra\Column;
use PDO;

require_once 'config.inc.php';

class Database
{
    /**
     * @var
     */
    protected $db;
    protected $stmt;
    protected $table;
    protected $idField = 'id';
    protected $createdAt = 'created_at';
    protected $updatedAt = 'updated_at';

    /**
     * Database constructor.
     */
    public function __construct() {
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
        $this->db = new PDO($dsn, DB_USER, DB_PASS, [PDO::MYSQL_ATTR_FOUND_ROWS => true]);
    }

    /**
     * @param $query
     */
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

    /**
     * @return string
     */
    public function lastInsertId() {
        return $this->db->lastInsertId();
    }


    /**
     * @return mixed
     */
    public function findAll() {
        $query = "SELECT * FROM `{$this->table}`;";
        $this->query($query);
        return $this->resultSet();
    }

    public function singleResult() {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id) {
        $query = "SELECT * FROM `{$this->table}` WHERE `{$this->idField}` = :id;";
        $this->query($query);
        $this->bind(':id', $id);
        $this->execute();
        return $this->singleResult();
    }

    /**
     * @param $id
     * @param array $fields
     * @return mixed
     */
    public function updateOne($id, $fields = []) {
        foreach ($fields as $fieldName => $fieldValue) {
            $query = "UPDATE `{$this->table}` SET `{$fieldName}` = :{$fieldName} WHERE {$this->idField} = :id;";
            $this->query($query);
            $this->executeMany([
                ':id' => $id,
                ":{$fieldName}" => $fieldValue,
            ]);
        }
        return $this->stmt->affectedRows();
    }

    /**
     * @param array $data
     */
    public function executeMany(array $data) {
        $this->stmt->execute($data);
    }

    public function insert(array $data) {
        $columns = array_keys($data);
        $bindAbles = Database::createBindAbles($columns);
        $query = "INSERT INTO {$this->table} (".implode(', ', $columns).") VALUES ({$bindAbles})";
        $this->query($query);
        foreach ($data as $columnName => $columnValue) {
            $this->bind(":{$columnName}", $columnValue);
        }
        $this->execute();
    }


    public function getSchemaColumns()
    {
        $query = "SELECT * FROM {$this->table} LIMIT 0";
        $this->query($query);
        $this->execute();
        for($i = 0; $i < $this->stmt->columnCount(); $i++) {
            $colData = $this->stmt->getColumnMeta($i);
            if (!in_array('primary_key', $colData['flags']) && $colData['native_type' ] !== 'DATE') {
                $columns[] = $colData['name'];
            }
        }
        return $columns;
    }

    public static function createBindAbles(array $columnNames)
    {
        $bindAbles = [];
        foreach ($columnNames as $name) {
            $bindAbles[] = ":{$name}";
        }
        return implode(', ', $bindAbles);
    }

    public function retrieveError() {
        return $this->stmt->errorInfo();
    }
}