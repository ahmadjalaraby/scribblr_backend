<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\JsonApi\V1\Articles\ArticleQuery;
use App\JsonApi\V1\Articles\ArticleRequest;
use App\JsonApi\V1\Articles\ArticleSchema;
use Illuminate\Http\UploadedFile;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class ArticleController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;

//    use Actions\Store;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;


    /**
     * Create a new resource.
     *
     * @param ArticleSchema $schema
     * @param ArticleRequest $request
     * @param ArticleQuery $query
     * @return DataResponse
     */
    public function store(ArticleSchema $schema, ArticleRequest $request, ArticleQuery $query): DataResponse
    {

        $model = $schema
            ->repository()
            ->create()
            ->withRequest($query)
            ->store($request->validated());


        return new DataResponse($model);
    }

}
