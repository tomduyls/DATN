<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Service\Blog\BlogServiceInterface;
use App\Service\BlogComment\BlogCommentServiceInterface;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $blogService;
    private $blogCommentService;

    public function __construct(BlogServiceInterface $blogService,
                                BlogCommentServiceInterface $blogCommentService)
    {
        $this->blogService = $blogService;
        $this->blogCommentService = $blogCommentService;
    }

    public function index(Request $request)
    {
        $blogs = $this->blogService->all();
        $categories = $blogs->unique('category');
        
        $blogs = $this->blogService->getBlogOnIndex($request);
        $recentBlogs = $this->blogService->getLatestBlogs();

        return view('front.blog.index', compact('blogs', 'recentBlogs', 'categories'));
    }

    public function category($categoryName, Request $request)
    {
        $blogs = $this->blogService->all();
        $categories = $blogs->unique('category');
        
        $blogs = $this->blogService->getBlogByCategory($categoryName, $request);
        $recentBlogs = $this->blogService->getLatestBlogs();

        return view('front.blog.index', compact('blogs', 'recentBlogs', 'categories'));
    }

    public function show($id)
    {
        $blog = $this->blogService->find($id);
        $relatedBlog = $this->blogService->getRelatedBlogs($blog);
        
        return view('front.blog.show', compact('blog', 'relatedBlog'));
    }

    public function postComment(Request $request) 
    {
        $this->blogCommentService->create($request->all());
    }

    public function loadComment(Request $request)
    {
        $blog_id = $request->blog_id;
        $comments = BlogComment::where('blog_id', $blog_id)->get();
        $response = '';
        foreach($comments as $comment){
            $comment_date = date('M d, Y', strtotime($comment->created_at));
            $comment_avatar = $comment->user->avatar ?? 'default-avatar.jpg';
            $response .= '<div class="co-item">
                        <div class="pb-pic"> 
                        <img src="front/img/user/'.$comment_avatar.'" alt="">
                        </div>
                        <div class="pb-text">
                        <h5>'.$comment->name.' - <span>'.$comment_date.'</span></h5>';
            if ($comment->checked == 0 )
                $response .= 'This comment is being checked.</div></div>';   
            else
                $response .= '<p>'.$comment->messages.'</p></div></div>';
        }    
        echo $response;        
    }
}
