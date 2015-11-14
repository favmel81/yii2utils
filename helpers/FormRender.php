<?php


namespace yii2utils\helpers;

use Yii;
use yii\web\Request;
use yii\base\Model;
use yii\helpers\BaseHtml;
use yii2utils\helpers\form\FieldAbstract;



class FormRender
{

    static $fieldTypes = [
        'textfield' => 'yii2utils\helpers\form\TextField',
        'hidden' => 'yii2utils\helpers\form\Hidden',
        'textarea' => 'yii2utils\helpers\form\TextArea',
        'password' => 'yii2utils\helpers\form\Password',
        'captcha' => 'yii2utils\helpers\form\Captcha',
        'radio' => 'yii2utils\helpers\form\Radio',
        'checkbox' => 'yii2utils\helpers\form\Checkbox',
        'select' => 'yii2utils\helpers\form\Select'
    ];


    public static function formErrors(
        $errors, $classes = 'alarm center', $separator = '<br>', $element = 'div'
    ) {


        $classes_ = [];
        if ($classes) {
            if (is_array($classes)) {
                $classes_ = $classes;
            } else {
                $classes = preg_split('/\s+/', $classes);
                foreach ($classes as $class) {
                    $class = trim($class);
                    if ($class) {
                        $classes_[] = $class;
                    }
                }
            }
            $classes_ = array_unique($classes_);
        }

        if(is_string($errors)) {
            $errors = [[$errors]];
        }

        if (is_array($errors)) {
            $_errors = [];
            foreach ($errors as $error) {
                if (is_array($error)) {
                    $_errors[] = $error[0];
                }
            }
            if ($_errors) {
                $class = '';
                if ($classes_) {
                    $class = 'class="' . implode(' ', $classes_) .'"';
                }

                return
                    '<' . $element . ' ' . $class . ' >' . implode(
                        $separator, $_errors
                    ) . '</'
                    . $element . '>';
            }
        }
    }


    public static function formField($model, $type, $name, $attributes = [], $errorClass = 'field-error') {
        if(!isset(self::$fieldTypes[$type])) {
            throw new \Exception('Unknown field type '.$type);
        }

        /**
         * @var $field FieldAbstract
         */
        $field = Yii::createObject([
            'class' => self::$fieldTypes[$type],
            'name' => $name,
            'errorClass' => $errorClass,
            'attributes' => $attributes
        ]);

        if($model instanceof Model) {
            $error = $model->hasErrors($name);
            $value = isset($model->$name)?$model->$name:$model->getAttributes([$name])[$name];
        } else {
            $error = false;
            $value = null;
        }


        $field->setError($error);
        $field->setValue($value);
        return $field->render();
    }

    public static function csrfField()
    {
        $request = Yii::$app->getRequest();
        if ($request instanceof Request) {

            if ($request->enableCsrfValidation) {
                return BaseHtml::hiddenInput(
                    $request->csrfParam, $request->getCsrfToken()
                );
            }
        }
    }

} 