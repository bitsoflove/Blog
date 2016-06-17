<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\Blog\Repositories\PostRepository;
use Modules\Core\Http\Controllers\BasePublicController;

class PublicController extends BasePublicController
{
    /**
     * @var PostRepository
     */
    private $post;

    public function __construct(PostRepository $post)
    {
        parent::__construct();
        $this->post = $post;
    }

    public function index(Request $request)
    {
        // determine the number of blog items should be shown on the page
        $per_page = intval($request->get('per-page', 15));

        // determine the current page
        $page = intval($request->get('page', 1));

        $posts = $this->post->allTranslatedInPaginated(App::getLocale(), $per_page, $page);

        return view('front.pages.blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = $this->post->findBySlug($slug);

        return view('front.pages.blog.show', compact('post'));
    }
}
