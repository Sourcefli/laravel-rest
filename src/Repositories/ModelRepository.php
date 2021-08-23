<?php

namespace Sourcefli\LaravelRest\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class ModelRepository implements ModelRepositoryContract
{
    /**
     * @return Collection
     */
    public function all(): Collection
    {
        // TODO: Implement all() method.
    }

    /**
     * @param string|int $id
     * @return Model|null
     */
    public function findById($id): ?Model
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param $id
     * @return Model
     */
    public function findOrFailById($id): Model
    {
        // TODO: Implement findOrFailById() method.
    }

    /**
     * @param FormRequest $request
     * @param $id
     * @return Model
     */
    public function update(FormRequest $request, $id): Model
    {
        // TODO: Implement update() method.
    }

    /**
     * @param FormRequest $request
     * @return Model
     */
    public function save(FormRequest $request): Model
    {
        // TODO: Implement save() method.
    }

    /**
     * @param $id
     * @return Model
     */
    public function delete($id): Model
    {
        // TODO: Implement delete() method.
    }
}
