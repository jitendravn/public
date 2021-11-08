<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-5">
                @if (Session::has('status'))
                    <div class="alert alert-danger">
                        {{ session::get('status') }}
                    </div>
                @endif
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">Add Blog</div>

                    <form action="{{ url('add_blog') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body ">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="">Title</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                                    placeholder="Enter Your Blog Name">
                                <span class="text-danger fw-bold">@error('title')** {{ $message }}
                                    **@enderror</span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Description</label>
                                <textarea name="description" value="{{ old('description') }}" id="" rows="5"
                                    class="form-control" placeholder="Enter Your Blog Description"></textarea>

                                <span class="text-danger fw-bold">@error('description')** {{ $message }}
                                    **@enderror</span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Author</label>
                                <input type="text" name="author" value="{{ old('author') }}" class="form-control"
                                    placeholder="Enter Your Blog Author Name">
                                <span class="text-danger fw-bold">@error('author') ** {{ $message }}
                                    **@enderror</span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Blog Image</label>
                                <input type="file" name="image" class="form-control">
                                <span class="text-danger fw-bold">@error('image') ** {{ $message }}
                                    **@enderror</span>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button class="btn btn-danger form-control">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-7">
                @if (Session::has('delete'))
                    <div class="alert alert-danger delete">
                        {{ session::get('delete') }}
                    </div>
                @endif
                @if (Session::has('update'))
                    <div class="alert alert-danger ">
                        {{ session::get('update') }}
                    </div>
                @endif
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">Blog Details</div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Author</th>
                                    <th>Image</th>
                                    <th colspan="2" class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($blog as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->author }}</td>
                                        <td><img src="{{ 'uploads/blog/' . $item->image }}" alt="{{ $item->title }}"
                                                class="img-fluid"></td>
                                        <td><a href="{{ url('edit/' . $item->id) }}" class="btn btn-warning">Edit</a>
                                        </td>
                                        <td><button data-id="{{ $item->id }}" id="deleteBlog"
                                                class="btn btn-danger">Delete</button>
                                                @csrf
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
        </div>
    </div>





    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- ajax delete request --}}
    <script>
        $(document).on('click', '#deleteBlog', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
           
            if (confirm('Are You sure you want to delete this blog')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    url: "{{ route('deleteBlog') }}",
                    data:{id:id} ,
                    dataType: "json",
                    success: function(response) {
                        if(response.status==1)
                        {   
                            swal(response.msg);
                            window.location.reload();
                        }
                        else
                        {
                            swal(response.msg);
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
