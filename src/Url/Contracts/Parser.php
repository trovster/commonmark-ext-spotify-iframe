<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Url\Contracts;

use Surface\CommonMark\Ext\SpotifyIframe\Url\Contracts\Url;

interface Parser
{
    public function parse(string $url): ?Url;

    public function getType(): string;
}
