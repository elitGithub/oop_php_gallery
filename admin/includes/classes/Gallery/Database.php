<?php


namespace Gallery;

use PDO;


abstract class Database {
    /**
     * @var PDO
     */
    protected PDO $db;
    protected $stmt;

    /**
     * @var string
     */
    protected string $table;

    /**
     * @var string
     */
    protected string $idField = 'id';

    /**
     * @var string
     */
    protected string $createdAtColumn = 'created_at';
    protected string $updatedAtColumn = 'updated_at';
    protected array $fillables = [];

    public array $columnFields = [];
    public $entityDataColumns;
    public $id;

    /**
     * Database constructor.
     */
    public function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $this->db = new PDO($dsn, DB_USER, DB_PASS, [PDO::MYSQL_ATTR_FOUND_ROWS => true, PDO::ATTR_EMULATE_PREPARES => false]);
        $this->entityDataColumns = $this->getSchemaColumns();
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
    public function lastInsertId(): string {
        return $this->db->lastInsertId();
    }


    /**
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function findAll($limit = 1000, $offset = 0) {
        $query = "SELECT * FROM `{$this->table}` LIMIT {$offset}, {$limit};";
        $this->query($query);

        return $this->resultSet();
    }

    public function singleResult() {
        $this->execute();

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

        return $this->singleResult();
    }

    /**
     * @param $id
     * @param array $fields
     */
    public function updateOne($id, $fields = []) {
        foreach ($fields as $fieldName => $fieldValue) {
            $query = "UPDATE `{$this->table}` SET `{$fieldName}` = :{$fieldName} WHERE `{$this->idField}` = {$id};";
            $this->query($query);
            $this->bind(":{$fieldName}", $fieldValue);
            $this->execute();
        }
    }

    public function countAffectedRows() {
        return $this->stmt->rowCount();
    }


    /**
     * @param array $data
     */
    public function insert(array $data) {
        $bindAbles = static::createBindAbles($this->fillables);
        $query = "INSERT INTO {$this->table} (" . implode(', ', $this->fillables) . ") VALUES ({$bindAbles})";
        $this->query($query);
        foreach ($data as $columnName => $columnValue) {
            $this->bind(":{$columnName}", $columnValue);
        }
        $this->execute();
    }


    /**
     * @return mixed
     */
    public function getSchemaColumns(): array {
        $query = "SELECT * FROM `{$this->table}` LIMIT 0";
        $this->query($query);
        $this->execute();
        for ($i = 0; $i < $this->stmt->columnCount(); $i++) {
            $colData = $this->stmt->getColumnMeta($i);
            $columns[] = $colData['name'];
        }

        return $columns ?? [];
    }

    /**
     * @param array $columnNames
     * @return string
     */
    public static function createBindAbles(array $columnNames): string {
        $bindableAttr = [];
        foreach ($columnNames as $name) {
            $bindableAttr[] = ":{$name}";
        }

        return implode(', ', $bindableAttr);
    }

    /**
     * @return mixed
     */
    public function retrieveError() {
        return $this->stmt->errorInfo();
    }

    public function deleteOne($id) {
        $query = "DELETE FROM `{$this->table}` WHERE `{$this->idField}` = :id;";
        $this->query($query);
        $this->bind(":{$this->idField}", $id);
        $this->execute();
    }

    /**
     * @param array $input
     * @return array
     */
    public function flattenArray(array $input): array {
        if (!is_array($input) || empty($input)) {
            return $input;
        }
        foreach ($input as $value) {
            if (is_array($value)) {
                $this->flattenArray($value);
            }
            $output[] = $value;
        }

        return $output ?? [];
    }

    public function retrieveEntityInfo(): void {
        if ($this->id) {
            foreach ($this->findOne($this->id) as $column => $value) {
                $this->assignObjectVars($column, $value);
                $this->columnFields[$column] = $value;
            }
        } else {
            foreach ($this->entityDataColumns as $column) {
                $this->columnFields[$column] = '';
            }
        }
    }

    /**
     * @param $column
     * @param $value
     */
    protected function assignObjectVars($column, $value): void {
        $this->{$column} = $value;
    }

    public function save() {
        foreach ($this->columnFields as $columnField => $value) {
            if (!in_array($columnField, array_intersect(array_keys($this->columnFields), $this->fillables))) {
                unset($this->columnFields[$columnField]);
            }
        }
        if ($this->id) {
            $this->updateOne($this->id, $this->columnFields);
        } else {
            $this->insert($this->columnFields);
        }
    }

    public function count() {
        $query = "SELECT COUNT(*) AS totalRecords FROM `{$this->table}`;";
        $this->query($query);

        return $this->singleResult();
    }
}