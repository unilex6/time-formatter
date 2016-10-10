Time Formatter
==============

## Instalation

1. Add following line into `require` section in your `composer.json`:
```json
    "require": {
        "unilex6/time-formatter": "dev-master"
    }
```
2. If you want to install package directly from GitHub, you need to add following line into `repositories` section in your `composer.json` to set up composer`s package source path:
```json
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/unilex6/time-formatter"
        }
    ]
```

## Basic Usage

```php
$time = 1450224000; // 16th of December timestamp
TimeFormatter::time($time); // -> 16 дек в 03:00
TimeFormatter::time($time, ['locale' => TimeFormatter::LOCALE_EN]); // -> 16 dec in 03:00

$time = 1450224000; // Yesterday timestamp, for example
TimeFormatter::time($time); // -> Вчера в 03:00
TimeFormatter::time($time, ['locale' => TimeFormatter::LOCALE_EN]); // -> Yesterday at 03:00
```

@TODO: Extended docs