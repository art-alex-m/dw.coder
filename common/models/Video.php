<?php
/**
 * Video.php
 *
 * Created by PhpStorm.
 * @date 01.07.19
 * @time 12:32
 */

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;

/**
 * Class Video
 * Файл с видео контентом
 *
 * @package common\models
 * @property-read int $id Идентификатор файла
 * @property string $path Путь к храннию файла
 * @property bool $is_sent Файл отправлен на перекодирование
 * @property bool $is_moderated Файл модерирован
 * @property integer $created_at Время создания файла
 * @property int $user_id Идентификатор пользователя
 * @property string $title Имя файла
 */
class Video extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%videos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => function () {
                    return (new \DateTime())->format(DATE_RFC3339_EXTENDED);
                }
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_sent', 'is_moderated'], 'default', 'value' => false],
            [['is_sent', 'is_moderated'], 'boolean'],
            [
                'user_id',
                'exist',
                'targetAttribute' => 'id',
                'targetClass' => User::class,
                'message' => Yii::t('app', 'User should be active'),
                'filter' => ['=', 'status', User::STATUS_ACTIVE],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'is_sent' => 'Sent',
            'is_moderated' => 'Moderated',
            'created_at' => 'Created at',
            'user_id' => 'User id',
            'title' => 'Title',
        ];
    }
}