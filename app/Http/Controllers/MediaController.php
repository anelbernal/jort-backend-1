<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Http\Resources\MediaResource;


class MediaController extends Controller
{
    public function index ()
    {
        //pagination will help improve preformance and reduce memory usage
        $medias = Media::orderBy('id')->paginate(10);
        return MediaResource::collection($medias);
    }

    public function show (Media $media)
    {
        return new MediaResource($media);
    }

    protected function validateRequest ()
    {
        return request()->validate([
            'product_id' => 'required',
            'url' => 'required'
        ]);
    }

    public function store (Request $request)
    {
        $data = $this->validateRequest();

        $media = Media::create($data);

        return (new MediaResource($media))->response()->setStatusCode(201);
    }

    public function update (Request $request, Media $media)
    {
        $request()->validate([
            'url' => 'required'
        ]);

        $media->update($request->only('url'));

        return new MediaResource($media);
    }

    public function destroy (Media $media)
    {
        $media->delete();

        return response()->noContent();
    }
}
