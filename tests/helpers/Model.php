<?php
/**
 * Yii2 Translit Validator
 *
 * This file contains model for testing.
 *
 * @author  Martin Stolz <herr.offizier@gmail.com>
 */

namespace herroffizier\yii2tv\tests\helpers;

use herroffizier\yii2tv\TranslitValidator;

class Model extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['attribute_translit'],
                TranslitValidator::className(),
                'sourceAttribute' => 'attribute',
                'on' => 'validator',
            ],
            [
                ['attribute_translit'],
                TranslitValidator::className(),
                'sourceAttribute' => 'attribute',
                'forUrl' => false,
                'on' => 'validatorNoUrl',
            ],
            [
                ['attribute_translit'],
                TranslitValidator::className(),
                'sourceAttribute' => 'attribute',
                'lowercase' => false,
                'on' => 'validatorNoLowercase',
            ],
            [
                ['attribute_translit'],
                TranslitValidator::className(),
                'sourceAttribute' => 'attribute',
                'invalidReplacement' => '_',
                'on' => 'validatorCustomInvalidReplacement',
            ],
            [
                ['attribute_translit'],
                TranslitValidator::className(),
                'sourceAttribute' => 'attribute',
                'invalidRegexp' => '/[^a-z0-9_]+/i',
                'on' => 'validatorCustomInvalidRegexp',
            ],
            [
                ['attribute_translit'],
                TranslitValidator::className(),
                'sourceAttribute' => 'attribute',
                'trimInvalid' => true,
                'on' => 'validatorTrimInvalid',
            ],
            [['attribute', 'attribute_translit'], 'required'],
            [['attribute', 'attribute_translit'], 'string', 'max' => 255],
        ];
    }
}
