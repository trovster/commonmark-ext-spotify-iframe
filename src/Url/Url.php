<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Url;

use Surface\CommonMark\Ext\SpotifyIframe\Url\Contracts\Url as Contract;

final class Url implements Contract
{
    protected string $type;
    protected string $uuid;
    protected ?string $size;
    protected ?int $theme;

    public function __construct(string $type, string $uuid, ?string $size = null, ?int $theme = null)
    {
        $this->type = $type;
        $this->uuid = $uuid;
        $this->size = $size;
        $this->theme = $theme;
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
