<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Service\Blog\BlogServiceInterface;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    private $blogService;

    public function __construct(BlogServiceInterface $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($blog_id)
    {
        $blog = $this->blogService->find($blog_id);
        $blogComments = $blog->blogComments;

        return view('admin.blog.comment.index', compact('blog', 'blogComments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($blog_id, $blog_comment_id)
    {
        $blog = $this->blogService->find($blog_id);
        $blogComment = BlogComment::find($blog_comment_id);

        return view('admin.blog.comment.edit', compact('blog', 'blogComment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $blog_id, $blog_comment_id)
    {
        $data = $request->all();
        if($request->checked == null)
            $data += ['checked' => 0];

        BlogComment::find($blog_comment_id)->update($data);
        
        return redirect('/admin/blog/' . $blog_id . '/comment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($blog_id, $blog_comment_id)
    {
        BlogComment::find($blog_comment_id)->delete();

        return redirect('/admin/blog/' . $blog_id . '/comment');
    }
}
