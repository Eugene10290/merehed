<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
abstract class BaseRepository
{
    /** @var array Aliases for fields */
    protected static $map = [];

    /** @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder $model Model Instance */
    private $model;

    /**
     * Gets a model class name
     *
     * @return string Model Class Name
     */
    abstract public function model(): string;

    /**
     * Returns all the records.
     *
     * @param array         $relations Model relations
     * @param string        $orderBy   Order by column name
     * @param string        $sorting   Order direction
     * @param int           $size      Count records per page
     * @param string[]      $columns   Columns to fetch
     *
     * @param callable|null $where
     * @param callable|null $when
     *
     * @return Collection|Model[]|LengthAwarePaginator Collection
     * models
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function all(
        array $relations = [],
        $orderBy = null,
        $sorting = null,
        int $size = null,
        array $columns = ['*'],
        callable $when = null
    ) {
        $query = $this->getModel()->with($relations);

        if (null !== $orderBy && null !== $sorting) {
            $query->orderBy($orderBy, $sorting);
        }

        $query->when(is_callable($when), $when);

        return ($size !== null) ? $query->paginate($size, $columns) : $query->get($columns);
    }

    /**
     * Makes a model object
     *
     * @return Model
     * @throws \InvalidArgumentException If model wasn't created
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function makeModel(): Model
    {
        $model = app()->make($this->model());
        if (! $model instanceof Model) {
            throw new \InvalidArgumentException(
                "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model"
            );
        }

        $this->setModel($model);

        return $model;
    }

    /**
     * BaseRepository constructor.
     *
     * @param Model $model Model instance
     *
     * @return \App\Repositories\BaseRepository|static Repository
     */
    public function setModel(Model $model): BaseRepository
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Gets a model instance
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed Model instance
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getModel()
    {
        if (null === $this->model) {
            $this->makeModel();
        }

        return $this->model;
    }

    /**
     * Gets query builder of the model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function newQuery()
    {
        return $this->getModel()->newQuery();
    }

    /**
     * Returns the count of all the records.
     *
     * @return int Count
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function count(): int
    {
        return $this->getModel()->count();
    }

    /**
     * Creates a record
     *
     * @param mixed[] $data Record data
     *
     * @return \Illuminate\Database\Eloquent\Model Created instance
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function create(array $data): Model
    {
        return $this->makeModel()->create($data);
    }

    /**
     * Updates a model
     *
     * @param string  $id         Model Id
     * @param mixed[] $attributes Model attributes
     *
     * @return bool True - successfully updated, otherwise - false
     * @throws \Exception On any error
     */
    public function update($id, $attributes): bool
    {
        $this->setModel($this->findOrFail($id));
        $this->getModel()->fill($attributes);

        return $this->getModel()->save();
    }

    /**
     * Removes a model or a list of models
     *
     * @param string|string[] $id Model Id(s)
     *
     * @return int Number of deleted records
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function destroy($id): int
    {
        return $this->getModel()->destroy($id);
    }

    /**
     * Finds(or fails) a model with a given id
     *
     * @param string $id Model Id
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function findOrFail($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * Find a record by an attribute.
     * Fails if no model is found.
     *
     * @param string $attribute Attribute name
     * @param string $value     Attribute value
     * @param array  $relations Relations
     *
     * @return \Illuminate\Database\Eloquent\Model|null Model
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function findBy($attribute, $value, $relations = null)
    {
        $query = $this->getModel()->where($attribute, $value);

        if ($relations && \is_array($relations)) {
            foreach ($relations as $relation) {
                $query->with($relation);
            }
        }

        return $query->first();
    }

    /**
     * Fills out an instance of the model with $attributes.
     *
     * @param mixed[] $attributes Attributes
     *
     * @return \Illuminate\Database\Eloquent\Model Model
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function fill($attributes): Model
    {
        return $this->getModel()->fill($attributes);
    }

    /**
     * @param $search
     * @param $data
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function firstOrCreate(array $search, array $data)
    {
        return $this->getModel()->firstOrCreate($search, $data);
    }

    /**
     * Finding by ids
     *
     * @param        $entity
     *
     *
     * @param        $ids
     * @param string $search
     *
     * @param string $searchKey
     *
     * @return mixed
     */
    public function findByIds($entity, $ids, string $search, string $searchKey)
    {
        return $entity->newQuery()->whereIn('id', $ids->toArray())->pluck($search, $searchKey);
    }
}
