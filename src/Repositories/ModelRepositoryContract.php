<?php

namespace Sourcefli\LaravelRest\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

interface ModelRepositoryContract
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param $id
     * @return null|Model
     */
    public function findById($id): ?Model;

    /**
     * @param $id
     * @return Model
     */
    public function findOrFailById($id): Model;

    /**
     * @param FormRequest $request
     * @param $id
     * @return Model
     */
    public function update(FormRequest $request, $id): Model;

    /**
     * @param FormRequest $request
     * @return Model
     */
    public function save(FormRequest $request): Model;

    /**
     * @param $id
     * @return Model
     */
    public function delete($id): Model;
}
