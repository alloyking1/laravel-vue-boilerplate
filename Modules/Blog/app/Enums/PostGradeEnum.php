<?php

namespace Modules\Blog\Enums;

enum PostGradeEnum: string
{
    case Beginner = 'Beginner';
    case Intermediate = 'Intermediate';
    case Advanced = 'Advanced';

    public function label(): string
    {
        return match($this) {
            self::Beginner => 'Beginner',
            self::Intermediate => 'Intermediate',
            self::Advanced => 'Advanced',
        };
    }
}