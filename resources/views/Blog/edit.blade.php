<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Blog | Edit</title>
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-3"></div>
            <div class="col-md-6 ">
                @if (Session::has('status'))
                    <div class="alert alert-danger">
                        {{ session::get('status') }}
                    </div>
                @endif
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">Add Blog</div>

                    <form action="{{ route('blog.update',$blog->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PATCH')
                        <div class="card-body ">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="">Title</label>
                                <input type="text" name="title"  value="{{$blog->title}}" class="form-control"
                                    placeholder="Enter Your Blog Name">
                                <span class="text-danger fw-bold">@error('title')** {{ $message }}
                                    **@enderror</span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Description</label>
                                <textarea name="description" id=""    rows="5" class="form-control"
                                    placeholder="Enter Your Blog Description">{{$blog->description}}</textarea>

                                <span class="text-danger fw-bold">@error('description')** {{ $message }}
                                    **@enderror</span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Author</label>
                                <input type="text" name="author" value="{{$blog->author}}" class="form-control"
                                    placeholder="Enter Your Blog Author Name">
                                <span class="text-danger fw-bold">@error('author') ** {{ $message }}
                                    **@enderror</span>
                            </div>
                            <div class="form-group mb-2 mt-2">
                                <label for="">Blog_Status : </label>
                                
                                <input class="form-check-input" type="radio" name="status" value="1" {{$blog->status==1 ?'checked':''}}
                                    id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                   Active
                                </label>
                                <input class="form-check-input" type="radio" name="status" {{$blog->status==1?'checked':''}}  value="0" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                 Inactive   
                                </label>
                                
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Blog Image</label>
                                <input type="file" name="image" class="form-control" value="{{$blog->image}}"accept="image/*" />
                                   
                                <span class="text-danger fw-bold">@error('image') ** {{ $message }}
                                    **@enderror</span>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary form-control">Update</button>
                        </div>
                    </form>
                </div>
            </div>
           
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

</body>

</html>
