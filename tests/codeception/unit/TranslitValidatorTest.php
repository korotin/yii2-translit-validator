<?php
/**
 * Yii2 Translit Validator
 *
 * This file contains validator test.
 *
 * @author  Martin Stolz <herr.offizier@gmail.com>
 */

namespace herroffizier\yii2tv\tests\codeception\unit;

use Codeception\Specify;
use yii\codeception\TestCase;
use herroffizier\yii2tv\tests\helpers\Model;

class TranslitValidatorTest extends TestCase
{
    use Specify;

    public function testValidator()
    {
        $this->specify('model is not saved with disabled validator', function () {
            $model = new Model();
            $model->attribute = 'Проверка связи';
            $this->assertFalse($model->save());
        });

        $this->specify('ignored empty value', function () {
            $model = new Model();
            $model->scenario = 'validator';
            $this->assertFalse($model->save());
            $this->assertEmpty($model->attribute_translit);
        });

        $this->specify('non-empty value is saved', function () {
            $model = new Model();
            $model->scenario = 'validator';
            $model->attribute = 'Проверка связи';
            $model->attribute_translit = 'test';
            $this->assertTrue($model->save());
            $this->assertEquals('test', $model->attribute_translit);
        });

        $this->specify('model is saved with enabled validator', function () {
            $model = new Model();
            $model->scenario = 'validator';
            $model->attribute = 'Проверка связи';
            $this->assertTrue($model->save());
            $this->assertEquals('proverka-svyazi', $model->attribute_translit);
        });

        $this->specify('url flag is respected', function () {
            $model = new Model();
            $model->scenario = 'validatorNoUrl';
            $model->attribute = 'Проверка связи';
            $this->assertTrue($model->save());
            $this->assertEquals('proverka svyazi', $model->attribute_translit);
        });

        $this->specify('lowercase flag is respected', function () {
            $model = new Model();
            $model->scenario = 'validatorNoLowercase';
            $model->attribute = 'Проверка связи';
            $this->assertTrue($model->save());
            $this->assertEquals('Proverka-svyazi', $model->attribute_translit);
        });

        $this->specify('custom invalid replacement is respected', function () {
            $model = new Model();
            $model->scenario = 'validatorCustomInvalidReplacement';
            $model->attribute = 'Проверка связи';
            $this->assertTrue($model->save());
            $this->assertEquals('proverka_svyazi', $model->attribute_translit);
        });

        $this->specify('custom invalid regexp is respected', function () {
            $model = new Model();
            $model->scenario = 'validatorCustomInvalidRegexp';
            $model->attribute = 'Проверка_связи';
            $this->assertTrue($model->save());
            $this->assertEquals('proverka_svyazi', $model->attribute_translit);
        });
    }
}
