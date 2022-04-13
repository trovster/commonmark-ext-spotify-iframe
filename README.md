# Spotify iframe extension

An extension for [league/commonmark](https://github.com/thephpleague/commonmark)
version 2 built using PHP 8.0. This replaces Spotify links with the embed iframe.

The extension supports for tracks, artists, albums and playlists using the embed
URL format.

Initially based on the [YouTube extension](https://github.com/zoonru/commonmark-ext-youtube-iframe).

## Installation

The project should be installed via Composer:

```bash
composer require surface/commonmark-ext-spotify-iframe
```

## Usage

Configure your CommonMark `Environment` and add the extension.

```php
use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter as Converter;
use Surface\CommonMark\Ext\SpotifyIframe\Extension as SpotifyExtension;

$options = [
    'spotify_size' => 'large',
];

$environment = new Environment($options);
$environment->addExtension(new SpotifyExtension());

$converter = new Converter($environment);

echo $converter->convert('[](https://open.spotify.com/embed/artist/xxx)');
echo $converter->convert('[](https://open.spotify.com/embed/track/xxx?theme=0)');
echo $converter->convert('[](https://open.spotify.com/embed/album/xxx?theme=1&size=small)');
echo $converter->convert('[](https://open.spotify.com/embed/playlist/xxx?theme=1&size=lg)');
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

## Testing

There are Unit and Integration tests for the project. These can be run using
the following commands:

```bash
composer test
composer run test
composer run test-unit
composer run test-integration
```

There are also scripts to run code sniffer, mess detector and static analysis:

```bash
composer run sniff
composer run mess
composer run stan
```

## Changelog

Please refer to the [CHANGELOG](CHANGELOG.md) for more information on what has
changed recently.

## License

This library is licensed under the MIT license. See the
[License File](LICENSE.md) for more information.
