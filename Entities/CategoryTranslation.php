<?php namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model {

    /**
     * Generated
     */

    protected $table = 'blog_category_translations';
    protected $fillable = ['id', 'category_id', 'title', 'slug'];

    use \Illuminate\Database\Eloquent\SoftDeletes;



    public function blogCategory() {
        return $this->belongsTo(\Modules\Blog\Entities\Category::class, 'category_id', 'id');
    }



    public function update(array $attributes = []) {
        $res = parent::update($attributes);
        self::sync($this, $attributes);
        return $res;
    }

    public static function create(array $attributes = []) {
        $res = parent::create($attributes);
        self::sync($res, $attributes);
        return $res;
    }

    /**
     * Sync many-to-many relationships
     */
    private static function sync($model, array $attributes = []) {
        
    }

}
