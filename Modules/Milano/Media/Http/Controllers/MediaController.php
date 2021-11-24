<?php

namespace Milano\Media\Http\Controllers;

use App\Http\Controllers\Controller;
use Milano\Media\Models\Media;
use Milano\Media\Services\MediaFileService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function download(Media $media, Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        return MediaFileService::stream($media);
    }
}
