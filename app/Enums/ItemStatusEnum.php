<?php

namespace App\Enums;

enum ItemStatusEnum: string
{
    case FREE = 'free';
    case FETCHING = 'fetching';
    case FETCHED = 'fetched';
    case NOT_FOUND = 'not_found';

    public function label(): string
    {
        return match ($this) {
            self::FREE => __('enum.item-status.free'),
            self::FETCHING => __('enum.item-status.fetching'),
            self::FETCHED => __('enum.item-status.fetched'),
            self::NOT_FOUND => __('enum.item-status.not-found'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::FREE => 'zinc',
            self::FETCHING => 'sky',
            self::FETCHED => 'lime',
            self::NOT_FOUND => 'rose',
        };
    }

    public static function default(): self
    {
        return self::FREE;
    }

    public function next(): self
    {
        return match ($this) {
            self::FREE => self::FETCHING,
            self::FETCHING => self::FETCHED,
            self::FETCHED => self::NOT_FOUND,
            default => self::NOT_FOUND,
        };
    }

    public static function doneStatues(): array
    {
        return [
            self::FETCHED->value,
            self::NOT_FOUND->value,
        ];
    }

    public static function notDoneStatues(): array
    {
        return [
            self::FREE->value,
            self::FETCHING->value,
        ];
    }
}
