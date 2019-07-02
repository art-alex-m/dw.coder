<?php
/**
 * Pagination.php
 *
 * Created by PhpStorm.
 * @date 02.07.19
 * @time 16:44
 */

namespace www\modules\api\components;

/**
 * Class Pagination
 * Класс для управления навигацией по результату
 * @package www\modules\api\components
 */
class Pagination extends \yii\data\Pagination
{
    public $pageSizeParam = 'limit';
    public $pageParam = 'offset';
    public $defaultPageSize = 10;
    public $pageSizeLimit = [0, 100];

    /**
     * {@inheritdoc}
     */
    public function getOffset()
    {
        return $this->getPage();
    }

    /**
     * {@inheritdoc}
     */
    public function getPage($recalculate = false)
    {
        return (int)$this->getQueryParam($this->pageParam, 0);
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks($absolute = false)
    {
        return [];
    }
}