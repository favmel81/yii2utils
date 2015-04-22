<?php

namespace yii2utils\widgets;

use Yii;
use yii\base\Widget;
use yii2utils\web\BreadCrumbsStack;

class Breadcrumbs extends Widget {

    /**
     * @var string path to widget view
     * typical usage of BreadCrumbsStack - class object in the view:
     *
     *             foreach($breadcrumbs->getLinks() as $link) {
     *                  $link->index - this item zero-based index in stack
     *                  $link->number = $link->index + 1
     *                  $link->count - total count of the items in stack
     *                  $link->url = url|false
     *                  $link->title - this item title
     *                  $link->first - is this item the very first
     *                  $link->last - is this item the very last     *
     *             }
     */

    public $template = '//widgets/breadcrumbs';
    public $homeRoute = 'index/index';
    public $hideOnHome = true;
    public $hideOnError = true;


    public function run() {

        $breadcrumbs = Yii::$app->breadcrumbs;
        if(
            $this->hideOnHome && Yii::$app->controller->getRoute() == $this->homeRoute
                || $this->hideOnError && Yii::$app->controller->getRoute() == Yii::$app->getErrorHandler()->errorAction
            || Yii::$app->breadcrumbs->count() == 0


        ) {
            return;
        }
        return $this->render($this->template, ['breadcrumbs' => $breadcrumbs]);
    }

}