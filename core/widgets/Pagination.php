<?php

namespace favmel81\yii2utils\core\widgets;

use yii\base\Widget;
use favmel81\yii2utils\core\data\Pagination as Datasource;

class Pagination extends Widget {

    /**
     * @var string path to widget view
     * typical usage of Pagination - class object in the view:
     *
     *             foreach($pagination->getPages() as $page) {
     *                  $page - (int) rendering page
     *                  $pagination->first() - the first of the rendering pages
     *                  $pagination->last() - the last of the rendering pages
     *                  $pagination->getPage() - current page
     *                  $pagination->getPagesCount() - total pages count
     *                  $pagination->linksCount - total links count onn this page
     *                  $pagination->createUrl(int) - create link for page
     *             }
     */

    public $template = '//widgets/pagination';
    /**
     * @var Datasource
     */
    public $pagination;
    public $absoluteUrls = false;
    public $params = [];


    public function init() {
        parent::init();
        if(!$this->pagination instanceof Datasource) {
            throw new \Exception('You must set `pagination` parameter !');
        }
        $this->pagination->absoluteUrls = $this->absoluteUrls;
        if($this->params) {
            $this->pagination->params = $this->params;
        }
    }



    public function run() {
        if($this->pagination->getPagesCount() <= 1) {
            return;
        }
        return $this->render($this->template, ['pagination' => $this->pagination, 'params' => $this->params]);

    }

}