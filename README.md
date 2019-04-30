# Module seo

Module for PIXELION CMS

[![Latest Stable Version](https://poser.pugx.org/panix/mod-seo/v/stable)](https://packagist.org/packages/panix/mod-seo)
[![Latest Unstable Version](https://poser.pugx.org/panix/mod-seo/v/unstable)](https://packagist.org/packages/panix/mod-seo)
[![Total Downloads](https://poser.pugx.org/panix/mod-seo/downloads)](https://packagist.org/packages/panix/mod-seo)
[![Monthly Downloads](https://poser.pugx.org/panix/mod-seo/d/monthly)](https://packagist.org/packages/panix/mod-seo)
[![Daily Downloads](https://poser.pugx.org/panix/mod-seo/d/daily)](https://packagist.org/packages/panix/mod-seo)
[![License](https://poser.pugx.org/panix/mod-seo/license)](https://packagist.org/packages/panix/mod-seo)


## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

#### Either run

```
php composer.phar require --prefer-dist panix/mod-seo "*"
```

or add

```
"panix/mod-seo": "*"
```

to the require section of your `composer.json` file.

#### Add to web config.
```
'modules' => [
    'seo' => ['class' => 'panix\mod\seo\Module'],
],
```

#### Migrate
```
php yii migrate --migrationPath=vendor/panix/mod-seo/migrations
```


> [![PIXELION CMS!](https://pixelion.com.ua/uploads/logo.svg "PIXELION CMS")](https://pixelion.com.ua)  
<i>Content Management System "PIXELION CMS"</i>  
[www.pixelion.com.ua](https://pixelion.com.ua)

> The module is under development, any moment can change everything.
