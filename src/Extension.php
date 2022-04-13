<?php

namespace Surface\CommonMark\Ext\SpotifyIframe;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
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
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $size = $this->getSize($environment);
        $fullScreen = $this->allowFullscreen($environment);

        $environment
            ->addEventListener(DocumentParsedEvent::class, new Processor([
                new Artist($size),
                new Album($size),
                new Playlist($size),
                new Track($size),
            ]))
            ->addRenderer(Iframe::class, new Renderer(
                $size,
                $fullScreen
            ))
        ;
    }

    protected function getSize(EnvironmentBuilderInterface $environment): string
    {
        if ($environment->getConfiguration()->exists('spotify_size')) {
            return (string) $environment->getConfiguration()->get('spotify_size');
        }

        return 'large';
    }

    protected function allowFullscreen(EnvironmentBuilderInterface $environment): bool
    {
        if ($environment->getConfiguration()->exists('spotify_allowfullscreen')) {
            return (bool) $environment->getConfiguration()->get('spotify_allowfullscreen');
        }

        return true;
    }
}
