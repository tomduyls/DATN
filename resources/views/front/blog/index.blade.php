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
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1">
                    <div class="blog-sidebar">
                        <div class="search-form">
                            <h4>Search</h4>
                            <form action="blog">
                                <input type="text" placeholder="Search..." value="{{ request('search') }}" name="search">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="blog-catagory">
                            <h4>Categories</h4>
                            <ul>
                                @foreach($categories as $category)
                                    <li><a href="blog/category/{{ $category->category }}">{{ $category->category }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="recent-post">
                            <h4>Recent Post</h4>
                            <div class="recent-blog">
                                @foreach($recentBlogs as $recentBlog)
                                    <a href="#" class="rb-item">
                                        <div class="rb-pic">
                                            <img src="front/img/blog/{{ $recentBlog->image }}" alt="">
                                        </div>
                                        <div class="rb-text">
                                            <h6>{{ $recentBlog->title }}</h6>
                                            <p>{{ $recentBlog->category }} <span>- {{ date('M d, Y', strtotime($recentBlog->create_at)) }}</span></p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <form action="">
                                    <div class="select-option">
                                        <select name="sort_by" onchange="this.form.submit();" class="sorting">
                                            <option {{ request('sort_by') == 'latest' ? 'selected' : '' }} value="latest">Sorting: Latest</option>
                                            <option {{ request('sort_by') == 'oldest' ? 'selected' : '' }} value="oldest">Sorting: Oldest</option>
                                        </select>
                                        <select name="show" onchange="this.form.submit();" class="p-show">
                                            <option {{ request('show') == '4' ? 'selected' : '' }} value="4">Show: 4</option>
                                            <option {{ request('show') == '6' ? 'selected' : '' }} value="6">Show: 6</option>
                                            <option {{ request('show') == '12' ? 'selected' : '' }} value="12">Show: 12</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-5 col-md-5 text-right">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($blogs as $blog)
                            <div class="col-lg-6 col-sm-6">
                                <div class="blog-item">
                                    <div class="bi-pic">
                                        <img src="front/img/blog/{{ $blog->image }}" alt="">
                                    </div>
                                    <div class="bi-text">
                                        <a href="./blog/{{ $blog->id }}">
                                            <h4>{{ $blog->title }}</h4>
                                        </a>
                                        <p>{{ $blog->category }} <span>- {{ date('M d, Y', strtotime($blog->create_at)) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection