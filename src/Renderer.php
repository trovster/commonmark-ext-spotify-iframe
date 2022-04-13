<?php

namespace Surface\CommonMark\Ext\SpotifyIframe;

use InvalidArgumentException;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Surface\CommonMark\Ext\SpotifyIframe\Iframe;

final class Renderer implements NodeRendererInterface
{
    protected string $height;
    protected string $width = '100%';

    public function __construct(protected string $size, protected bool $allowFullScreen = false)
    {
        $this->height = $this->getHeight($size);
    }

    /** @return \League\CommonMark\Util\HtmlElement|string|null */
    // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function render(Node $inline, ChildNodeRendererInterface $htmlRenderer)
    {
        if (! ($inline instanceof Iframe)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . $inline::class);
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
            'width' => (string) $this->width,
            'height' => (string) ($height ?: $this->height),
            'src' => $src,
            'frameborder' => '0',
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
