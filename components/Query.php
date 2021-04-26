<?php

namespace components;

use models\Model;
use PDO;

class Query
{
    protected PDO $connection;

    protected string $query;

    public function __construct()
    {
        $this->connection = (new DB(
            App::$configs
        ))->connect();
    }

    public function insert(string $table, array $attributes): int
    {
        $query = 'INSERT INTO ' . $table . ' ';
        $query .= '(' . $this->getAttributeKeysForPrepare($attributes) . ')';
        $query .= ' VALUES ';
        $query .= '(' . $this->getAttributeValuesForPrepare($attributes) . ')';

        foreach ($attributes as $attribute => $value) {
            unset($attributes[$attribute]);
            $attributes[":$attribute"] = htmlentities($value);
        }

        $this
            ->connection
            ->prepare($query)
            ->execute($attributes);

        return $this->connection->lastInsertId();
    }

    public function select(string $table, string $attributes = '*'): void
    {
        $this->query = 'SELECT ' . $attributes . ' FROM ' . $table;
    }

    public function join(string $table, string $statement): void 
    {
        $this->query .= " INNER JOIN $table ON $statement ";
    }

    public function where(string $key, string $operand, $value): void
    {
        $this->query .= " WHERE $key $operand '$value' ";
    }

    public function limitOffset(int $limit,int $offset): void
    {
        $this->query .= " LIMIT $limit, $offset";
    }

    public function orderBy(string $column, string $direction)
    {
        $this->query .= " ORDER BY $column $direction ";
    }

    public function update(string $table, array $attributes): bool
    {
        $string = '';
        
        foreach ($attributes as $attribute => $value) {
            $attributes[$attribute] = htmlentities($value);
            $string .= "$attribute = :$attribute, ";
        }

        $string = rtrim($string, ', ');
        $this->query = "UPDATE $table SET $string WHERE id = {$attributes['id']}";

        return $this
            ->connection
            ->prepare($this->query)
            ->execute($attributes);
    }

    private function getAttributeKeysForPrepare(array &$attributes): string
    {
        return implode(',', array_keys($attributes));
    }

    private function getAttributeValuesForPrepare(array $attributes): string
    {
        $values = array_keys($attributes);
        $values = array_map(fn($value) => ":$value", $values);
        return implode(',', $values);
    }

    public function exec(): array
    {
        $all = $this->connection->query($this->query)->fetchAll() ?? [];
        $modelsData = [];

        foreach ($all as $key => $value) {
            foreach ($value as $attribute => $v) {
                if (! is_int($attribute)) {
                    $modelsData[$key][$attribute] = $v;
                }
            }
        }

        return $modelsData;
    }
}