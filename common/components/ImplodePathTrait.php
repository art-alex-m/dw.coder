<?php
/**
 * ImplodePathTrait.php
 *
 * Created by PhpStorm.
 * @date 02.07.19
 * @time 14:49
 */

namespace common\components;

/**
 * Trait ImplodePathTrait
 * Собирает файловый путь из массива
 * @package common\components
 */
trait ImplodePathTrait
{
    /**
     * Собирает путь для сохранения файла
     * @param string $separator
     * @param array $chunks
     * @return string
     */
    protected function implodePath($separator, $chunks)
    {
        $tmp = [];
        foreach ($chunks as $item) {
            if (is_array($item)) {
                $tmp[] = implode($separator, $item);
            } else {
                $tmp[] = $item;
            }
        }
        return implode($separator, $tmp);
    }
}