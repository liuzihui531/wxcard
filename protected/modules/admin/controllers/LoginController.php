<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author lzh
 */
class LoginController extends Controller {

//    public function actions() {
//        return array(
//            'captcha' => array(
//                'class' => 'system.web.widgets.captcha.CCaptchaAction',
//                'width' => 70,
//                'height' => 30,
//                'padding' => 0,
//                'minLength' => 4,
//                'maxLength' => 4,
//                'testLimit' => 999,
//            ),
//        );
//    }

    /**
     * 登录代码
     */
    public function actionIndex() {
        $this->layout = 'none';
        $model = new LoginForm('login');
        if (Yii::app()->request->isAjaxRequest) {
            $model->attributes = Yii::app()->request->getParam('LoginForm');
            $validate = $model->validate();
            $login = $model->login();
            if ($validate && $login) {
                $this->handleResult(1,'登录成功',$this->createUrl('/admin'));
            }else{
                $this->handleResult(0,  Utils::getFirstError($model->errors));
            }
        }
        $this->render('index', array('model' => $model));
    }

    /**
     * 注销
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect($this->createUrl('/admin/login'));
    }
    
    public function actionChangepwd(){
        $this->pageTitle = '修改密码';
        $model = new User('changepwd');
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'id-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if(Yii::app()->request->isPostRequest){
            $post = Yii::app()->request->getParam('User');
            $username = Yii::app()->user->name;
            $model = User::model()->findByAttributes(array('username'=>$username));
            $model->setScenario('changepwd');
            $model->username = $username;
            $model->attributes = $post;
            $model->password = Utils::password($model->password);
            $model->password2 = Utils::password($model->password2);
            if($model->validate() && $model->save()){
                $this->success('修改成功');
            }
        }
        $model->password = $model->old_password = $model->password2 = "";
        $this->render('changepwd',array('model'=>$model));
    }

}
