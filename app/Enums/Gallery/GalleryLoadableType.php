<?php

namespace App\Enums\Gallery;


enum GalleryLoadableType: string
{

    case tag = 'App\Models\Tag';
    case user = 'App\Models\User';
    case article = 'App\Models\Article';
    case global = 'global';

//    public static function fromMorphType(?string $type): GalleryLoadableType
//    {
//        return match ($type) {
//            'App\Models\Tag' => self::tag,
//            'App\Models\Tag' => self::tag,
//            default => self::global,
//        };
//    }
}
