<?php

namespace App\Table;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use stdClass;

/**
 * Table Data Mapper.
 *
 * A layer of Mappers that moves data between objects and a database
 * while keeping them independent of each other and the mapper itself.
 */
abstract class AbstractTable implements TableInterface
{
    /**
     * Database connection.
     *
     * @var Connection
     */
    protected $db;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = '';

    /**
     * Constructor.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Return the table name.
     *
     * @return string The table name
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @return string the row ID of the last row that was inserted into the database
     */
    public function lastInsertId(): string
    {
        return $this->db->getPdo()->lastInsertId();
    }

    /**
     * Fetch row by id.
     *
     * @param int|string $id The ID
     *
     * @return stdClass|null The row
     */
    protected function fetchById($id)
    {
        return $this->newQuery()->where('id', '=', $id)->first();
    }

    /**
     * Return a new Query Builder instance.
     *
     * @return Builder The Query Builder
     */
    protected function newQuery(): Builder
    {
        return $this->db->table($this->table);
    }

    /**
     * Fetch all rows.
     *
     * @return Collection The rows
     */
    protected function fetchAll()
    {
        return $this->newQuery()->get();
    }
}
