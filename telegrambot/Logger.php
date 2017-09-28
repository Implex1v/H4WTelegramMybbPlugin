<?php

class Logger
{
    private $file;
    private $class;

    function __construct($class = '') {
        $this->class = $class;
        $this->file = __DIR__ . "/log/bot.log";

        if($class) {
            $this->class = "[" . $this->class . "]";
        }
    }

    function log($message) {
        if($message) {
            $time = date("d.m.Y H:i:s ");
            $line = $time . $this->class . ": " . $message . "\n";
            file_put_contents($this->file, $line, FILE_APPEND);
        } else {
            throw new Exception("log(): message is null");
        }
    }

    function deleteLogfile() {
        unlink($this->file);
    }
}