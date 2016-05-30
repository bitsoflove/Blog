<?php

namespace Modules\Blog\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Blog\Entities\CategoryTranslation;
use Modules\Blog\Entities\Post;

class Category extends Model
{
    use SoftDeletes;
    use Translatable;

    /**
     * @var string
     */
    protected $table = 'blog_categories';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'slug',
        'category_id',
        'title'
    ];

    /**
     * @var array
     */
    public $translatedAttributes = [
        'category_id',
        'title'
    ];

    /**
     * @var
     */
    public $translationModel = CategoryTranslation::class;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogCategoryTranslations()
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogPosts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
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
