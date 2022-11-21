<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogResourceCollection extends ResourceCollection
{
    private $pagination;

    public function __construct($resource, $pagination_links = true)
    {
        if ($pagination_links) {
            $this->pagination = [
                'total' => $resource->total(),
                'count' => $resource->count(),
                'per_page' => $resource->perPage(),
                'current_page' => $resource->currentPage(),
                'last_page' => $resource->lastPage(),
                'hasMorePages' => $resource->hasMorePages(),
            ];
            $resource = $resource->getCollection();
        }
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        $collection = [
            'data' => $this->collection->map(function ($value, $key) {
                return new BlogResource($value);
            }),
        ];

        if (is_array($this->pagination)) {
            $collection['pagination'] = $this->pagination;
        }

        return $collection;
    }
}
