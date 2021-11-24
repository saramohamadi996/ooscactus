<?php
return [
    "MediaTypeServices" => [
        "image" => [
            "extensions" => [
                "png", "jpg", "jpeg"
            ],
            "handler" => Milano\Media\Services\ImageFileService::class
        ],
        "video" => [
            "extensions" => [
                "avi", "mp4", "mkv"
            ],
            "handler" => Milano\Media\Services\VideoFileService::class,
        ],
        "zip" => [
            "extensions" => [
                "zip", "rar", "tar"
            ],
            "handler" => Milano\Media\Services\ZipFileService::class
        ]
    ]
];
