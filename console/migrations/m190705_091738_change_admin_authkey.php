<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m190705_091738_change_admin_authkey
 * Изменяет токен авторизации для админа
 */
class m190705_091738_change_admin_authkey extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->db->createCommand()
            ->update(User::tableName(), ['auth_key' => '1234567890'], 'username = :name',
                [':name' => 'admin'])
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {

    }
}
