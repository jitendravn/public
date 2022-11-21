<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\Blog\BlogResourceCollection;
use App\Models\Blog;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getBlogInfo(Request $request)
    {
        try {
            $id = $request->id;
            $blogs = Blog::whereIn('id', $id)->paginate(2);
            if (!$blogs) {
                throw new \Exception('Blog Not found.');
            }

            return response()->json(new BlogResourceCollection($blogs));
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
