Yii2 Attribute Index Validator
==============================

[![Build Status](https://travis-ci.org/herroffizier/yii2-translit-validator.svg?branch=master)](https://travis-ci.org/herroffizier/yii2-translit-validator) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/herroffizier/yii2-translit-validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/herroffizier/yii2-translit-validator/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/herroffizier/yii2-translit-validator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/herroffizier/yii2-translit-validator/?branch=master) [![Code Climate](https://codeclimate.com/github/herroffizier/yii2-translit-validator/badges/gpa.svg)](https://codeclimate.com/github/herroffizier/yii2-translit-validator)

This validator takes value from one attribute and puts transliterated value to another attribute. Also, validator may prepare transliterated string for usage in URL. Transliteration is made by [URLify](https://github.com/jbroadway/urlify).

Installation
------------

Install validator with Composer:

```
composer require --prefer-dist "herroffizier/yii2-translit-validator:dev-master"
```

Usage
-----

Add validator to your model's rules array before ```required``` validator (if any) and set its ```sourceAttribute``` property to
point source attribute which value should be transliterated.

```php
use herroffizier\yii2tv\TranslitValidator;

...

public function rules()
{
    return [
        [['attribute'], 'required'],
        [
            ['attribute_translit'], 
            TranslitValidator::className(), 
            'sourceAttribute' => 'attribute'
        ],
        [['attribute_translit'], 'required'],
    ];
}
```

Validator has a few options to customize its behavior.

* ```sourceAttribute``` as mentioned above points to source attribute which value should be transliterated. Empty by default and required.
* ```lowercase``` enforces lower case for transliterated string. Default is ```true```.
* ```forUrl``` replaces all invalid characters with ```invalidReplacement``` value. Default is ```true```.
* ```invalidReplacement``` is a replacement for invalid characters. Used in conjunction with ```forUrl```. Default is ```-```.
* ```invalidRegexp``` is a regular expression which matches all incorrect symbols for URL. Used in conjunction with ```forUrl```. Default is ```/[^a-z0-9]+/i``` which matches all non-alphanumeric symbols.
* ```trimInvalid``` trims invalid characters at beginning and at end of given string. Used in conjunction with ```forUrl```. Default is ```false``` which means that no characters will be trimmed.