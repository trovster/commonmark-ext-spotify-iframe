# Spotify iframe Extension

An extension for [league/commonmark](https://github.com/thephpleague/commonmark)
to replace Spotify links with the embed iframe.

The extension supports for track, artist, album and playlist URLs.

## Install

```bash
composer require surface/commonmark-ext-spotify-iframe
```

## Example

```php
$environment = \League\CommonMark\Environment::createCommonMarkEnvironment();
$environment->addExtension(new \Surface\CommonMark\Ext\SpotifyIframe\Extension());

$converter = new \League\CommonMark\CommonMarkConverter([
    'spotify_size' => 'large',
], $environment);

echo $converter->convertToHtml('[](https://open.spotify.com/embed/artist/2GcFuBRnCRHhOFW4ejfcRg)');
echo $converter->convertToHtml('[](https://open.spotify.com/embed/track/2GcFuBRnCRHhOFW4ejfcRg?theme=0)');
echo $converter->convertToHtml('[](https://open.spotify.com/embed/album/2GcFuBRnCRHhOFW4ejfcRg?theme=1&size=small)');
echo $converter->convertToHtml('[](https://open.spotify.com/embed/playlist/2GcFuBRnCRHhOFW4ejfcRg?theme=1&size=lg)');
```
