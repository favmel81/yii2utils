<?php

namespace yii2utils\rest;

use Yii;
use yii\rest\UrlRule as BaseUrlRule;


class UrlRule extends BaseUrlRule
{

    public $patterns = [
        'PUT,PATCH,POST {id}' => 'save',
        'PUT,PATCH,POST' => 'save',
        'DELETE {id}' => 'delete',
        'DELETE' => 'delete',
        'GET,HEAD {id}' => 'view',
        'GET,HEAD' => 'index',
        '{id}' => 'options',
        '' => 'options',
    ];

}
