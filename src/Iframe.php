<?php

namespace Surface\CommonMark\Ext\SpotifyIframe;

use League\CommonMark\Inline\Element\AbstractInline;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Contracts\Url;

final class Iframe extends AbstractInline
{
    protected Url $url;

    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }
}
