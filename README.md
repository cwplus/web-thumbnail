Webthumbnail
===========

This module ZF2 will help you to generate screenshots of your website based on the API webthumbnail.org

Installation
------------
#### With composer

1. Add to your `composer.json`:

    ```json
    "require": {
        "cwplus/web-thumbnail": "dev-master"
    }
    ```

2. Now tell composer to download MvlabsSnappy by running the command:

    ```bash
    $ php composer.phar update
    ```

#### Or just clone the repos:
    
    # Install ZF2 Module
    git clone https://github.com/cwplus/web-thumbnail.git vendor/cwplus/web-thumbnail
    

#### Post installation

1. Enabling it in your `application.config.php`file.

    ```php
    <?php
    return array(
        'modules' => array(
            // ...
            'Webthumbnail',            
        ),
        // ...
    );
    ```

Configuration
-------------
After installing Webthumbnail, copy
`./vendor/cwplus/Webthumbnail/config/webthumbnail.local.php.dist` to
`./config/autoload/webthumbnail.local.php` and change the binaries path  and add path to saved web thumbs image.


    # /config/autoload/webthumbnail.local.php
```php    
<?php
return array(
    'webthumbnail'=>array(
        'path'=> './public/files/site/',
    )
);
```

Usage
-----

The module registers one service : WebthumbnailService  

### Calling webthumbnail Service

     $WebthumbnailService = $this->serviceLocator->get('WebthumbnailService')->setUrl('http://www.creationwebplus.be');

### If you want to change the folder to save of screenshots website

     $WebthumbnailService = WebthumbnailService->setPath('./public/files/site/');

### If you want to declare the width or height of the image created : ( 100 < width < 500; 100 < height < 500 )

#### Width: 

    $WebthumbnailService = WebthumbnailService->setWidth(250);

#### Height:

    $WebthumbnailService = WebthumbnailService->setHeight(250);

### If you want to declare image format ( supprted format : jpg,png, or gif )

    $WebthumbnailService = WebthumbnailService->setFormat('png');

### If you want to declare image format ( supprted format : jpg,png, or gif )

    $WebthumbnailService = WebthumbnailService->setFormat('png');

### If you wante to declare a screen resolution (1024, 1280, 1650 or 1920) :

    $WebthumbnailService = WebthumbnailService->setScreen(1024);

### Save a screenshot to path

     $WebthumbnailService->captureToFile('screenshot.png');

### Generate a screenshot from an URL

     $WebthumbnailService->captureToOutput();
     



Credits
-------

Webthumbnail module is based on the API of webthumbnail.org

[webthumbnail]: https://github.com/cwplus/web-thumbnail.git

    
    
