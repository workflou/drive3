<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum TeamType: string implements HasLabel
{
    case Personal = 'personal';
    case Business = 'business';

    public function getLabel(): string | Htmlable | null
    {
        return match ($this) {
            self::Personal => __('Personal'),
            self::Business => __('Business'),
        };
    }
}
