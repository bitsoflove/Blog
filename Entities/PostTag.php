<?php

namespace Modules\Blog\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Tag;
use Modules\Blog\Entities\TagTranslation;

class PostTag extends Model
{
    use Translatable;

    /**
     * @var string
     */
    protected $table = 'blog_post_tags';

    /**
     * @var array
     */
    protected $fillable = [
        'tag_id',
        'post_id',
        'id',
        'title'
    ];

    /**
     * @var array
     */
    public $translatedAttributes = [
        'tag_id',
        'title'
    ];

    /**
     * @var
     */
    public $translationModel = TagTranslation::class;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
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
