<?php

namespace Surface\CommonMark\Ext\SpotifyIframe;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\Config\ConfigurationBuilderInterface;
use Nette\Schema\Expect;
use Surface\CommonMark\Ext\SpotifyIframe\Iframe;
use Surface\CommonMark\Ext\SpotifyIframe\Processor;
use Surface\CommonMark\Ext\SpotifyIframe\Renderer;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parsers\Album;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parsers\Artist;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parsers\Playlist;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parsers\Track;

final class Extension implements ExtensionInterface, ConfigurableExtensionInterface
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

    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema('spotify_iframe', Expect::structure([
            'size' => Expect::string('large'),
            'allowfullscreen' => Expect::bool(true),
        ]));
    }

    protected function getSize(EnvironmentBuilderInterface $environment): string
    {
        if ($environment->getConfiguration()->exists('spotify_iframe.size')) {
            return (string) $environment->getConfiguration()->get('spotify_iframe.size');
        }

        return 'large';
    }

    protected function allowFullscreen(EnvironmentBuilderInterface $environment): bool
    {
        if ($environment->getConfiguration()->exists('spotify_iframe.allowfullscreen')) {
            return (bool) $environment->getConfiguration()->get('spotify_iframe.allowfullscreen');
        }

        return true;
    }
}
