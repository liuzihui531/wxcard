<?php

/**
 * This is the model class for table "upload".
 *
 * The followings are the available columns in table 'upload':
 * @property integer $id
 * @property integer $user_type
 * @property integer $user_id
 * @property integer $item_type
 * @property integer $item_id
 * @property string $name
 * @property string $file
 * @property integer $size
 * @property string $ext
 * @property string $uniqid
 * @property integer $created
 */
define('WEBROOT', Yii::getPathOfAlias('webroot') . '/');

class Upload extends CActiveRecord {

    public $uniqid = '';
    private $uploadInfo = array();
    private $allowExt = array('png', 'jpg', 'jpeg', 'gif', 'rar', 'zip', 'gz', 'biz', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt');
    private $error = '';
    private $fileext;
    private $upload_dir;
    public $file_path;
    public $file_url;
    public $file_name;
    public $is_thumb = false;
    public $thumb_type = '';

    
    public function getWebRoot() {
        return WEBROOT;
    }

    public function getImageUrl($size = '') {
        return getImageUrl($this->file, $size);
    }

    public function useImage() {
        $this->allowExt = array('png', 'jpg', 'jpeg', 'gif');
        return $this;
    }

    public function useFile() {
        $this->allowExt = array('zip', 'bz2', 'rar', 'gz', 'tar');
        return $this;
    }

    public function getExt() {
        return $this->fileext;
    }
    public function getErr() {
        return $this->error;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'upload';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, name, file, ext, uniqid,thumbs', 'safe'),
            array('user_type, user_id, item_type, item_id, size, created,status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('file', 'length', 'max' => 50),
            array('ext', 'length', 'max' => 5),
            array('uniqid', 'length', 'max' => 15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_type, user_id, item_type, item_id, name, file, size, ext, uniqid, created,thumbs', 'safe', 'on' => 'search'),
        );
    }

    private function getUploadPath() {
        if (empty($this->file_path)) {
            $this->file_path = '/upload/' . date('ym/dH/i/');
        }
        if (!is_dir(WEBROOT . $this->file_path)) {
            Utils::mk_dir(WEBROOT . $this->file_path);
        }
        return $this->file_path;
    }

    public function getFilePath() {
        return $this->file_path;
    }

    public function uploads($field,$type='image') {
        $file = CUploadedFile::getInstanceByName($field);
        if ($file) { 
            if($type == 'image'){
                $this->useImage();
            }
            $this->fileext = strtolower($file->extensionName);
            if (!in_array($this->fileext, $this->allowExt)) {
                Yii::app()->controller->error('文件类型不允许上传');
                //$this->addError('error', '文件类型不允许上传！');
                return false;
            }
            $this->uniqid = uniqid();
            $this->file_name = $this->uniqid . '.' . $this->fileext;
            $this->file_path = $this->getUploadPath();
            $this->file_url = $this->getUploadPath() . $this->file_name;
            $destination = WEBROOT . $this->file_path . $this->file_name;
            $upload_res = $file->saveAs($destination, true);
            if ($upload_res) {
                $model = new Upload();
                if ($this->is_thumb) {
                    if (!empty($this->thumb_type) && Yii::app()->params['thumb'][$this->thumb_type]) {
                        $thumb_arr = Yii::app()->params['thumb'][$this->thumb_type];
                        foreach ($thumb_arr as $k => $v) {
                            $thumb_size = explode('x', $v);
                            $thumb_width = $thumb_size[0];
                            $thumb_height = $thumb_size[1];
                            $thumb = Yii::app()->thumb;
                            $thumb->image = $destination;
                            $thumb->directory = WEBROOT . $this->file_path;
                            $thumb->width = $thumb_width;
                            $thumb->height = $thumb_height;
                            $thumb->defaultName = $this->uniqid . '_' . $v;
                            $thumb->createThumb();
                            $thumb->save();
                        }
                        $model->thumbs = implode(',', $thumb_arr);
                    }
                }
                $model->status = 1;
                $model->file = $this->file_url;
                $model->size = $file->size;
                $model->name = $this->file_name;
                $model->ext = $this->fileext;
                $model->created = time();
                $model->save();
                return true;
            }else{
                $this->error = $file->getError();
                return false;
            }
        }
    }

    public function unlink($image) {
        if (empty($image)) {
            return true;
        }
        $criteria = new CDbCriteria();
        $criteria->compare('file', $image);
        $model = $this->find($criteria);
        $unlink_arr = array();
        if ($model) {
            $model->status = 2;
            if ($model->save()) {
                $unlink_arr = $this->getThumb($model->file, $model->thumbs);
                $unlink_arr[] = $image;
                foreach ($unlink_arr as $k => $v) {
                    if (is_file(WEBROOT . ltrim($v, '/'))) {
                        @unlink(WEBROOT . ltrim($v, '/'));
                    }
                }
            }else{
                return false;
            }
        }
        return true;
    }

    public function getThumb($file, $thumb) {
        $thumb_info = $this->splitExt($file);
        $return = array();
        foreach (explode(',', $thumb) as $k => $v) {
            $return[] = $thumb_info['pre'] . '_' . $v . '.' . $thumb_info['ext'];
        }
        return $return;
    }

    //把一个图片链接拆分成前面部分和后缀部分
    public function splitExt($file) {
        $index = strrpos($file, '.');
        $pre = substr($file, 0, $index);
        $ext = Utils::fileext($file);
        return array('pre' => $pre, 'ext' => $ext);
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
            'user_type' => 'User Type',
            'user_id' => 'User',
            'item_type' => 'Item Type',
            'item_id' => 'Item',
            'name' => 'Name',
            'file' => 'File',
            'size' => 'Size',
            'ext' => 'Ext',
            'uniqid' => 'Uniqid',
            'created' => 'Created',
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
        $criteria->compare('user_type', $this->user_type);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('item_type', $this->item_type);
        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('file', $this->file, true);
        $criteria->compare('size', $this->size);
        $criteria->compare('ext', $this->ext, true);
        $criteria->compare('uniqid', $this->uniqid, true);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Upload the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
