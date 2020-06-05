[![hashids](https://hashids.org/public/img/hashids.gif "Hashids")](https://hashids.org/)

[![Build Status](https://badgen.net/github/checks/vinkla/hashids?label=build&icon=github)](https://github.com/vinkla/hashids/actions)
[![Monthly Downloads](https://badgen.net/packagist/dm/hashids/hashids)](https://packagist.org/packages/hashids/hashids/stats)
[![Latest Version](https://badgen.net/packagist/v/hashids/hashids)](https://packagist.org/packages/hashids/hashids)

**Hashids** is a small PHP library to generate YouTube-like ids from numbers. Use it when you don't want to expose your database numeric ids to users: [https://hashids.org/php](https://hashids.org/php)

This is a wrapper around the original `hashids/hashids` package. For basic documentation refer to the original one.

<https://github.com/vinkla/hashids>

The above badges are for the original package. 



# Installation

Require this package, with [Composer](https://getcomposer.org), in the root directory of your project.

```bash
$ composer require dutymess/hashids
```

Then you can enjoy the full features of the [original package](<https://github.com/vinkla/hashids>). Refer to their documentation for more details.

Herein, I just describe what has been added to it.



# Advantages Over the Original Package

1. It's configured for the most-appropriate usages, with alphabets and lengths already set out of the box.
2. The encoder doesn't return an array for a single id. You don't have to worry about array/string conversions.
3. Bypasser is a great tool if you face trouble.
4. The model trait can be used on eloquent models and easily provide hashid tools.
5. You can still enjoy all the benefits provided by the original package, without any overheads.



# Basic Usage

The first thing you need to do is to  define your salt in your `.env` file.

```
HASHID_SALT_MAIN=SomeSaltSomeSaltSomeSaltSomeSaltSomeSaltSomeSaltSomeSalt
```

Hashids must not be used as a means of security, but it is a good practice to redefine the salt per app.

Then, you are ready to convert ids and hashids to each other, through easy helper functions.

```php
hashid(1); 		// returns the hadhis of 1. ex: rolXo
hashid('rolXo') // returns the equivalent id: 1
```

No matter what the input is, the `hashid` function will always switch.

Use the below methods, if you want to be sure the returned data is of the desired type.

```php
hashid_number(1);        // returns 1
hashid_number('rolXo');  // returns 1
hashid_string('rolXo');  // returns 'rolXo'
hashid_string(1);        // returns 'rolXo'
```

All the above methods receive arrays as well. 

```php
hashid([1,2,3]);     // returns ["rolXo", "bVnxk", "LkGjo"]
```



# Model Helpers

As the most important usage of this package is to hide table `id`s, we have introduced a special trait to be used in your model.

```php
<?php

namespace App;

use Hashids\HashidsModelTrait;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HashidsModelTrait;
}
```

Then, the `hashid` accessor is added to your model.

```php
echo $post->id;      // 1
echo $post->hashid;  // rolXo
```

Moreover, a query scope is added to easily filter records by their hashids, instead of ids:

```php
Post::where('title', 'foo')->withHadhis(["rolXo", "bVnxk", "LkGjo"]);
```

It's ok if you include real ids in the array. I.e. You don't have to ensure everything received is in the form of hashids. A mix of real ids and hashids work too.

```php
Post::where('title','foo')->withHashids(["rolXo", 2, "3"])
```



:warning: Never save a hashid in your database. The key can be changed and you will lose your data.



# Easy Bypass

Debugging the app when the hashids are engaged can be a real headache, as you have to constantly convert things in the tinker and see what is what.

To deal with this problem, you can bypass the mechanism in your `.env` file.

```
HASHID_BYPASS=1
```

This will bypass real encryption and just convert ids to an equivalent string to make you easily read the responses and follow the probable bugs.

```php
hashid(1);     // returns 'h1';
hashid('h1');  // returns 1;
```

:warning: Be sure to do this in the development mode only.



# Custom Salts

You can define custom salts and freely use them in your app. 

First, publish the config.

```bash
php artisan vendor:publish
```

The fully-commented config file will be published and you can define as many salts as you may need.

```:warning:
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Salt
    |--------------------------------------------------------------------------
    |
    | These are the salts of encryption. While the helper function use `main`
    | as default salt, you can always pass custom salts too. Just be sure
    | to define salts in your .env file and keep them unique over app.
    |
    */

    'salt'   => [
        "main" => env("HASHID_SALT_MAIN", null),
        "custom" => env("HASHID_SALT_CUSTOM", null),   // <~~ This is custom!
    ],

    /*
    |--------------------------------------------------------------------------
    | Bypass
    |--------------------------------------------------------------------------
    |
    | This is useful when you are in debug/development mode and you got sick
    | of constantly converting hashids and ids to each other and see what
    | is what. You can bypass mechanism by .env file to see real ids.
    |
    */

    "bypass" => (bool)env("HASHID_BYPASS", false),
];

```



The above helper functions can handle your custom salts by receiving a second argument. 

```php
hashid(1, "custom");  
```



# Advanced Usage

Easy switching between ids and hashids is not what you may always want. While the above helper functions are designed to try their best to find the most appropriate values, you may want to have errors if the user submits `id` instead of `hashid`.

The below methods will not automatically convert things.

```:warning:
use Hashids\Wrapper as Hashid;

Hashid::idEncode($matter, string $salt_name = "main");
Hashid::idDecode($matter, string $salt_name = "main")
```

Moreover, you can have more control over the minimum length and the alphabets, using the below methods:

```php
use Hashids\Wrapper as Hashid;

Hashid::encode($matter, string $salt_name = "main", $min_length = 5, $alphabet = null);
Hashid::decode(string $matter, string $salt_name = "main", $min_length = 5, $alphabet = null)
```

Note that passing `null` as the alphabet will instruct the method to use the custom alphabet, which consists of English letters with no digits involved. 

```
abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ
```



# License

To respect the efforts made by the original maintainer, I have not touched any of the licenses. 

[MIT](LICENSE) © [Ivan Akimov](https://barreleye.com/)