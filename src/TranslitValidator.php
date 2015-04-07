<?php
/**
 * Yii2 Translit Validator
 *
 * This file contains validator.
 *
 * @author  Martin Stolz <herr.offizier@gmail.com>
 */

namespace herroffizier\yii2tv;

use URLify;
use yii\validators\Validator;

class TranslitValidator extends Validator
{
    /**
     * Override default behavior of validator - do not skip empty values.
     *
     * @var boolean
     */
    public $skipOnEmpty = false;

    /**
     * Name of attribute which value will be transliterated.
     *
     * @var string
     */
    public $sourceAttribute;

    /**
     * Whether to lower case transliterated string.
     *
     * @var boolean
     */
    public $lowercase = true;

    /**
     * Wheter to prepare transiterated string for URL.
     *
     * If set to true, all invalid characters matched by $invalidRegexp will be
     * replaced with $invalidReplacement string.
     *
     * @var boolean
     */
    public $forUrl = true;

    /**
     * Regular expression that matched invalid characters for URL.
     *
     * By default matches all non-alphanumeric symbols.
     *
     * @var string
     */
    public $invalidRegexp = '/[^a-z0-9]+/i';

    /**
     * String with which all invalid characters will be replaced.
     *
     * @var string
     */
    public $invalidReplacement = '-';

    /**
     * Cached escaped invalid replacement.
     *
     * @var string
     */
    protected $escapedInvalidReplacement = null;

    /**
     * Escape invalid replacement string.
     *
     * @return string
     */
    protected function getEscapedInvalidReplacement()
    {
        if ($this->escapedInvalidReplacement === null) {
            $this->escapedInvalidReplacement = addcslashes($this->invalidReplacement, '[]().?-*^$/:<>');
        }

        return $this->escapedInvalidReplacement;
    }

    /**
     * Prepare string for URL.
     *
     * @param  string $value
     * @return string
     */
    protected function prepareForUrl($value)
    {
        // First, replace all invalid characters with replacement string.
        $value =
            preg_replace(
                $this->invalidRegexp,
                $this->invalidReplacement,
                $value
            );
        // Second, replace all possible repeats of replacement string with single one.
        $value =
            preg_replace(
                '/('.$this->getEscapedInvalidReplacement().'){2,}/',
                $this->invalidReplacement,
                $value
            );

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        // Do not overwrite non-empty values and do not parse empty values.
        if ($model->$attribute || !$model->{$this->sourceAttribute}) {
            return;
        }

        $value = URLify::downcode($model->{$this->sourceAttribute});

        if ($this->lowercase) {
            $value = strtolower($value);
        }

        if ($this->forUrl) {
            $value = $this->prepareForUrl($value);
        }

        $model->$attribute = $value;
    }
}
