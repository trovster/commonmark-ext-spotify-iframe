<?php

namespace Surface\CommonMark\Ext\SpotifyIframe;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\ExtensionInterface;
use Surface\CommonMark\Ext\SpotifyIframe\Iframe;
use Surface\CommonMark\Ext\SpotifyIframe\Processor;
use Surface\CommonMark\Ext\SpotifyIframe\Renderer;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parsers\Album;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parsers\Artist;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parsers\Playlist;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parsers\Track;

final class Extension implements ExtensionInterface
{
    /** @return void */
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $size = (string) $environment->getConfig('spotify_size', 'large');
        $fullScreen = (bool) $environment->getConfig('spotify_allowfullscreen', true);

        $environment
            ->addEventListener(DocumentParsedEvent::class, new Processor([
                new Artist($size),
                new Album($size),
                new Playlist($size),
                new Track($size),
            ]))
            ->addInlineRenderer(Iframe::class, new Renderer(
                $size,
                $fullScreen
            ))
        ;
    }
}
