<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Tests\Unit\Url;

use Surface\CommonMark\Ext\SpotifyIframe\Tests\TestCase;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Contracts\Url;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parsers\Artist as Parser;

/** @group artist */
final class ArtistTest extends TestCase
{
    protected Parser $parser;
    protected string $uuid;
    protected string $url;

    /** @test */
    public function urlParsed(): void
    {
        $url = $this->parser->parse($this->url);

        $this->assertSame('artist', $this->parser->getType());

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('artist', $url->getType());
        $this->assertSame('large', $url->getSize());
        $this->assertSame($this->uuid, $url->getUuid());
        $this->assertNull($url->getTheme());
    }

    /**
     * @test
     * @dataProvider themesProvider
     */
    public function urlWithTheme(int|string $theme, int $result): void
    {
        $url = $this->parser->parse("{$this->url}?theme={$theme}");

        $this->assertSame('artist', $this->parser->getType());

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('artist', $url->getType());
        $this->assertSame('large', $url->getSize());
        $this->assertSame($result, $url->getTheme());
    }

    /**
     * @test
     * @dataProvider sizesProvider
     */
    public function urlWithSize(int|string $size, string $result): void
    {
        $url = $this->parser->parse("{$this->url}?size={$size}");

        $this->assertSame('artist', $this->parser->getType());

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('artist', $url->getType());
        $this->assertSame($result, $url->getSize());
    }

    /** @test */
    public function incorrectType(): void
    {
        $url = $this->parser->parse('');

        $this->assertSame('artist', $this->parser->getType());
        $this->assertNull($url);
    }

    /** @test */
    public function noUuid(): void
    {
        $url = $this->parser->parse('https://open.spotify.com/embed/artist/');

        $this->assertSame('artist', $this->parser->getType());
        $this->assertNull($url);
    }

    protected function setUp(): void
    {
        $this->parser = new Parser();
        $this->uuid = uniqid();
        $this->url = "https://open.spotify.com/embed/artist/{$this->uuid}";
    }
}
