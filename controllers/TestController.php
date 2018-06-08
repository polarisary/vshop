<?php

namespace app\controllers;

use app\models\ShortVideo;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use Yii;

class TestController extends \yii\web\Controller
{
    public $defaultAction = 'index';
    public function actionIndex()
    {
        $this->layout = "main2";
        return $this->render('index');
    }

    public function actionVideo($index){
        if($index == 0) $index = PHP_INT_MAX;
    	$retval = ShortVideo::find()->where(['<', 'id', $index])->orderBy('id DESC')->limit(10)->all();
    	$videoList = [];
    	foreach ($retval as $shortVideo) {
            $video = [];
            $video['id'] = $shortVideo->id;
            $video['url'] = $shortVideo->video_uri;
            $video['img'] = $shortVideo->thumbnail_uri;
            $video['share_url'] = $shortVideo->share_uri;
            $video['title'] = $shortVideo->title;
            $video['width'] = $shortVideo->width;
            $video['height'] = $shortVideo->height;
            $video['duration'] = $shortVideo->duration;
            $video['share_num'] = $shortVideo->share_num;
            $video['platform'] = $shortVideo->platform;
            $videoList[] = $video;
        }
    	$response = [];
        $response['resultCode'] = 1;
        $response['result'] = $videoList;
        return json_encode($response);
    }

}
