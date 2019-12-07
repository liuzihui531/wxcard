<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property integer $cate_id
 * @property string $image
 * @property string $content
 * @property integer $view_count
 * @property integer $is_hot
 * @property integer $create_time
 */
class News extends CActiveRecord {

    /**
     * 获取新闻列表
     * @param type $platform
     * @param type $show_page
     * @param type $pageSize
     * @return type
     */
    public function getList($platform = 'admin', $show_page = true, $pageSize = 10) {
        $criteria = new CDbCriteria();
        //搜索项
        $title = Yii::app()->request->getParam('title', '');
        if ($title) {
            $criteria->addSearchCondition('title', $title);
        }
        if ($platform == 'admin') {
            
        }
        $pager = new CPagination($this->count($criteria));
        if ($show_page) {
            $pager->pageSize = $pageSize;
            $pager->applyLimit($criteria);
        }
        $model = $this->findAll($criteria);
        return array('model' => $model, 'pager' => $pager);
    }

    /*
     * 获取分类
     */

    public function getCateKv($cate_id = 0) {
        $model = Yii::app()->db->createCommand("select id,name from news_category order by sort asc")->queryAll();
        $cate_data = CHtml::listData($model, 'id', 'name');
        if ($cate_id > 0) {
            if (key_exists($cate_id, $cate_data)) {
                return $cate_data[$cate_id];
            }
            return "";
        }
        return $cate_data;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cate_id, view_count, is_hot, create_time', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 128),
            array('cate_id,title', 'required'),
            array('summary', 'length', 'max' => 512),
            array('image', 'length', 'max' => 256),
            array('content', 'safe'),
            array('seo_title', 'length', 'max' => 64),
            array('seo_keyword', 'length', 'max' => 512),
            array('seo_description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, summary, cate_id, image, content, view_count, is_hot, create_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => '标题',
            'summary' => '摘要',
            'cate_id' => '分类',
            'image' => '缩略图',
            'content' => '内容',
            'view_count' => '浏览次数',
            'is_hot' => '是否热门',
            'create_time' => '发布时间',
            'seo_title' => '标题',
            'seo_keyword' => '关键词',
            'seo_description' => '描述',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('summary', $this->summary, true);
        $criteria->compare('cate_id', $this->cate_id);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('view_count', $this->view_count);
        $criteria->compare('is_hot', $this->is_hot);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('seo_title', $this->seo_title, true);
        $criteria->compare('seo_keyword', $this->seo_keyword, true);
        $criteria->compare('seo_description', $this->seo_description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return News the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
