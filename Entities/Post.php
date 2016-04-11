<?php namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Modules\Blog\Presenters\PostPresenter;
use Modules\Core\Internationalisation\Translatable;
use Modules\Media\Support\Traits\MediaRelation;

class Post extends Model {

    /**
     * Generated
     */

    protected $table = 'blog_posts';
    protected $fillable = ['id', 'category_id', 'author_id', 'status', 'slug', 'post_id', 'title', 'content'];

    public $translatedAttributes = ["post_id","title","content", "slug"];
    public $translationModel = \Modules\Blog\Entities\PostTranslation::class;

    use Translatable, MediaRelation, PresentableTrait, SoftDeletes;
    protected $presenter = PostPresenter::class;
    protected $casts = [
        'status' => 'int',
    ];

    /**
     * Check if the post is in draft
     * @param Builder $query
     * @return bool
     */
    public function scopeDraft(Builder $query)
    {
        return (bool) $query->whereStatus(0);
    }

    /**
     * Check if the post is pending review
     * @param Builder $query
     * @return bool
     */
    public function scopePending(Builder $query)
    {
        return (bool) $query->whereStatus(1);
    }

    /**
     * Check if the post is published
     * @param Builder $query
     * @return bool
     */
    public function scopePublished(Builder $query)
    {
        return (bool) $query->whereStatus(2);
    }

    /**
     * Check if the post is unpublish
     * @param Builder $query
     * @return bool
     */
    public function scopeUnpublished(Builder $query)
    {
        return (bool) $query->whereStatus(3);
    }



    public function author() {
        return $this->belongsTo(\Modules\User\Entities\Sentinel\User::class, 'author_id', 'id');
    }

    public function category() {
        return $this->belongsTo(\Modules\Blog\Entities\Category::class, 'category_id', 'id');
    }

    public function tags() {
        $x = $this->belongsToMany(\Modules\Blog\Entities\PostTag::class, 'blog_post_tag', 'post_id', 'tag_id');
        //dd($x->toArray());
        return $x;
    }
//
//    public function blogPostTags2() {
//        return $this->hasMany(\Modules\Blog\Entities\PostTag::class, 'post_id', 'id');
//    }

    public function translations() {
        return $this->hasMany(\Modules\Blog\Entities\PostTranslation::class, 'post_id', 'id');
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
        if(isset($attributes['tags'])) {
            $model->tags()->sync($attributes['tags']);
        }
    }

}
