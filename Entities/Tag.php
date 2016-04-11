<?php namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    /**
     * Generated
     */

    protected $table = 'blog_post_tags';
    protected $fillable = ['id', 'slug', 'title'];

    use \Illuminate\Database\Eloquent\SoftDeletes;

    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ["title", "slug"];
    public $translationModel = \Modules\Blog\Entities\TagTranslation::class;

    

    public function posts() {
        return $this->belongsTo(\Modules\Blog\Entities\Post::class);
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
