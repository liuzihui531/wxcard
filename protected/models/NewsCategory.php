<?php

/**
 * This is the model class for table "news_category".
 *
 * The followings are the available columns in table 'news_category':
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property integer $sort
 * @property integer $created
 * @property string $seo_title
 * @property string $seo_keyword
 * @property string $seo_description
 */
class NewsCategory extends CActiveRecord {

    public function getList($platform = 'admin', $show_page = true, $pageSize = 10) {
        $criteria = new CDbCriteria();
        if ($platform == 'admin') {
            
        }
        $name = Yii::app()->request->getParam('name', '');
        if ($name) {
            $criteria->addSearchCondition('name', $name);
        }
        $criteria->order = "sort asc";
        $pager = new CPagination($this->count($criteria));
        if ($show_page) {
            $pager->pageSize = $pageSize;
            $pager->applyLimit($criteria);
        }
        $model = $this->findAll($criteria);
        return array('model' => $model, 'pager' => $pager);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'news_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pid, sort, created', 'numerical', 'integerOnly' => true),
            array('name, seo_title', 'length', 'max' => 64),
            array('seo_keyword', 'length', 'max' => 512),
            array('seo_description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, pid, sort, created, seo_title, seo_keyword, seo_description', 'safe', 'on' => 'search'),
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
            'name' => '新闻类名称',
            'pid' => 'Pid',
            'sort' => '排序',
            'created' => 'Created',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('pid', $this->pid);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('created', $this->created);
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
     * @return NewsCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
