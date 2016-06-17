<?php

namespace Modules\Blog\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface PostRepository extends BaseRepository
{
    /**
     * Return the latest x blog posts.
     *
     * @param int $amount
     *
     * @return Collection
     */
    public function latest($amount = 5);

    /**
     * Return the latest x blog posts in the given language
     *
     * @param string $lang
     * @param int $amount
     * @return Collection
     */
    public function latestTranslatedIn($lang, $amount = 5);

    /**
     * Get the previous post of the given post.
     *
     * @param object $post
     *
     * @return object
     */
    public function getPreviousOf($post);

    /**
     * Get the next post of the given post.
     *
     * @param object $post
     *
     * @return object
     */
    public function getNextOf($post);

    /**
     * Get a paginated list of translated resources
     *
     * @param string $lang
     * @param int|null $per_page
     * @param int $page
     * @return \Illuminate\Support\Collection
     */
    public function allTranslatedInPaginated(string $lang, int $per_page = null, $page = 1);

}
