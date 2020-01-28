<?php


namespace App\Repository;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class BaseRepository implements BaseRepositoryInterface
{
    protected $modelObj;

    public function __construct(Model $model)
    {
        $this->modelObj = $model;
    }

    public function getQuery()
    {
        return $this->modelObj->query();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        try {
            return $this->getQuery()->orderBy('created_at')->paginate(10);
        } catch (\Exception $exception){
            return Response::error($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            return $this->getQuery()->whereId($id)->first();
        } catch (\Exception $exception){
            return Response::error($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public function store(array $data)
    {
        try {
            return $this->getQuery()->create($data);
        } catch (\Exception $exception){
            return ResponseAlias::error($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        try {
            return tap($this->getQuery()->find($id))->update($data);
        } catch (\Exception $exception) {
            return Response::error($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return boolean
     */
    public function destroy($id)
    {
        try {
            return $this->getQuery()->find($id)->delete();
        } catch (\Exception $exception){
            return Response::error($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @param $column
     * @param $value
     * @return bool
     */
    public function exists($column, $value)
    {
        return $this->getQuery()->where($column, $value)->exists();
    }

    /**
     * @param $column
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function findWith($column, $value)
    {
        return $this->getQuery()->where($column, $value)->first();
    }

    public function find($id)
    {
        return $this->getQuery()->find($id);
    }
}
