<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Tests\Integration;

use Surface\CommonMark\Ext\SpotifyIframe\Tests\TestCase;

/** @group track */
final class TrackTest extends TestCase
{
    protected string $type;
    protected string $uuid;
    protected string $url;

    /** @test */
    public function urlConversion(): void
    {
        $markdown = "[]({$this->url})";

        $html = $this->converter->convert($markdown);

        $this->assertStringContainsString($this->getHtml($this->url, 380), $html);
    }

    /** @test */
    public function urlConversionWithTheme(): void
    {
        $url = "{$this->url}?theme=1";
        $markdown = "[]({$url})";

        $html = $this->converter->convert($markdown);

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

        $html = $this->converter->convert($markdown);

        $this->assertStringContainsString($this->getHtml($this->url, $width), $html);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->type = 'track';
        $this->uuid = uniqid();
        $this->url = "https://open.spotify.com/embed/{$this->type}/{$this->uuid}";
    }
}
