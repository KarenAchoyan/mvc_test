<?php

namespace models;

use components\App;
use components\DB;
use components\Query;
use PDO;

class Model
{
    protected string $table;

    protected array $attributes;

    protected Query $query;

    public function __construct()
    {
        $this->attributes = [];
        $this->query = new Query;
    }

    public function getAttribute(string $name): string
    {
        return $this->attributes[$name];
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function hasAttributes(): bool
    {
        return (bool) $this->getAttributes();
    }

    public function setAttribute(string $name, $value): self
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function fill(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function save(): Model
    {
        $id = $this->query->insert($this->table, $this->attributes);
        return $this->setAttribute('id', $id);
    }

    public function select($attributes = '*'): Model
    {
        $this->query->select($this->table, $attributes);
        return $this;
    }

    public function join(string $table, string $statement): Model
    {
        $this->query->join($table, $statement);
        return $this;
    }

    public function where(string $key, string $operand, $value): Model
    {
        $this->query->where($key, $operand, $value);
        return $this;
    }

    public function orderBy(string $column, string $direction): Model
    {
        $this->query->orderBy($column, $direction);
        return $this;
    }

    public function update(): bool
    {
        return $this->query->update($this->table, $this->attributes);
    }

    public function limitOffset(int $limit, int $offset)
    {
        $this->query->limitOffset($limit, $offset);
        return $this;
    }

    public function get(): array
    {
        $modelsData = $this->query->exec();
        return array_map(fn($data) => (new Model())->fill($data), $modelsData);
    }

    public function first()
    {
        $modelsData = $this->query->exec();
        return isset($modelsData[0]) ? $this->fill($modelsData[0]) : null;
    }
}