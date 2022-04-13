<?php

namespace Surface\CommonMark\Ext\SpotifyIframe;

use League\CommonMark\Node\Inline\AbstractInline;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Contracts\Url;

final class Iframe extends AbstractInline
{
    public function __construct(protected Url $url)
    {
    }

    public function getUrl(): Url
    {
        return $this->url;
    }
}
