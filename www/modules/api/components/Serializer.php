<?php
/**
 * Serializer.php
 *
 * Created by PhpStorm.
 * @date 02.07.19
 * @time 17:46
 */

namespace www\modules\api\components;

use yii\web\Link;

/**
 * Class Serializer
 * Класс для сериализации моделей и представления ссылок навигации
 * @package www\modules\api\components
 */
class Serializer extends \yii\rest\Serializer
{
    public $perPageHeader = 'X-Pagination-Limit';
    public $currentPageHeader = 'X-Pagination-Offset';

    /**
     * {@inheritdoc}
     */
    protected function serializePagination($pagination)
    {
        return [
            $this->linksEnvelope => Link::serialize($pagination->getLinks(true)),
            $this->metaEnvelope => [
                'totalCount' => $pagination->totalCount,
                'offset' => $pagination->getPage(),
                'limit' => $pagination->getPageSize(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function addPaginationHeaders($pagination)
    {
        $this->response->getHeaders()
            ->set($this->totalCountHeader, $pagination->totalCount)
            ->set($this->currentPageHeader, $pagination->getPage())
            ->set($this->perPageHeader, $pagination->pageSize);
    }
}