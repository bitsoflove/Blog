<?php

namespace Modules\Blog\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\TagTranslation;

class Tag extends Model
{
    use SoftDeletes;

    use Translatable;

    /**
     * @var string
     */
    protected $table = 'blog_post_tags';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'slug',
        'title'
    ];

    /**
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'slug'
    ];

    /**
     * @var string
     */
    public $translationModel = TagTranslation::class;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function posts()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @param array $attributes
     * @return bool|int
     */
    public function update(array $attributes = [])
    {
        $res = parent::update($attributes);
        self::sync($this, $attributes);

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

        return $res;
    }

    /**
     * Sync many-to-many relationships.
     */
    private static function sync($model, array $attributes = [])
    {
    }
}
