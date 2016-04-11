<?php namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model {

    /**
     * Generated
     */

    protected $table = 'blog_post_tags';
    protected $fillable = ['tag_id', 'post_id', 'id', 'title'];

    
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ["tag_id","title"];
    public $translationModel = \Modules\Blog\Entities\TagTranslation::class;



    public function post() {
        return $this->belongsTo(\Modules\Blog\Entities\Post::class, 'post_id', 'id');
    }

    public function tag() {
        return $this->belongsTo(\Modules\Blog\Entities\Tag::class, 'tag_id', 'id');
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
