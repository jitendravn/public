<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DataTables;

use JsValidator;
class BlogController extends Controller
{

    public function index(Request $request)
    {


        $view_type = 'listing';
        $blog = Blog::all();
        if ($request->ajax()) {
          
            return Datatables::of($blog)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    $btn = '<button class="btn btn-primary btn-sm" id="editBlog">Edit</button> <button onclick="deleteBlog(\''.route("blog.destroy",$row->id).'\')" class="btn btn-danger btn-sm">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('Blog.index', compact('view_type', 'blog'));
    }

    public function show()
    {
        $view_type = 'listing';
        $blog = Blog::all();
        return view('Blog.index', compact('blog', 'view_type'));
    }

    public function create()
    {
        $view_type = 'add';
        $blog = Blog::all();
         $validation  = JsValidator::formRequest('App\Http\Requests\BlogRequest');
        return view('Blog.index', compact(['blog', 'view_type','validation']));
    }

    public function store(Request $request)
    {

      
        $blog = new Blog();
       


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/blog', $filename);
            $file->image = $filename;
        }
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->author = $request->author;
        $blog->status = $request->status == '1' ? '1' : '0';
        $blog->image = $filename;

        $blog->save();



        return back()->with('status', 'Blog added successfully', compact('blog'));
    }

    public function edit($id)
    {
        $view_type = 'edit';
        $blog = Blog::find($id);
        $validation  = JsValidator::formRequest('App\Http\Requests\BlogRequest');
        return view('Blog.index', compact(['blog', 'view_type','validation']));
    }

    public function update(Request $request, $id)
    {

        // $request->validate();
        
        $blog = Blog::find($id);
        if (File::exists("uploads/blog/" . $blog->image)) {
            File::delete("uploads/blog/" . $blog->image);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/blog', $filename);
            $file->image = $filename;
        }

        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->author = $request->author;
        $blog->status = $request->status == '1' ? '1' : '0';

        $blog->image = $filename;

        $blog->update();
        return redirect('blog')->with('update', 'Blog updated successfully');
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (File::exists("uploads/blog/" . $blog->image)) {
            File::delete("uploads/blog/" . $blog->image);
        }

        $blog->delete();
        if ($blog) {
            return response()->json(['status' => 1, 'msg' => 'Blog deleted successfully']);
        } else {
            return response()->json(['status' => 1, 'msg' => 'Something went wrong']);
        }
    }

    public function status($id)
    {
        $blog = Blog::find($id);

        if ($blog->status == '1') {
            $blog->status = '0';
        } else {
            $blog->status = '1';
        }
        $blog->update();
        return back()->with('blogStatus', 'Blog Status Has been Updated Successfully ');
    }
}
