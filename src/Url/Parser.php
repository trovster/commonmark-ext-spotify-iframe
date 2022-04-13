<?php

namespace Surface\CommonMark\Ext\SpotifyIframe\Url;

use Surface\CommonMark\Ext\SpotifyIframe\Url\Contracts\Parser as Contract;
use Surface\CommonMark\Ext\SpotifyIframe\Url\Url;

abstract class Parser implements Contract
{
    protected string $host = 'open.spotify.com';
    protected string $theme = 'theme';
    protected string $size = 'size';
    protected array $sizes = [
        'large',
        'lg',
        'small',
        'sm',
    ];
    protected string $type;

    public function __construct(protected string $defaultSize = 'large')
    {
        $this->setType();
    }

    public function parse(string $url): ?Url
    {
        $host = parse_url($url, PHP_URL_HOST);

        if ($host !== $this->host || ! $this->isType($url)) {
            return null;
        }

        $uuid = $this->getUuid($url);

        if (null === $uuid) {
            return null;
        }

        $theme = $this->getTheme($url);
        $size = $this->getSize($url);

        return new Url($this->type, $uuid, $size, $theme);
    }

    public function getType(): string
    {
        return $this->type;
    }

    protected function isType(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (! $path) {
            return false;
        }

        preg_match("#\/embed\/{$this->type}\/#", $path, $matches);

        return 1 === count($matches);
    }

    protected function getUuid(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (! $path) {
            return null;
        }

        preg_match("#\/embed\/{$this->type}\/([A-Za-z0-9]+)\??#", $path, $matches);

        if (2 === count($matches)) {
            return array_pop($matches);
        }

        return null;
    }

    protected function getTheme(string $url): ?int
    {
        $params = $this->getQueryParams($url);

        if (array_key_exists($this->theme, $params) && '' !== $params[$this->theme]) {
            return (int) $params[$this->theme];
        }

        return null;
    }

    protected function getSize(string $url): string
    {
        $params = $this->getQueryParams($url);

        if (
            array_key_exists($this->size, $params) &&
            '' !== $params[$this->size] &&
            in_array($params[$this->size], $this->sizes, true)
        ) {
            return $params[$this->size];
        }

        return $this->defaultSize;
    }

    protected function getQueryParams(string $url): array
    {
        parse_str((string) parse_url($url, PHP_URL_QUERY), $params);

        return $params;
    }

    protected function setType(): self
    {
        if (! isset($this->type)) {
            $paths = explode('\\', static::class);
            $className = array_pop($paths);

            $this->type = strtolower($className);
        }

        return $this;
    }
}
