<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Tests\Unit\Url;

use ReflectionClass;
use Surface\CommonMark\Ext\SpotifyIframe\Tests\TestCase;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Parser;

/** @group parser */
final class ParserTest extends TestCase
{
    protected Parser $parser;

    /** @test */
    public function getType(): void
    {
        $this->assertSame('example', $this->parser->getType());
    }

    /** @test */
    public function isTypeFailsToParse(): void
    {
        $url = '';

        $result = $this->invokeMethod($this->parser, 'isType', [
            $url,
        ]);

        $this->assertFalse($result);
    }

    /** @test */
    public function isTypeFails(): void
    {
        $url = 'example/item';

        $result = $this->invokeMethod($this->parser, 'isType', [
            $url,
        ]);

        $this->assertFalse($result);
    }

    /** @test */
    public function isTypeDoesNotMatch(): void
    {
        $url = 'https://example.com/embed/test/';

        $result = $this->invokeMethod($this->parser, 'isType', [
            $url,
        ]);

        $this->assertFalse($result);
    }

    /** @test */
    public function isTypeIsCorrect(): void
    {
        $url = 'https://example.com/embed/example/';

        $result = $this->invokeMethod($this->parser, 'isType', [
            $url,
        ]);

        $this->assertTrue($result);
    }

    /** @test */
    public function getUuidFails(): void
    {
        $url = '';

        $result = $this->invokeMethod($this->parser, 'getUuid', [
            $url,
        ]);

        $this->assertNull($result);
    }

    /** @test */
    public function getUuidFailsToParse(): void
    {
        $url = 'https://example.com/embed/example/';

        $result = $this->invokeMethod($this->parser, 'getUuid', [
            $url,
        ]);

        $this->assertNull($result);
    }

    /** @test */
    public function getUuidCorrectly(): void
    {
        $uuid = uniqid();
        $url = "https://example.com/embed/example/{$uuid}";

        $result = $this->invokeMethod($this->parser, 'getUuid', [
            $url,
        ]);

        $this->assertSame($uuid, $result);
    }

    /** @test */
    public function getSizeDefault(): void
    {
        $uuid = uniqid();
        $url = "https://example.com/example/{$uuid}";

        $result = $this->invokeMethod($this->parser, 'getSize', [
            $url,
        ]);

        $this->assertSame('large', $result);
    }

    /** @test */
    public function getSizeDefaultConfiguredWithParse(): void
    {
        $uuid = uniqid();
        $url = "https://example.com/example/{$uuid}";
        $parser = $this->getMockForAbstractClass(Parser::class, [
            'small',
        ], 'Example');

        $result = $this->invokeMethod($parser, 'getSize', [
            $url,
        ]);

        $this->assertSame('small', $result);
    }

    /**
     * @test
     * @dataProvider sizesProvider
     * @param int|string $size
     */
    public function getSizeCorrectly($size, string $same): void
    {
        $uuid = uniqid();
        $url = "https://example.com/embed/example/{$uuid}?size={$size}";

        $result = $this->invokeMethod($this->parser, 'getSize', [
            $url,
        ]);

        $this->assertSame($same, $result);
    }

    /** @test */
    public function urlWithoutTheme(): void
    {
        $uuid = uniqid();
        $url = "https://example.com/example/{$uuid}";

        $result = $this->invokeMethod($this->parser, 'getTheme', [
            $url,
        ]);

        $this->assertNull($result);
    }

    /**
     * @test
     * @dataProvider themesProvider
     * @param int|string $theme
     */
    public function urlWithTheme($theme, int $same): void
    {
        $uuid = uniqid();
        $url = "https://example.com/example/{$uuid}?theme={$theme}";

        $result = $this->invokeMethod($this->parser, 'getTheme', [
            $url,
        ]);

        $this->assertSame($same, $result);
    }

    protected function setUp(): void
    {
        $this->parser = $this->getMockForAbstractClass(Parser::class, [], 'Example');
    }

    /** @return mixed */
    protected function invokeMethod(object $object, string $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
