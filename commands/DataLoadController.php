<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Category;
use app\models\News;

class DataLoadController extends Controller
{
    public function actionIndex()
    {
        $category_data = [
			'PHP' => 0,
			'JavaScript' => 0,
			'Go' => 0,
			'Python' => 0,
			'Ruby' => 0,
		];
		
		$news_data = [
			[
				'title' => 'Список полезных инструментов для php разработчика',
				'short' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, similique incidunt facere quam fugit iure tempore nihil excepturi minima officiis! Cum, iure odit doloremque ipsa rem consequatur repellendus provident optio!',
				'category_id' => 'PHP'
			],
			[
				'title' => 'Список полезных инструментов для JavaScript разработчика',
				'short' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, similique incidunt facere quam fugit iure tempore nihil excepturi minima officiis! Cum, iure odit doloremque ipsa rem consequatur repellendus provident optio!',
				'category_id' => 'JavaScript'
			],
			[
				'title' => 'Список полезных инструментов для Go разработчика',
				'short' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, similique incidunt facere quam fugit iure tempore nihil excepturi minima officiis! Cum, iure odit doloremque ipsa rem consequatur repellendus provident optio!',
				'category_id' => 'Go'
			],
			[
				'title' => 'Список полезных инструментов для Python разработчика',
				'short' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, similique incidunt facere quam fugit iure tempore nihil excepturi minima officiis! Cum, iure odit doloremque ipsa rem consequatur repellendus provident optio!',
				'category_id' => 'Python'
			],
			[
				'title' => 'Список полезных инструментов для Ruby разработчика',
				'short' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, similique incidunt facere quam fugit iure tempore nihil excepturi minima officiis! Cum, iure odit doloremque ipsa rem consequatur repellendus provident optio!',
				'category_id' => 'Ruby'
			],
		];
		
		Category::deleteAll();
		News::deleteAll();
		
		foreach($category_data as $title => $data){
			$category = new Category();
			$category->title = $title;
			$category->save();
			$category_data[$title] = $category->id;
		}
		
		foreach($news_data as $n){
			$news = new News();
			$news->title = $n['title'];
			$news->short = $n['short'];
			$news->text  = $n['short'];
			$news->category_id = $category_data[$n['category_id']];
			$news->author_id = 1;
			$news->save();
		}
    }
}
