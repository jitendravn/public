<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <title>Blog </title>
</head>

<body>
    <div class="container">
        <div class="row mt-4 ">
            @if ($view_type == 'add' || $view_type == 'edit')
                <div class="row mb-2 ">
                    <div class="col-md-3 ">
                        <a href="{{ route('blog.index') }}" class="btn btn-danger">Go to Listing</a>
                    </div>
                </div>
            @else
                <div class="row mb-2">
                    <div class="col-md-3 ">
                        <a href="{{ route('blog.create') }}" class="btn btn-danger">Add</a>

                    </div>
                </div>
            @endif
            @if ($view_type == 'add' || $view_type == 'edit')
                <div class="col-md-3"></div>
                <div class="col-md-5">
                    @if (Session::has('status'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session::get('status') }}
                        </div>
                    @endif
                    <div class="card shadow">
                        <div class="card-header bg-danger text-white"> {{ $view_type == 'edit' ? 'Edit' : 'Add' }}
                            Blog</div>

                        <form
                            action="{{ $view_type == 'edit' ? route('blog.update', $blog->id) : route('blog.store') }}"
                            method='POST' enctype="multipart/form-data">
                            @method( ($view_type == 'edit' ? 'PUT' : 'POST') )

                            <div class="card-body ">
                                @csrf


                                <div class="form-group mb-2">
                                    <label for="">Title</label>
                                    <input type="text" name="title"
                                        value="{{ isset($blog->title) && $blog->title != '' ? $blog->title : old('title') }}"
                                        class="form-control" placeholder="Enter Your Blog Title">

                                    <span class="text-danger fw-bold">@error('title')** {{ $message }}
                                        **@enderror</span>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Description</label>
                                    <textarea name="description" value="{{ old('description') }} 
                                        " id="" rows="5" class="form-control"
                                        placeholder="Enter Your Blog Description">{{ isset($blog->description) && $blog->description != '' ? $blog->description : old('description') }}</textarea>

                                    <span class="text-danger fw-bold">@error('description')** {{ $message }}
                                        **@enderror</span>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Author</label>
                                    <input type="text" name="author"
                                        value="{{ isset($blog->author) && $blog->author != '' ? $blog->author : old('author') }}"
                                        class="form-control" placeholder="Enter Your Blog Author Name">
                                    <span class="text-danger fw-bold">@error('author') ** {{ $message }}
                                        **@enderror</span>
                                </div>

                                <div class="form-group mb-2 mt-2">
                                    <label for="">Blog Status : </label>
                                    
                                    <input class="form-check-input" type="radio" name="status"
                                        value="1" 
                                        @if ( $view_type=='edit' )
                                        {{ $blog->status==1 ?'checked':''}}
                                        @endif
                                        id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Active
                                    </label>
                                    <input class="form-check-input" type="radio" name="status"
                                        value="0"
                                        @if ($view_type=='edit')
                                        {{ $blog->status==0 ?'checked':''}}
                                        @endif
                                        id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Inactive
                                    </label>
                                    
                                    <span class="text-danger fw-bold">@error('status') ** {{ $message }}
                                        **@enderror</span>

                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Blog Image</label>
                                    <input type="file" name="image"
                                        value="   {{ isset($blog->image) && $blog->image != '' ? $blog->image : old('image') }}"
                                        class="form-control" accept="image/*" />

                                    <span class="text-danger fw-bold">@error('image') ** {{ $message }}
                                        **@enderror</span>
                                </div>

                            </div>
                            <div class="card-footer">
                                @if ($view_type == 'edit')

                                    <button class="btn btn-danger form-control">Update</button>
                                @else
                                    <button class="btn btn-danger form-control">Save</button>
                                @endif
                            </div>
                        </form>

                    </div>
                </div>
            @else

                <div class="col-md-12 " id="table">
                    @if (Session::has('delete'))
                        <div class="alert alert-danger alert-dismissible fade show delete">
                            {{ session::get('delete') }}
                        </div>
                    @endif
                    @if (Session::has('update'))
                        <div class="alert alert-danger alert-dismissible fade show ">
                            {{ session::get('update') }}
                        </div>
                    @endif
                    @if (Session::has('blogStatus'))
                        <div class="alert alert-danger alert-dismissible fade show ">
                            {{ session::get('blogStatus') }}
                        </div>
                    @endif


                    <div class="card shadow">
                        <div class="card-header bg-danger text-white">Blog Details</div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th colspan="2" class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($blog as $item)
                                        <tr id='row{{ $item->id }}'>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $item->author }}</td>

                                            <td><a href="{{ url('status', $item->id) }}"
                                                    class="btn btn-{{ $item->status == 1 ? 'danger' : 'warning' }}">{{ $item->status == 1 ? 'Active' : 'Inactive' }}</a>
                                            </td>

                                            <td><img src="{{ asset('uploads/blog/' . $item->image) }}"
                                                    alt="{{ $item->title }}" class="img-fluid w-50 img-thumbnail">
                                            </td>
                                            <td><a href="{{ route('blog.edit', $item->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                            </td>

                                            <td><button
                                                    onclick="deleteBlog(this,'{{ route('blog.destroy', $item->id) }}')"
                                                    class="btn btn-danger">Delete</button>

                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <th class=" text-center" colspan="5">Blog Data Not Found</th>
                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>





    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- ajax delete request --}}
    {!! JsValidator::formRequest('App\Http\Requests\BlogRequest') !!}
    {{-- <script>
        $(document).ready(function() {

            $('#deleteBlog').click(function(e) {
                e.preventDefault();
                alert('jteindra kumar');
            });
        });
    </script> --}}
    <script>
        function deleteBlog(obj, blog_url) {

            if (confirm('Are You sure you want to delete this blog')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "delete",
                    url: blog_url,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 1) {
                            swal('', response.msg, 'success');
                            $(obj).parent().closest('tr').remove();
                        } else {
                            swal('', response.msg, 'error');

                        }
                    }
                });
            }
        }
    </script>
    {{-- <script>
    
    var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            
            ajax: '{{ route('blog.index') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'author', name: 'author'},
               { data: 'status', name: 'status',
                    render: function ( data, type, full, meta ) {
                    return data ? "active" : "not active" ;
                    }},
                {data: 'image', name: 'image',
                render: function( data, type, full, meta ) {
            return "<img src=\"uploads/blog/" + data + "\" height=\"50\"/>";
        } },
                {data: 'actions', name: 'actions',orderable:false,searchable:false,sClass:'text-center'},
            ]
        });
</script> --}}
</body>

</html>
