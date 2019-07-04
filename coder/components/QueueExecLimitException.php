<?php
/**
 * QueueExecLimitException.php
 *
 * Created by PhpStorm.
 * @date 04.07.19
 * @time 13:26
 */

namespace coder\components;

/**
 * Class QueueExecLimitException
 * Идентифицирует превышение лимита одновременно выполняющихся заданий
 * @package coder\components
 */
class QueueExecLimitException extends \Exception
{

}