@extends('front.layout.master')

@section('title', 'Blog')

@section('body')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="./"><i class="fa fa-home"></i> Home</a>
                        <a href="./blog">Blog</a>
                        <span>Detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->
    <!-- Blog Details Section Begin -->
    <div class="blog-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-details-inner">
                        <div class="blog-detail-title">
                            <h2>{{ $blog->title }}</h2>
                            <p>{{ $blog->category }} <span>- {{ date('M d, Y', strtotime($blog->create_at)) }}</span></p>
                        </div>
                        <div class="blog-large-pic">
                            <img src="front/img/blog/{{ $blog->image }}" alt="">
                        </div>
                        <div class="blog-detail-desc">
                            <p>
                                {!! $blog->content !!}
                            </p>
                        </div>

                        <div class="tag-share">
                            <div class="details-tag">
                                <ul>
                                    <li><i class="fa fa-tags"></i></li>
                                    <li>{{ $blog->category }}</li>
                                </ul>
                            </div>
                            <div class="blog-share">
                                <span>Share:</span>
                                <div class="social-links">
                                    <a href=""><i class="fa fa-facebook"></i></a>
                                    <a href=""><i class="fa fa-twitter"></i></a>
                                    <a href=""><i class="fa fa-google-plus"></i></a>
                                    <a href=""><i class="fa fa-instagram"></i></a>
                                    <a href=""><i class="fa fa-youtube-play"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="blog-post">
                            <div class="row">
                                @isset($relatedBlog[0])
                                <div class="col-lg-5 col-md-6">
                                    <a href="./blog/{{ $relatedBlog[0]->id }}" class="prev-blog">
                                        <div class="pb-pic">
                                            <i class="ti-arrow-left"></i>
                                            <img src="front/img/blog/{{ $relatedBlog[0]->image }}" alt="">
                                        </div>
                                        <div class="pb-text">
                                            <span>Previous Post:</span>
                                            <h5>{{ $relatedBlog[0]->title }}</h5>
                                        </div>
                                    </a>
                                </div>
                                @endisset
                                @isset($relatedBlog[1])
                                <div class="col-lg-5 col-md-6 offset-lg-2">
                                    
                                    <a href="./blog/{{ $relatedBlog[1]->id }}" class="next-blog">
                                        <div class="nb-pic">
                                            <img src="front/img/blog/{{ $relatedBlog[1]->image }}" alt="">
                                            <i class="ti-arrow-right"></i>
                                        </div>
                                        <div class="nb-text">
                                            <span>Next Post:</span>
                                            <h5>{{ $relatedBlog[1]->title }}</h5>
                                        </div>
                                    </a>  
                                </div>
                                @endisset
                            </div>
                        </div>
                        <div class="posted-by">
                            @foreach($blog->blogComments as $blogComment)
                                <div class="co-item">
                                    <div class="pb-pic">
                                        <img src="front/img/user/{{ $blogComment->user->avatar ?? 'default-avatar.jpg'}}" alt="">
                                    </div>
                                    <div class="pb-text">
                                        <h5>{{ $blogComment->name }} - <span>{{ date('M d, Y', strtotime($blogComment->created_at)) }}</span></h5>
                                        @if ($blogComment->checked == 0)
                                            This comment is being checked.
                                        @else
                                            <p>{{ $blogComment->messages }}</p>                 
                                        @endif 
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="leave-comment">
                            <h4>Leave A Comment</h4>
                            <form action="#" class="comment-form">
                                @csrf
                                <input type="hidden" name="blog_id" class="blog_id" value="{{ $blog->id }}">
                                <input type="hidden" name="checked" value="0">
                                <input type="hidden" name="user_id" class="user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id ?? null }}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input {{ Auth::check() ?  'readonly' : '' }} type="text" placeholder="Name" name="name" class="name" value="{{ Auth::user()->name ?? ''}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <input {{ Auth::check() ?  'readonly' : '' }} type="text" placeholder="Email" name="email" class="email" value="{{ Auth::user()->email ?? ''}}">
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea placeholder="Messages" name="messages" class="messages"></textarea>
                                        <button type="button" class="site-btn cmt-check post-blog-comment">Send message</button>
                                    </div>
                                    <div class="notify-comment"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Details Section End -->
@endsection