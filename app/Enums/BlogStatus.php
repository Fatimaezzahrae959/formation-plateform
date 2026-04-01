<?php

namespace App\Enums;

enum BlogStatus: string
{
    case Brouillon = 'brouillon';
    case Publie = 'publie';
    case Archive = 'archive';

    public function label(): string
    {
        return match ($this) {
            self::Brouillon => 'Brouillon',
            self::Publie => 'Publié',
            self::Archive => 'Archivé',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Brouillon => 'warning',
            self::Publie => 'success',
            self::Archive => 'danger',
        };
    }
}