<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $query = Gallery::with('user', 'images');
        if ($filter) {
            $query = $query->where('name', 'like', "%$filter%")
                ->orWhere('description', 'like', "%$filter%")
                ->orWhereHas('user', function ($q) use ($filter) {
                    $q->where('first_name', 'like', "%$filter%")
                        ->orWhere('last_name', 'like', "%$filter%");
                });
        }
        $galleries = $query->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($galleries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGalleryRequest $request)
    {
        $gallery = Auth::user()->galleries()->create($request->validated());
        $order = 1;
        foreach ($request->images as $image_url) {
            $gallery->images()->create(compact('image_url', 'order'));
            $order++;
        }
        $gallery->images;
        return response()->json($gallery);
    }


    public function myGalleries(Request $request)
    {
        $filter = $request->query('filter');
        $query = Auth::user()->galleries()->with('user', 'images');

        if ($filter) {
            $query = $query->where('name', 'like', "%$filter%")->orWhere('description', 'like', "%$filter%")->orWhere("description", 'like', "%$filter%");
        }
        $galleries = $query->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($galleries);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
    }
}
