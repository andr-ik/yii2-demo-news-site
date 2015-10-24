<?php

namespace app\models\entity;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $image
 * @property string $short
 * @property string $text
 * @property integer $category_id
 * @property integer $author_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $views
 * @property integer $status
 *
 * @property User $author
 * @property Category $category
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'short', 'text', 'category_id', 'author_id'], 'required'],
            [['text'], 'string'],
            [['category_id', 'author_id', 'created_at', 'updated_at', 'views', 'status'], 'integer'],
            [['slug', 'title', 'image'], 'string', 'max' => 255],
            [['short'], 'string', 'max' => 1024],
            [['slug'], 'unique'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Title',
            'image' => 'Image',
            'short' => 'Short',
            'text' => 'Text',
            'category_id' => 'Category ID',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'views' => 'Views',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
	
	public function behaviors()
	{
		return [
			[
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'title',
				'slugAttribute' => 'slug',
			],
		];
	}
}
