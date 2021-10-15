<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Arr;

/**
 * App\Services\Getter
 *
 * @property \Illuminate\Database\Eloquent\Builder $query
 */
abstract class Getter
{
    protected $query;
    protected $isSearch = false;
    protected $queryAttributes = [];
    private $searchFilters = [];

    abstract function __construct();
    /*
    Пример, того что вы должны сделать, наследуясь от Getter
    function __construct()
    {
        $this->query = Dimension::query();
    }
    */

    final public function getQuery()
    {
        return $this->query;
    }

    public function select($columns = ['*'])
    {
        $this->query->select($columns);

        return $this;
    }

    public function setSearchParams($filters = [])
    {
        if (count($this->queryAttributes) && count($filters)) {
            $this->getQueryFilters($filters);
        } else {
            $this->searchFilters = $filters;
        }

        return $this;
    }

    public function getQueryFilters($filters)
    {
        foreach ($this->queryAttributes as $attribute) {
            if ($searchAttr = Arr::get($filters, $attribute)) {
                $this->searchFilters = array_merge($this->searchFilters, [$attribute => $searchAttr]);
            }
        }
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        $this->query->where($column, $operator, $value, $boolean);

        return $this;
    }

    public function search($search = null)
    {
        if (!$search && count($this->searchFilters)) {
            $search = $this->searchFilters;
        }

        if ($search && count($this->searchFilters)) {
            $search = is_string($search) ? json_decode($search, true) : $search;

            $search = array_merge($search, $this->searchFilters);
        }

        if (!$fields = is_string($search) ? json_decode($search, true) : $search) {
            return $this;
        }

        $this->buildQuery($this->query, $fields, true);

        return $this;
    }

    public function filter($search)
    {
        if (!$fields = json_decode($search, true)) {
            return $this;
        }

        $this->query->where(function(Builder $query) use ($fields) {
            $query->where(function (Builder $queryEmbedded) use ($fields) {
                $this->buildQuery($queryEmbedded, $fields);
            });
            $this->updateFilterQuery($query);
        });

        return $this;
    }

    public function findOrFail($id)
    {
        return $this->query->findOrFail($id);
    }

    private function buildQuery(Builder &$query, $fields, $isSearch = false)
    {
        foreach ($fields as $key => $value) {
            if ($value === "" || $value === null || $value === []) {
                continue;
            }

            if (is_array($value)) {
                if (empty(array_diff($value, array('', null))))
                    continue;
            }

            if (!$this->customSearch($query, $key, $value)) {
                $query->where($key, $value);
            }

            if ($isSearch)
                $this->isSearch = true;
        }

        return $query;
    }

    protected function updateFilterQuery(Builder &$query)
    {
    }

    protected function customSearch(Builder &$query, $key, $value)
    {
        $isApply = false;

        return $isApply;
    }

    final public function when($value, $callback, $default = null)
    {
        $this->query->when($value, $callback, $default);

        return $this;
    }

    final public function with($relations, $callback = null)
    {
        $this->query->with($relations, $callback);

        return $this;
    }

    final public function withTrashed($withTrashed = false)
    {
        if (gettype($withTrashed) == 'string') {
            $withTrashed = $withTrashed == 'true';
        }

        if ($withTrashed) {
            $this->query->withTrashed();
        } else {
            $this->query->withoutTrashed();
        }

        return $this;
    }

    final public function orderBy($column = null, $direction = null)
    {
        $column = $column ?? 'id';
        $direction = $direction ?? 'asc';

        if ($column && $direction) {
            $this->query->orderBy($column, $direction);
        }

        return $this;
    }

    final public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->query->paginate($perPage, $columns, $pageName, $page);
    }

    final public function get($columns = ['*'])
    {
        return $this->query->get($columns);
    }

    final public function withOnlyTrashed($withTrashed = false)
    {
        if ($withTrashed)
            $this->query->onlyTrashed();

        return $this;
    }
}
