<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DataTables;

class BlogController extends Controller
{

    public function index(Request $request)
    {

       
        $view_type='listing'; 
        $blog = Blog::all();

        return view('Blog.index', compact('view_type','blog'));
    }

    public function show()
   {
      $view_type='listing';
      $blog = Blog::all();
      return view('Blog.index',compact('blog','view_type'));
   }

    public function create(){
        $view_type = 'add';
        $blog=Blog::all();
        return view('Blog.index', compact(['blog','view_type']));
    }

    public function store(BlogRequest $request)
    {
       
        $blog = new Blog();
        $request->validate();
       
       
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

        
      
        return back()->with('status', 'Blog added successfully',compact('blog'));
    }

    public function edit($id)
    {   
        $view_type = 'edit';
         $blog = Blog::find($id);
        return view('Blog.index', compact(['blog','view_type']));
    }

    public function update(BlogRequest $request, $id)
    {
        
        $blog = Blog::find($id);
        $request->validate();
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
       if($blog)
       {
        return response()->json(['status'=>1 , 'msg' => 'Blog deleted successfully']);

       }
       else
       {
        return response()->json(['status'=>1 , 'msg' => 'Something went wrong']);

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
