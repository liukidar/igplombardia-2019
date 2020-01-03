<?php

/**
 * MySQL aggregators
 */
class VTA {
  public static function concat($field, $as = NULL, $prefix = NULL)
  {
    $as = $as ? $as : $field;

    if ($prefix) {
      return [$field, "CONCAT('[{\"".$prefix."\":\"', GROUP_CONCAT(DISTINCT REPLACE(", ", '\"', '\\\"') SEPARATOR '\"},{\"".$prefix."\":\"'), '\"}]')", $as];
    }
    return [$field, "CONCAT('[\"', GROUP_CONCAT(DISTINCT REPLACE(REPLACE(", ", '\\\\', '\\\\\\\\'), '\"', '\\\\\"') SEPARATOR '\",\"'), '\"]')", $as];
  }

  public static function sum($field, $as = NULL)
  {
    $as = $as ? $as : $field;
    
    return [$field, 'SUM(', ')', $as];
  }
}