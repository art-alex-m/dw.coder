<?php
/**
 * BuildUrlTrait.php
 *
 * Created by PhpStorm.
 * @date 03.07.19
 * @time 13:38
 */

namespace coder\components;

/**
 * Trait BuildUrlTrait
 * Собирает урл из конфигурации
 * @package coder\components
 */
trait BuildUrlTrait
{
    /**
     * Создает урл
     * @param array $url
     * @param array $params
     * @return string
     */
    public function buildUrl(array $url, array $params = [])
    {
        $url = array_merge($url, $params);
        $str = $url[0];
        unset($url[0]);
        return $str . '?' . http_build_query($url);
    }
}