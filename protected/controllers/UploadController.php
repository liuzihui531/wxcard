<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommonController
 *
 * @author lzh
 */
class UploadController extends IndexBaseController {

    //put your code here
    public function actionUe_upload_image() {
        if (isset($_FILES['upfile']['tmp_name']) && !empty($_FILES['upfile']['tmp_name'])) {
            $upload = new Upload();
            $rs = $upload->uploads('upfile');
            if ($rs) {
                echo CJSON::encode(array('url' => $upload->file_url, 'title' => '', 'state' => 'SUCCESS'));
            } else {
                $data['error'] = $upload->getError();
                $data['status'] = 0;
                echo CJSON::encode($data);
            }
        }
    }

    public function actionAjax_upload() {
        $type = Yii::app()->request->getParam('type', 'image');
        if (isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name'])) {
            $upload = new Upload();
            $rs = $upload->uploads('file', $type);
            if ($rs) {
                echo CJSON::encode(array(
                    'url' => $upload->file_url,
                    'domain_url' => Utils::getImageUrl($upload->file_url,true),
                    'file_name' => $upload->file_name,
                    'title' => '',
                    'state' => 'SUCCESS'
                ));
            } else {
                $data['error'] = $upload->getErr();
                $data['status'] = 0;
                echo CJSON::encode($data);
            }
        }
    }

}
