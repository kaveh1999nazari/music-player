<?php

namespace App\Trait;

trait SanitizesTitle
{
    public function sanitizeTitle(string $title): string
    {
        $title = preg_replace('/[^\p{Arabic}a-zA-Z0-9_-]+/u', '_', $title);
        return trim($title, '_');
    }
}

