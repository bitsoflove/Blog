<?php namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model {

    /**
     * Generated
     */

    protected $table = 'blog_post_tag_translations';
    protected $fillable = ['id', 'locale', 'tag_id', 'title', "slug"];

    use \Illuminate\Database\Eloquent\SoftDeletes;



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
