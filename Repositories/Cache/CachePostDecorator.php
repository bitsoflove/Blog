<?php

namespace Modules\Blog\Repositories\Cache;

use Modules\Blog\Repositories\Collection;
use Modules\Blog\Repositories\PostRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePostDecorator extends BaseCacheDecorator implements PostRepository
{
    public function __construct(PostRepository $post)
    {
        parent::__construct();
        $this->entityName = 'posts';
        $this->repository = $post;
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
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.latest.{$amount}", $this->cacheTime,
                function () use ($amount) {
                    return $this->repository->latest($amount);
                }
            );
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
        $postId = $post->id;

        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.getPreviousOf.{$postId}", $this->cacheTime,
                function () use ($post) {
                    return $this->repository->getPreviousOf($post);
                }
            );
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
        $postId = $post->id;

        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.getNextOf.{$postId}", $this->cacheTime,
                function () use ($post) {
                    return $this->repository->getNextOf($post);
                }
            );
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
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.latestTranslatedIn.{$lang}.{$amount}", $this->cacheTime,
                function () use ($lang, $amount) {
                    return $this->repository->latestTranslatedIn($lang, $amount);
                }
            );
    }

    /**
     * Get a paginated list of translated resources
     *
     * @param string $lang
     * @param int|null $per_page
     * @return \Illuminate\Support\Collection
     */
    public function allTranslatedInPaginated(string $lang, int $per_page = null, $page = 1)
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.allTranslatedInPaginated.{$lang}.{$per_page}.{$page}", $this->cacheTime,
                function () use ($lang, $per_page, $page) {
                    \Log::info("Refreshing blog {$lang}, {$per_page}, {$page}");
                    return $this->repository->allTranslatedInPaginated($lang, $per_page);
                }
            );
    }
}
