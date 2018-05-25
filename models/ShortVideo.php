<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "short_video".
 *
 * @property integer $id
 * @property integer $platform
 * @property string $uuid
 * @property string $title
 * @property integer $width
 * @property integer $height
 * @property integer $duration
 * @property string $thumbnail_uri
 * @property string $video_uri
 * @property string $share_uri
 * @property string $preview_uri
 * @property integer $liked_num
 * @property integer $loop_num
 * @property integer $view_num
 * @property integer $comment_num
 * @property integer $share_num
 * @property integer $avg_view_time
 * @property string $user_id
 * @property string $user_nick_name
 * @property string $user_real_name
 * @property string $user_display_name
 * @property string $user_icon
 * @property string $user_desc
 * @property string $created_at
 * @property string $updated_at
 */
class ShortVideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'short_video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform', 'width', 'height', 'duration', 'liked_num', 'loop_num', 'view_num', 'comment_num', 'share_num', 'avg_view_time'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid', 'user_id', 'user_nick_name', 'user_real_name', 'user_display_name'], 'string', 'max' => 64],
            [['title', 'thumbnail_uri', 'video_uri', 'share_uri', 'preview_uri', 'user_icon', 'user_desc'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'platform' => 'Platform',
            'uuid' => 'Uuid',
            'title' => 'Title',
            'width' => 'Width',
            'height' => 'Height',
            'duration' => 'Duration',
            'thumbnail_uri' => 'Thumbnail Uri',
            'video_uri' => 'Video Uri',
            'share_uri' => 'Share Uri',
            'preview_uri' => 'Preview Uri',
            'liked_num' => 'Liked Num',
            'loop_num' => 'Loop Num',
            'view_num' => 'View Num',
            'comment_num' => 'Comment Num',
            'share_num' => 'Share Num',
            'avg_view_time' => 'Avg View Time',
            'user_id' => 'User ID',
            'user_nick_name' => 'User Nick Name',
            'user_real_name' => 'User Real Name',
            'user_display_name' => 'User Display Name',
            'user_icon' => 'User Icon',
            'user_desc' => 'User Desc',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
