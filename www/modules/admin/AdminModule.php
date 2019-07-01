<?php
/**
 * AdminModule.php
 *
 * Created by PhpStorm.
 * @date 01.07.19
 * @time 10:11
 */

namespace www\modules\admin;

use yii\base\Module;

/**
 * Class AdminModule
 * Модуль панели администратора
 * @package admin\modules\webpages
 */
class AdminModule extends Module
{
    /** @inheritdoc */
    public $defaultRoute = 'users';
}