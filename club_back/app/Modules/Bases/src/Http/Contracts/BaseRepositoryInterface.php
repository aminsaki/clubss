<?php

namespace holoo\modules\Bases\Http\Contracts;

interface BaseRepositoryInterface
{
    public function find(int $id);

    public function create(array $data);

    public function delete($id);

    public function update(array $where, array $data);

    public function all();

    public function paginates($pages);

    public function withAndPaginate($model, $pages);

    public function where(array $where);

    public function firstWhereModle(?array $where = null , ?string $model = null);

    public function firstRow();
}
