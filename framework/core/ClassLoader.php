<?php

class ClassLoader
{
    private $directories;

    private function directories()
    {
        return $this->directories;
    }

    /**
     * registerメソッドを実行することでautoloadを登録する
     */
    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    public function registerDirectory($directory)
    {
        $this->directories[] = $directory;
    }

    public function loadClass($class)
    {
        foreach ($this->directories() as $directory) {
            $file = "{$directory}/{$class}.php";
            if (is_readable($file)) {
                require_once $file;

                return;
            }
        }
    }
}