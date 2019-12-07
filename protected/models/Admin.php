<?php

/**
 * This is the model class for table "admin".
 *
 * The followings are the available columns in table 'admin':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property integer $last_login
 * @property string $last_ip
 * @property integer $role_id
 * @property integer $login_num
 * @property string $create_by
 * @property integer $created
 */
class Admin extends CActiveRecord {

    public $password2;

    public function getStatus($key = '') {
        $return = array(
            '0' => '禁用',
            '1' => '启用',
        );
        if (key_exists($key, $return)) {
            return $return[$key];
        }
        return $return;
    }

    public function getList($show_page = true, $limit = 10) {
        $criteria = new CDbCriteria();
        $criteria->order = 'id desc';
        $search_c = Yii::app()->request->getParam('search_condition', '');
        $search_v = Yii::app()->request->getParam('search_value', '');
        
        if (in_array($search_c, array('username')) && $search_v) {
            $criteria->addSearchCondition($search_c, $search_v);
        }
        $pager = new CPagination(Admin::model()->count($criteria));

        if ($show_page || $export_limit) {
            $pager->pageSize = $limit;
            $pager->applyLimit($criteria);
        }
        $model = Admin::model()->findAll($criteria);
        return array('model' => $model, 'pager' => $pager);
    }

    public function getAdmin() {
        return $this->findByAttributes(array('username' => 'admin'));
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'admin';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status, last_login, role_id, login_num, created', 'numerical', 'integerOnly' => true),
            array('username, create_by', 'length', 'max' => 16),
            array('username', 'unique'),
            array('username', 'required', 'on' => 'create'),
            array('password', 'required', 'on' => 'create'),
            //array('password2','required','on'=>'create'),
            //array('password2', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码不一致'),
            array('password, last_ip', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, status, last_login, last_ip, role_id, login_num, create_by, created', 'safe', 'on' => 'search'),
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
            'username' => '客服用户名',
            'password' => '密码',
            'status' => '状态',
            'last_login' => '最后登录时间',
            'last_ip' => '最后登录ip',
            'role_id' => '角色',
            'login_num' => '登录次数',
            'create_by' => '创建人',
            'created' => '创建时间',
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
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('last_login', $this->last_login);
        $criteria->compare('last_ip', $this->last_ip, true);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('login_num', $this->login_num);
        $criteria->compare('create_by', $this->create_by, true);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Admin the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
