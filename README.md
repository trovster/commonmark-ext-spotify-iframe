# Spotify iframe extension

An extension for [league/commonmark](https://github.com/thephpleague/commonmark)
version 1. to replace Spotify links with the embed iframe. Initially based on
the [YouTube extension](https://github.com/zoonru/commonmark-ext-youtube-iframe).

The extension supports for tracks, artists, albums and playlists using the embed
URL format.

## Install

```bash
composer require surface/commonmark-ext-spotify-iframe
```

## Examples

```php
use League\CommonMark\CommonMarkConverter as Converter;
// use League\CommonMark\GithubFlavoredMarkdownConverter as Converter;
use League\CommonMark\Environment;
use Surface\CommonMark\Ext\SpotifyIframe\Extension as SpotifyExtension;

$environment = Environment::createCommonMarkEnvironment();
$environment->addExtension(new SpotifyExtension());

$config = [
    'spotify_size' => 'large',
];

$converter = new Converter($config, $environment);

echo $converter->convertToHtml('[](https://open.spotify.com/embed/artist/xxx)');
echo $converter->convertToHtml('[](https://open.spotify.com/embed/track/xxx?theme=0)');
echo $converter->convertToHtml('[](https://open.spotify.com/embed/album/xxx?theme=1&size=small)');
echo $converter->convertToHtml('[](https://open.spotify.com/embed/playlist/xxx?theme=1&size=lg)');
```

### Sizes

Spotify provides two different sizes, `large` and `small`. By default the
extension provides the `large` version. You can configure the option globally
using the `spotify_size` option.

You can also configure the *size* option using a query parameter on the embed
URL. The supported sizes are `large`, `lg`, `small` and `sm`.

```html
?size=large
?size=small
?size=lg
?size=sm
```
