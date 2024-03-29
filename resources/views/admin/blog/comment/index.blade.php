@extends('admin.layout.master')

@section('title', 'Blog')

@section('body')
                <!-- Main -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                                </div>
                                <div>
                                    Blog
                                    <div class="page-title-subheading">
                                        View, create, update, delete and manage.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">

                                <div class="card-header">

                                    <form>
                                        <div class="input-group">
                                            <input type="search" name="search" id="search"
                                                placeholder="Search everything" class="form-control">
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-search"></i>&nbsp;
                                                    Search
                                                </button>
                                            </span>
                                        </div>
                                    </form>

                                    
                                </div>

                                <div class="table-responsive">
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="pl-4">Blog title</th>
                                                
                                                <th>Email</th>
                                                <th>Name</th>
                                                <th>Comment</th>
                                                <th>Checked</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($blogComments as $blogComment)
                                                <tr>
                                                    <td class="pl-4 text-muted">{{ $blog->title }}</td>

                                                    <td class="">{{ $blogComment->email }}</td>
                                                    <td class="">{{ $blogComment->name }}</td>
                                                    <td class="">{{ $blogComment->messages }}</td>
                                                    <td class="">
                                                        @if ($blogComment->checked == 1)
                                                            <div class="badge badge-success mt-2">
                                                                True
                                                            </div>
                                                        @else
                                                            <div class="badge badge-danger mt-2">
                                                                False
                                                            </div>
                                                        @endif
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        <a href="/admin/blog/{{ $blog->id }}/comment/{{ $blogComment->id }}/edit" data-toggle="tooltip" title="Edit"
                                                            data-placement="bottom" class="btn btn-outline-warning border-0 btn-sm">
                                                            <span class="btn-icon-wrapper opacity-8">
                                                                <i class="fa fa-edit fa-w-20"></i>
                                                            </span>
                                                        </a>
                                                        <form class="d-inline" action="/admin/blog/{{ $blog->id }}/comment/{{ $blogComment->id }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-hover-shine btn-outline-danger border-0 btn-sm"
                                                                type="submit" data-toggle="tooltip" title="Delete"
                                                                data-placement="bottom"
                                                                onclick="return confirm('Do you really want to delete this item?')">
                                                                <span class="btn-icon-wrapper opacity-8">
                                                                    <i class="fa fa-trash fa-w-20"></i>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr> 
                                            @endforeach
                                            

                                            
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-block card-footer">
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Main -->
@endsection