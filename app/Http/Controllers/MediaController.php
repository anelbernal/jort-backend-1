<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Http\Resources\MediaResource;


class MediaController extends Controller
{
    public function index ()
    {
        $medias = Media::orderBy('id')->get();
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

    public function store ()
    {
        $data = $this->validateRequest();

        $media = Media::create($data);

        return new MediaResource($media);
    }

    public function update (Request $request, Media $media)
    {
        $request()->validate([
            'url' => 'required'
        ]);

        $media->update($request->all());

        return $media;
    }

    public function destroy (Media $media)
    {
        $media->delete();

        return response()->noContent();
    }
}
