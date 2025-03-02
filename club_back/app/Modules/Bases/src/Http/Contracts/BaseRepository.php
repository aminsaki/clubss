<?php

namespace holoo\modules\Bases\Http\Contracts;

use Illuminate\Http\JsonResponse;

abstract class BaseRepository implements BaseRepositoryInterface
{
    abstract public function model(): mixed;

    protected mixed $model;

    public function __construct()
    {
        $this->model = app($this->model());
    }

    public function all()
    {
        return $this->model->all();
    }
    /**
     * @return JsonResponse
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function delete($id)
    {
        return $this->model->where(['id' => $id])->delete();
    }

    public function update(array $where, array $data)
    {
        return $this->model->where($where)->update($data);
    }

    public function paginates($pages)
    {
        return $this->model::orderBy('id', 'desc')->paginate($pages);
    }

    public function withAndPaginate($model, $pages)
    {
        return $this->model->with($model)->orderBy('id', 'desc')->paginate($pages);
    }

    public function where(array $where)
    {
        return $this->model->where($where)->get();
    }

    public function  firstWhereModle(?array $where = null, ?string $model = null)
    {
        return match (true) {
            !empty($where) && $model => $this->model->with($model)->where($where)->first(),
            !empty($where) => $this->model->where($where)->first(),
            $model => $this->model->with($model)->first(),
            default => $this->model->first(),
        };
    }
    public function  firstRow(?array $where = null, ?string $model = null)
    {
        return $this->model->first();
    }
}
