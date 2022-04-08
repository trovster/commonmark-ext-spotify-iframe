<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Tests\Integration;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use Surface\CommonMark\Ext\SpotifyIframe\Extension;
use Surface\CommonMark\Ext\SpotifyIframe\Tests\TestCase;

/** @group artist */
final class ArtistTest extends TestCase
{
    protected string $type;
    protected string $uuid;
    protected string $url;

    /** @test */
    public function urlConversion(): void
    {
        $markdown = "[]({$this->url})";

        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new Extension());
        $converter = new CommonMarkConverter([], $environment);

        $html = $converter->convertToHtml($markdown);

        $this->assertStringContainsString($this->getHtml($this->url, 380), $html);
    }

    /** @test */
    public function urlConversionWithTheme(): void
    {
        $url = "{$this->url}?theme=1";
        $markdown = "[]({$url})";

        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new Extension());
        $converter = new CommonMarkConverter([], $environment);

        $html = $converter->convertToHtml($markdown);

        $this->assertStringContainsString($this->getHtml($url, 380), $html);
    }

    /**
     * @test
     * @dataProvider sizesWidthProvider
     */
    public function urlConversionWithSizes(string $size, int $width): void
    {
        $url = "{$this->url}?size={$size}";
        $markdown = "[]({$url})";

        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new Extension());
        $converter = new CommonMarkConverter([], $environment);

        $html = $converter->convertToHtml($markdown);

        $this->assertStringContainsString($this->getHtml($this->url, $width), $html);
    }

    protected function getHtml(string $url, int $size): string
    {
        return '<iframe width="100%" height="' . $size . '" src="' . $url . '" frameborder="0" allowfullscreen="1" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>';
    }

    protected function setUp(): void
    {
        $this->type = 'artist';
        $this->uuid = uniqid();
        $this->url = "https://open.spotify.com/embed/{$this->type}/{$this->uuid}";
    }
}
