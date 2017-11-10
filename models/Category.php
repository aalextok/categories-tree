<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
        ];
    }
    
    public function getChildcategories(){
        return $this->hasMany(Category::className(), [
            'parent_id' => 'id'
        ]);
    }
    
    public static function displayCategoryTree($categories){
        $html = "<ul>";
        
        foreach($categories as $category){
            
            $html .= "<li>". \yii\helpers\Html::a($category->name, ['view', 'id'=> $category->id]);
            
            // Edit button
            $html .= " ".\yii\helpers\Html::a('edit', ['update', 'id' => $category->id], ['class' => 'btn btn-primary']);
            // Delete button
            $html .= " ".\yii\helpers\Html::a('delete', ['delete', 'id' => $category->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
            // Button to create child category:
            $html .= " ".\yii\helpers\Html::a('add child', ["create?parent_id={$category->id}"], ['class' => 'btn btn-success']);
            
            if(count($category->childcategories) > 0){
                $html .= self::displayCategoryTree($category->childcategories);
            }
            $html .= "</li>";
        }
        // Button to create new category of the same level:
        $category = reset($categories);
        $parentID = $category ? $category->parent_id : 0;
        $html .= "<li>".\yii\helpers\Html::a('add category', ["create?parent_id=".$parentID], ['class' => 'btn btn-success'])."</li>";
        $html .= "</ul>";
        
        
        return $html;
    }
    
    public function afterDelete() {
        parent::afterDelete();
        foreach($this->childcategories as $childcategory){
            $childcategory->delete();
        }
    }
}
