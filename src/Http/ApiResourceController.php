<?php

namespace Sourcefli\LaravelRest\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class ApiResourceController extends Controller
{
    protected ModelRepository $repository;

    abstract public function getModel(): Model;

    /**
     * @return FormRequest
     */
    abstract public function getFormRequest(): FormRequest;

    /**
     * Resource Controller constructor
     */
    public function __construct()
    {
        $this->repository = app(ModelRespositoryContract::class);
    }

    /**
     * @return JsonResponse|Response
     */
    public function index()
    {
        return $this->toJsonSpec(
            $this->repository->all()
        );
    }

    /**
     * @param FormRequest $request
     * @return JsonResponse|Response
     */
    public function store(FormRequest $request)
    {
        return $this->toJsonSpec(
            $this->repository->save($request)
        );
    }

    /**
     * @param int $id
     * @return JsonResponse|Response
     */
    public function show(int $id)
    {
        return $this->toJsonSpec(
            $this->repository->findOrFailById($id)
        );
    }

    /**
     * @param FormRequest $request
     * @param int $id
     * @return JsonResponse|Response
     */
    public function update(FormRequest $request, int $id)
    {
        return $this->toJsonSpec(
            $this->repository->update($request, $id)
        );
    }

    /**
     * @param int $id
     * @return JsonResponse|Response
     */
    public function destroy(int $id)
    {
        return $this->toJsonSpec(
            $this->repository->delete($id)
        );
    }
}
