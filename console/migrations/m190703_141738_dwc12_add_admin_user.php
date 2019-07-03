<?php

use yii\db\Migration;
use common\models\Rbac;
use common\models\SignupForm;
use common\models\User;

/**
 * Class m190703_141738_dwc12_add_admin_user
 * Создает пользователя с правами администратора
 */
class m190703_141738_dwc12_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $model = new SignupForm([
            'username' => 'admin',
            'password' => 'admin1',
            'email' => 'admin@example.com',
        ]);
        $model->signup();

        $user = User::find()->andWhere(['=', 'username', 'admin'])->one();
        $auth = Yii::$app->authManager;
        $auth->revokeAll($user->id);
        $role = $auth->getRole(Rbac::ROLE_ADMIN);
        $auth->assign($role, $user->id);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $user = User::find()->andWhere(['=', 'username', 'admin'])->one();
        if ($user instanceof User) {
            $auth = Yii::$app->authManager;
            $auth->revokeAll($user->id);
            $user->delete();
        }
    }
}
