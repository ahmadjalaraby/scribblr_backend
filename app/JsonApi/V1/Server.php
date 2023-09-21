<?php

namespace App\JsonApi\V1;

use App\Actions\Web\Gallery\DeleteGalleryAction;
use App\Constants\Image\ImageDirectoryConstants;
use App\DataTransferObjects\GalleryData;
use App\JsonApi\V1\Articles\ArticleSchema;
use App\JsonApi\V1\ArticleVisits\ArticleVisitSchema;
use App\JsonApi\V1\Bookmarks\BookmarkSchema;
use App\JsonApi\V1\Comments\CommentSchema;
use App\JsonApi\V1\Countries\CountrySchema;
use App\JsonApi\V1\Follows\FollowSchema;
use App\JsonApi\V1\Galleries\GallerySchema;
use App\JsonApi\V1\Likes\LikeSchema;
use App\JsonApi\V1\Tags\TagSchema;
use App\JsonApi\V1\Users\UserSchema;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Exceptions\JsonApiException;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';


    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        // no-op
        Auth::shouldUse('sanctum');

        //
        Article::created(static fn(Article $article) => self::handleImageUpload(
            $article,
            ImageDirectoryConstants::ARTICLE,
            'imagePath'
        ));

        Article::updated(static fn(Article $article) => self::handleImageUpload(
            $article,
            ImageDirectoryConstants::ARTICLE,
            'imagePath'
        ));
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            UserSchema::class,
            FollowSchema::class,
            BookmarkSchema::class,
            LikeSchema::class,
            CommentSchema::class,
            TagSchema::class,
            CountrySchema::class,
            ArticleSchema::class,
            ArticleVisitSchema::class,
            GallerySchema::class,
        ];
    }

    /**
     * @param string $base64EncodedString
     * @return string
     */
    public static function getExtension(string $base64EncodedString): string
    {
        $extension = explode(";", explode("/", $base64EncodedString)[1])[0];
        return match ($extension) {
            'image/jpeg', 'jpeg' => ".jpeg",
            'image/jpg', 'jpg' => ".jpg",
            'image/png', 'png' => '.png',
            default => "",
        };
    }

    /**
     * Upload image using base64, because the laravel json api routes does not support
     * media upload currently
     * @throws JsonApiException
     */
    private static function handleImageUpload($model, string $directory, string $type = 'image'): void
    {
        try {
            $request_object = request()->json()->all();
            if (!isset($request_object['data']['attributes'][$type])) return;
            $request = $request_object['data']['attributes'][$type];

            $image = $request ? GalleryData::fromBase64($request, $directory)
                : null;

            $model->load('image');

            // update the image relation if exists
            if ($model->image && $image) {
                DeleteGalleryAction::execute($model->image);
            }

            // create an image if image file exists
            if ($image) {
                $model->image()->create($image->all());
            }

        } catch (\Exception $exception) {
            $error = Error::fromArray([
                'title' => 'Invalid File',
                'detail' => $exception->getMessage(),
                'status' => 422,
            ]);
            throw new JsonApiException($error);
        }
    }
}
