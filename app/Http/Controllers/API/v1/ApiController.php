<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getBlogInfo(Request $request)
    {
        try {
            $id = $request->id;
            $blog = Blog::where('id', $id)->first();
            if (!$blog) {
                throw new \Exception('Blog Not found.');
            }
            return response()->json(['blog' => $blog]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
