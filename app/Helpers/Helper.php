<?php

namespace App\Helpers;

class Helper
{
  /**
   * 学習記録の内容が100文字以内かを判定
   *
   * @param $text 学習内容
   * @return boolean
   */
  public static function isWithinMaxCharacters($text)
  {
      if(mb_strlen($text) < 100) {
        return true;
      } else {
        return false;
      }
  }

  /**
   * 100文字以降の文字を切り捨て
   *
   * @param $text 学習内容
   * @return $truncated_text 学習内容(100文字)
   */
  public static function truncateText($text)
  {
      $truncated_text = mb_substr($text, 0, 100) . '...';
      return $truncated_text;
  }
}