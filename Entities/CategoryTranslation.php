<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Blog\Entities\Category;

class CategoryTranslation extends Model
{
    use SoftDeletes;


    /**
     * @var string
     */
    protected $table = 'blog_category_translations';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'category_id',
        'title',
        'slug'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blogCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
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
