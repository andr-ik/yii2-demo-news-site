<?php

namespace app\modules\news\controllers;

use yii\web\Controller;
use yii\web\HttpException;
use yii\data\ActiveDataProvider;

use app\models\entity\News;

class DefaultController extends Controller
{
    public function actionIndex()
    {		
		$dataProvider = new ActiveDataProvider([
			'query' => News::find(),
			'pagination' => [
				'pageSize' => 2,
				'pageSizeParam' => false
			],
			'sort' => [
				'defaultOrder' => [
					'created_at' => SORT_DESC,
					'title' => SORT_ASC, 
				]
			],
		]);
		
        return $this->render('index',array(
			'dataProvider' => $dataProvider
		));
    }
	
	public function actionView($slug)
    {
        return $this->render('view',[
			'model' => $this->getModel($slug)
		]);
    }
	
	private function getModel($slug){
		$model = News::findOne(['slug' => $slug]);
		if ( !$model ) throw new NotFoundHttpException('News was not found.');
		return $model;
	}
}
