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
            'url' => 'required',
            'desc' => 'required'
        ]);
    }

    public function store ()
    {
        $data = $this->validateRequest();

        $media = Media::create($data);

        return new MediaResource($media);
    }

    public function update (Media $media)
    {
        $data = $this->validateRequest();

        $media->update($data);

        return new MediaResource($media);
    }

    public function destroy (Media $media)
    {
        $media->delete();

        return response()->noContent();
    }
}
