<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Url;

use Surface\CommonMark\Ext\SpotifyIframe\Url\Contracts\Url as Contract;

final class Url implements Contract
{
    public function __construct(
        protected string $type,
        protected string $uuid,
        protected ?string $size = null,
        protected ?int $theme = null
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getSize(): string
    {
        return $this->size ?? 'large';
    }

    public function getTheme(): ?int
    {
        return $this->theme;
    }
}
