<?php

namespace Modules\Blog\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Status;
use Modules\Blog\Repositories\Collection;
use Modules\Blog\Repositories\PostRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentPostRepository extends EloquentBaseRepository implements PostRepository
{
    /**
     * @param int $id
     *
     * @return object
     */
    public function find($id)
    {
        return $this->model->with('translations', 'tags')->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->with('translations', 'tags')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Update a resource.
     *
     * @param $post
     * @param array $data
     *
     * @return mixed
     */
    public function update($post, $data)
    {
        $post->update($data);
        
        return $post;
    }

    /**
     * Create a blog post.
     *
     * @param array $data
     *
     * @return Post
     */
    public function create($data)
    {
        $auth = \App::make('Modules\Core\Contracts\Authentication');
        $author = $auth->check();

        $data['author_id'] = $author->id;

        $post = $this->model->create($data);

        return $post;
    }

    /**
     * Return all resources in the given language.
     *
     * @param string $lang
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allTranslatedIn($lang)
    {
        return $this->model->whereHas('translations', function (Builder $q) use ($lang) {
            $q->where('locale', "$lang");
            $q->where('title', '!=', '');
        })->with('translations')->whereStatus(Status::PUBLISHED)->orderBy('created_at', 'desc')->paginate(15);
    }

    /**
     * Return all resources in the given language.
     *
     * @param string $lang
     *
     * @param null|int $per_page
     * @param int $page
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allTranslatedInPaginated(string $lang, int $per_page = null, $page = 1)
    {
        if(is_null($per_page)){
            $per_page = config('asgard.blog.config.overview.number-of-items', 15);
        }

        return $this->model->whereHas('translations', function (Builder $q) use ($lang) {
            $q->where('locale', "$lang");
            $q->where('title', '!=', '');
        })->with('translations')->whereStatus(Status::PUBLISHED)->orderBy('created_at', 'desc')->paginate($per_page);
    }

    /**
     * Return the latest x blog posts.
     *
     * @param int $amount
     *
     * @return Collection
     */
    public function latest($amount = 5)
    {
        return $this->model->whereStatus(Status::PUBLISHED)->orderBy('created_at', 'desc')->take($amount)->get();
    }

    /**
     * Return the latest x blog posts in the given language
     *
     * @param string $lang
     * @param int $amount
     * @return Collection
     */
    public function latestTranslatedIn($lang, $amount = 5)
    {
        return $this->allTranslatedIn($lang)->take($amount);
    }

    /**
     * Get the previous post of the given post.
     *
     * @param object $post
     *
     * @return object
     */
    public function getPreviousOf($post)
    {
        return $this->model->where('created_at', '>', $post->created_at)
            ->whereStatus(Status::PUBLISHED)->orderBy('created_at', 'desc')->first();
    }

    /**
     * Get the next post of the given post.
     *
     * @param object $post
     *
     * @return object
     */
    public function getNextOf($post)
    {
        return $this->model->where('created_at', '<', $post->created_at)
            ->whereStatus(Status::PUBLISHED)->orderBy('created_at', 'desc')->first();
    }

    /**
     * Find a resource by the given slug.
     *
     * @param string $slug
     *
     * @return object
     */
    public function findBySlug($slug)
    {
        return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
            $q->where('slug', "$slug");
        })->with('translations')->whereStatus(Status::PUBLISHED)->firstOrFail();
    }
}
