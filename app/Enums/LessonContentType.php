<?php

namespace App\Enums;

enum LessonContentType: string
{
    case Video = 'video';
    case Pdf = 'pdf';
    case Link = 'link';
    case Text = 'text';
}
