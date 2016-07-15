<?php
namespace App\Enum;

use Api\StarterKit\Enums\Enum;

/**
 * 状态-用于动态显示内容
 * Class Status
 * @package App\Enum
 */
class Status extends Enum
{
  /**
   * 可用
   */
  const ENABLE = 'enable';

  /**
   * 禁止不显示
   */
  const DISABLED = 'disabled';
}