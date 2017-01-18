<?php

abstract class BaseDataMapper {

    protected $adapter;
    protected $entityTable;
    protected $builder;

    public function __construct(Database $adapter = null) {
        if ($adapter == null)
            $this->adapter = new Database();
        else
            $this->adapter = $adapter;
        $this->builder = new Builder;
    }

    public function getAdapter() {
        return $this->adapter;
    }

    public function findBy(array $conditions) {
        $this->adapter->select($this->entityTable, $conditions);

        if (!$row = $this->adapter->fetch()) {
            return null;
        }
        return $this->createEntity($row);
    }

    public function findFirst(array $conditions = array()) {
        $this->adapter->select($this->entityTable, $conditions);

        if (!$row = $this->adapter->fetch()) {
            return null;
        }
        return $this->createEntity($row);
    }

    public function findSum($sum_field, array $conditions) {
        $this->adapter->select($this->entityTable, $conditions);

        if (!$row = $this->adapter->fetch()) {
            return null;
        }
        return $this->createEntity($row);
    }

    public function findAll(array $conditions = array()) {
        $entities = array();
        $this->adapter->select($this->entityTable, $conditions);
        $rows = $this->adapter->fetchAll();
        if ($rows) {
            foreach ($rows as $row) {
                $entities[] = $this->createEntity($row);
            }
        }
        return $entities;
    }

    public function findWithRawQuery($query) {
        $entities = array();
        $this->adapter->rawQuery($query);
        $rows = $this->adapter->fetchAll();
        return $rows;
    }

    public function findObjectsWithRawQuery($query) {
        $entities = array();
        $this->adapter->rawQuery($query);
        $rows = $this->adapter->fetchAll();

        foreach ($rows as $row) {
            $entities[] = $this->createEntity($row);
        }
        return $entities;
    }

    // Create an entity (implementation delegated to concrete mappers)
    abstract protected function createEntity(array $row);
}

