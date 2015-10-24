<?php

namespace app\modules\news\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use app\models\entity\News;
use app\models\entity\Category;

class DefaultController extends Controller
{
	const PAGE_SIZE = 3;
	
	public $layout = '@app/views/layouts/news';
	
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions'=>['index','view'],
					],
					[
						'allow' => true,
						'actions'=>['create','update','delete'],
						'roles' => ['user'],
					],
				],
			],
		];
	}

    public function actionIndex($category=null)
    {
		$query = News::find();
		
		if ( $category !== null && !in_array($category,['all','my']) ){
			$category = Category::find()->where(['slug'=>$category])->one();
			if ( !$category ) throw new NotFoundHttpException('Page not found.');
			$query->where(['category_id'=>$category->id]);
		}
		
		if ( $category === 'my' ){
			if ( Yii::$app->user->isGuest ) $this->redirect('/news');
			else $query->where(['author_id'=>Yii::$app->user->identity->id]);
		}
		
		return $this->render('index',array(
			'dataProvider' => $this->getDataProvider($query),
			'category' => $category
		));
    }
	
	public function actionView($slug)
    {
        return $this->render('view',[
			'model' => $this->findModel($slug)
		]);
    }
	
	public function actionCreate(){
		$model = new News();
		
		$model->load(Yii::$app->request->post());
		$model->author_id = Yii::$app->user->identity->id;
		
        if ($model->save()) {
            return $this->redirect(['view', 'slug' => $model->slug]);
        } else {
            return $this->render('create', [
                'model' => $model,
				'category' => ArrayHelper::map(Category::find()->all(), 'id', 'title')
            ]);
        }
	}
	
	public function actionUpdate($slug)
    {
        $model = $this->findModel($slug);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'slug' => $model->slug]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'category' => ArrayHelper::map(Category::find()->all(), 'id', 'title')
            ]);
        }
    }
	
	public function actionDelete($slug)
    {
        $this->findModel($slug)->delete();

        return $this->redirect(['index']);
    }
	
	private function findModel($slug){
		$model = News::findOne(['slug' => $slug]);
		if ( !$model ) throw new NotFoundHttpException('News was not found.');
		return $model;
	}
	
	private function getDataProvider($query){
		return new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => self::PAGE_SIZE,
				'pageSizeParam' => false,
			],
			'sort' => [
				'defaultOrder' => [
					'created_at' => SORT_DESC,
					'title' => SORT_ASC, 
				]
			],
		]);
	}
}
