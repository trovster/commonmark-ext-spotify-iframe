<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Tests;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Surface\CommonMark\Ext\SpotifyIframe\Extension;

abstract class TestCase extends BaseTestCase
{
    protected MarkdownConverter $converter;

    public function themesProvider(): iterable
    {
        return [
            yield 'theme is 1' => [1, 1],
            yield 'theme is 0' => [0, 0],
            yield 'theme is a string' => ['x', 0],
        ];
    }

    public function sizesProvider(): iterable
    {
        return [
            yield 'size is large' => ['large', 'large'],
            yield 'size is lg' => ['lg', 'lg'],
            yield 'size is small' => ['small', 'small'],
            yield 'size is sm' => ['sm', 'sm'],
            yield 'size is unknown' => ['xxx', 'large'],
            yield 'size is unknown int' => [1, 'large'],
        ];
    }

    public function sizesWidthProvider(): iterable
    {
        return [
            yield 'small size should have a width of 80' => ['small', 80],
            yield 'sm size should have a width of 80' => ['sm', 80],
            yield 'large size should have a width of 80' => ['large', 380],
            yield 'lg size should have a width of 80' => ['lg', 380],
        ];
    }

    protected function getHtml(string $url, int $height): string
    {
        return '<iframe width="100%" height="' . $height . '" src="' . $url . '" frameborder="0" allowfullscreen allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>';
    }

    protected function setUp(): void
    {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new Extension());

        $this->converter = new MarkdownConverter($environment);
    }
}
