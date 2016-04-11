<?php namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    /**
     * Generated
     */

    protected $table = 'blog_categories';
    protected $fillable = ['id', 'slug', 'category_id', 'title'];


    use \Illuminate\Database\Eloquent\SoftDeletes;

    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ["category_id","title", "slug"];
    public $translationModel = \Modules\Blog\Entities\CategoryTranslation::class;



    public function blogCategoryTranslations() {
        return $this->hasMany(\Modules\Blog\Entities\CategoryTranslation::class, 'category_id', 'id');
    }

    public function blogPosts() {
        return $this->hasMany(\Modules\Blog\Entities\Post::class, 'category_id', 'id');
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
