<?php

namespace components;

class Ui
{
    public static function alert(string $type, $message): void
    {
        Session::flash($type, $message);
    }
}