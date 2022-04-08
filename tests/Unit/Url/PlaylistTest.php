<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Tests\Unit\Url;

use Surface\CommonMark\Ext\SpotifyIframe\Tests\TestCase;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Contracts\Url;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parsers\Playlist as Parser;

/** @group playlist */
final class PlaylistTest extends TestCase
{
    protected Parser $parser;
    protected string $uuid;
    protected string $url;

    /** @test */
    public function urlParsed(): void
    {
        $url = $this->parser->parse($this->url);

        $this->assertSame('playlist', $this->parser->getType());

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('playlist', $url->getType());
        $this->assertSame('large', $url->getSize());
        $this->assertSame($this->uuid, $url->getUuid());
        $this->assertNull($url->getTheme());
    }

    /**
     * @test
     * @dataProvider themesProvider
     * @param int|string $theme
     */
    public function urlWithTheme($theme, int $result): void
    {
        $url = $this->parser->parse("{$this->url}?theme={$theme}");

        $this->assertSame('playlist', $this->parser->getType());

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('playlist', $url->getType());
        $this->assertSame('large', $url->getSize());
        $this->assertSame($result, $url->getTheme());
    }

    /**
     * @test
     * @dataProvider sizesProvider
     * @param int|string $size
     */
    public function urlWithSize($size, string $result): void
    {
        $url = $this->parser->parse("{$this->url}?size={$size}");

        $this->assertSame('playlist', $this->parser->getType());

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('playlist', $url->getType());
        $this->assertSame($result, $url->getSize());
    }

    /** @test */
    public function incorrectType(): void
    {
        $url = $this->parser->parse('');

        $this->assertSame('playlist', $this->parser->getType());
        $this->assertNull($url);
    }

    /** @test */
    public function noUuid(): void
    {
        $url = $this->parser->parse('https://open.spotify.com/embed/playlist/');

        $this->assertSame('playlist', $this->parser->getType());
        $this->assertNull($url);
    }

    protected function setUp(): void
    {
        $this->parser = new Parser();
        $this->uuid = uniqid();
        $this->url = "https://open.spotify.com/embed/playlist/{$this->uuid}";
    }
}
