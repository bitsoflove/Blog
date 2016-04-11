<?php namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model {

    /**
     * Generated
     */

    protected $table = 'blog_post_translations';
    protected $fillable = ['id', 'post_id', 'title', 'content', 'slug'];

    use \Illuminate\Database\Eloquent\SoftDeletes;



    public function blogPost() {
        return $this->belongsTo(\Modules\Blog\Entities\Post::class, 'post_id', 'id');
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
