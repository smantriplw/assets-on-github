<?php
class PhpEnvUtil
{
    public static function ensureExists($key, $data)
    {
        if (!isset($data)) {
            throw new Error($key . ' is empty');
        }
    }
}