<?php
/**
 * RemindVideoEmail.php
 *
 * Created by PhpStorm.
 * @date 04.07.19
 * @time 15:54
 */

namespace console\models;

use common\models\User;
use common\models\Video;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class RemindVideoEmail
 * Формирует рассылку по просроченным видео
 * @package console\models
 */
class RemindVideoEmail extends Model
{
    /** @var string Email получателя письма */
    public $recipient;
    /** @var string Заголовок письма */
    protected $subject = 'Video list for moderation';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                'recipient',
                'default',
                'value' => function () {
                    return $this->setDefaultRecipient();
                }
            ],
            ['recipient', 'required'],
            ['recipient', 'email'],
        ];
    }

    /**
     * Устанавливает получателья по-умолчанию
     * @return mixed|string|null
     */
    public function setDefaultRecipient()
    {
        $user = User::find()->andWhere(['=', 'username', 'admin'])->one();
        if ($user instanceof User) {
            return $user->email;
        }
        return null;
    }

    /**
     * Отправляет письмо со списком просроченных видео
     * @return int
     * @throws \Exception
     */
    public function send()
    {
        if (!$this->validate()) {
            return -1;
        }

        $checkPoint = (new \DateTime())->modify('-3 days');

        $query = Video::find()
            ->andWhere(['=', 'is_moderated', false])
            ->andWhere(['<', 'created_at', $checkPoint->format(DATE_RFC3339)]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $count = $provider->getTotalCount();

        $result = true;
        if ($count > 0) {
            $result = Yii::$app->mailer->compose([
                'text' => 'remindVideoEmail-text',
            ], [
                'provider' => $provider
            ])
                ->setTo($this->recipient)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setSubject($this->subject)
                ->send();
        }

        return $result ? $count : -1;
    }
}