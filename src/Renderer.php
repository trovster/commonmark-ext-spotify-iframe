<?php

namespace Surface\CommonMark\Ext\SpotifyIframe;

use InvalidArgumentException;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use Surface\CommonMark\Ext\SpotifyIframe\Iframe;

final class Renderer implements InlineRendererInterface
{
    protected string $size;
    protected string $height;
    protected string $width = '100%';
    protected bool $allowFullScreen;

    public function __construct(string $size, bool $allowFullScreen = false)
    {
        $this->size = $size;
        $this->height = $this->getHeight($size);
        $this->allowFullScreen = $allowFullScreen;
    }

    /** @return \League\CommonMark\HtmlElement|string|null */
    // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (! ($inline instanceof Iframe)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $src = "https://open.spotify.com/embed/{$inline->getUrl()->getType()}/{$inline->getUrl()->getUuid()}";
        $theme = $inline->getUrl()->getTheme();
        $size = $inline->getUrl()->getSize();

        if (null !== $theme) {
            $src .= "?theme={$theme}";
        }

        if (null !== $size) {
            $height = $this->getHeight($size);
        }

        return new HtmlElement('iframe', [
            'width' => $this->width,
            'height' => $height ?: $this->height,
            'src' => $src,
            'frameborder' => 0,
            'allowfullscreen' => $this->allowFullScreen,
            'allow' => 'autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture',
        ]);
    }

    protected function getHeight(string $size): string
    {
        switch ($size) {
            case 'small':
            case 'sm':
                return '80';

            default:
                return '380';
        }
    }
}
