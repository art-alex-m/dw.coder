<?php

use yii\db\Migration;
use \common\models\Video;
use \common\models\User;

/**
 * Class m190701_095236_dwc4_videos_table
 * Создает отношение для храниния информации о видео файлах пользователя
 */
class m190701_095236_dwc4_videos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tbName = Video::tableName();
        $this->createTable($tbName, [
            'id' => $this->primaryKey(),
            'is_sent' => $this->boolean()->notNull(),
            'is_moderated' => $this->boolean()->notNull(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'path' => $this->text(),
            'title' => $this->text(),
            'created_at' => $this->timestamp(4),
        ]);

        $this->createIndex('video_issent_index', $tbName, 'is_sent');
        $this->createIndex('video_ismoderated_index', $tbName, 'is_moderated');
        $this->createIndex('video_createdat_index', $tbName, 'created_at');

        $this->addForeignKey(
            'video_userid_user_id_fk',
            $tbName, 'user_id',
            User::tableName(), 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $tbName = Video::tableName();
        $this->dropForeignKey('video_userid_user_id_fk', $tbName);
        $this->dropIndex('video_issent_index', $tbName);
        $this->dropIndex('video_ismoderated_index', $tbName);
        $this->dropIndex('video_createdat_index', $tbName);
        $this->dropTable($tbName);
    }
}
