<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Modules\Blog\Entities\Category;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTranslation;
use Modules\Blog\Presenters\PostPresenter;
use Modules\Core\Internationalisation\Translatable;
use Modules\Media\Support\Traits\MediaRelation;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Post extends Model implements HasMediaConversions
{

    use Translatable;
    use PresentableTrait;
    use SoftDeletes;
    use HasMediaTrait;

    /**
     * @var string
     */
    protected $table = 'blog_posts';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'category_id',
        'author_id',
        'status',
        'slug',
        'post_id',
        'title',
        'content'
    ];

    /**
     * @var array
     */
    public $translatedAttributes = [
        'post_id',
        'title',
        'content',
        'slug'
    ];

    /**
     * @var string
     */
    public $translationModel = PostTranslation::class;

    /**
     * @var string
     */
    protected $presenter = PostPresenter::class;

    /**
     * @var array
     */
    protected $casts = [
        'status' => 'int',
    ];

    /**
     * Check if the post is in draft.
     *
     * @param Builder $query
     *
     * @return bool
     */
    public function scopeDraft(Builder $query)
    {
        return (bool)$query->whereStatus(0);
    }

    /**
     * Check if the post is pending review.
     *
     * @param Builder $query
     *
     * @return bool
     */
    public function scopePending(Builder $query)
    {
        return (bool)$query->whereStatus(1);
    }

    /**
     * Check if the post is published.
     *
     * @param Builder $query
     *
     * @return bool
     */
    public function scopePublished(Builder $query)
    {
        return (bool)$query->whereStatus(2);
    }

    /**
     * Check if the post is unpublish.
     *
     * @param Builder $query
     *
     * @return bool
     */
    public function scopeUnpublished(Builder $query)
    {
        return (bool)$query->whereStatus(3);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(config('cartalyst.sentinel.users.model', '\Modules\User\Entities\Sentinel\User'),
            'author_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        $x = $this->belongsToMany(PostTag::class, 'blog_post_tag', 'post_id', 'tag_id');
        return $x;
    }

    /**
     * @param array $attributes
     * @return bool|int
     */
    public function update(array $attributes = [])
    {
        $res = parent::update($attributes);
        self::sync($this, $attributes);

        if (
            isset($attributes['image']) &&
            $attributes['image'] instanceof UploadedFile
        ) {
            $this->clearImages();
            $res->addImage($attributes['image']);
        }

        return $res;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $res = parent::create($attributes);
        self::sync($res, $attributes);

        if (
            isset($attributes['image']) &&
            $attributes['image'] instanceof UploadedFile
        ) {
            $res->addImage($attributes['image']);
        }

        return $res;
    }

    /**
     * Sync many-to-many relationships.
     */
    private static function sync($model, array $attributes = [])
    {
        if (isset($attributes['tags'])) {
            $model->tags()->sync($attributes['tags']);
        }
    }

    /**
     * Add an image to the Post entity
     *
     * @param UploadedFile $image
     * @param string $collection
     * @return Post
     */
    public function addImage(UploadedFile $image, $collection = 'images')
    {
        $this->addMedia($image->getRealPath())
            ->usingName($image->getClientOriginalName())
            ->usingFileName($image->getClientOriginalName())
            ->toMediaLibrary($collection);

        return $this;
    }

    /**
     * Remove all associated files
     *
     * @param string $collection
     */
    public function clearImages($collection = 'images')
    {
        foreach ($this->getMedia($collection) as $media) {
            $media->delete();
        }
    }

    /**
     * Register the conversions that should be performed.
     *
     * @return array
     */
    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
            ->setManipulations(['w' => 368, 'h' => 232])
            ->performOnCollections('images');
    }
}
