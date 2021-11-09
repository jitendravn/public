<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DataTables;

class BlogController extends Controller
{
    
    public function index(Request $request)
    {
        $blog = Blog::all();
       
        
        return view('Blog.index', compact('blog'));
    }


    public function store(Request $request)
    {

        $blog = new Blog();
        $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'author' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg',
            ]);
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
        return back()->with('status', 'Blog Added Successfully');
    }



    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('Blog.edit', compact('blog'));
    }


    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'author' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg',
            ],

        );
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
        return redirect('/blog')->with('update', 'Blog Updated Successfully');
    }


    public function destroy($id)
    {

        $blog = Blog::find($id);

        if (File::exists("uploads/blog/" . $blog->image)) {
            File::delete("uploads/blog/" . $blog->image);
        }

        $blog->delete();
        if ($blog) {

            return response()->json(['status' => '1', 'msg' => 'Blog Deleted Successfully']);
        } else {
            return response()->json(['status' => '0', 'msg' => 'Something Went wrong']);
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
