<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author Dell
 */
class IndexController extends Controller{
    //put your code here
    public function actionIndex(){
        $this->breadcrumbs = array('控制台');
        $this->render('index');
    }
}
