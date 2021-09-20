# WP Post Gallery Plugin


1. Setup Composer

```bash
$ composer init
```

2. Setup Autoload (psr-4)

```json
{
	"autoload": {
		"psr-4": {"DKTWP\\": "./DKTWP"}
	}
}
```

	* run command below

```bash
$ composer install
```

## Copying Images from FooGallery then importing it in WPEDPG-Gallery

1. List all available Post IDs
```bash
$ wp post list --post_type=foogallery --fields=ID,post_title
```

1. List images IDs from post meta
```bash
$ wp post meta get [FOOGALLERY_POST_ID] foogallery_attachments --format=json | clip 
```