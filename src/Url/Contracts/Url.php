<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Url\Contracts;

interface Url
{
    public function getType(): string;

    public function getUuid(): string;

    public function getSize(): string;

    public function getTheme(): ?int;
}
