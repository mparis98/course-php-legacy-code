<?php
declare(strict_types=1);

namespace Model;

use Core\BaseSQL;
use Core\Routing;

class UsersRepository
{
    private $pdo;
    private $table;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->table = get_called_class();
    }

    public function getOneBy(array $where, bool $object = false): ?array
    {
        $sqlWhere = [];
        foreach ($where as $key => $value) {
            $sqlWhere[] = $key . '=:' . $key;
        }
        $sql = ' SELECT * FROM ' . $this->table . ' WHERE  ' . implode(' AND ', $sqlWhere) . ';';
        $query = $this->pdo->prepare($sql);

        if ($object) {
            $query->setFetchMode(\PDO::FETCH_INTO, $this);
        } else {
            $query->setFetchMode(\PDO::FETCH_ASSOC);
        }

        try {
            $query->execute($where);
            return $query->fetch();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function save(): void
    {
        $dataObject = get_object_vars($this);
        $dataChild = array_diff_key($dataObject, get_class_vars(get_class()));

        if (is_null($dataChild['id'])) {
            $sql = 'INSERT INTO ' . $this->table . ' ( ' .
                implode(',', array_keys($dataChild)) . ') VALUES ( :' .
                implode(',:', array_keys($dataChild)) . ')';

            $query = $this->pdo->prepare($sql);
            $query->execute($dataChild);
        } else {
            $sqlUpdate = [];
            foreach ($dataChild as $key => $value) {
                if ('id' != $key) {
                    $sqlUpdate[] = $key . '=:' . $key;
                }
            }

            $sql = 'UPDATE ' . $this->table . ' SET ' . implode(',', $sqlUpdate) . ' WHERE id=:id';

            $query = $this->pdo->prepare($sql);
            $query->execute($dataChild);
        }
    }
}