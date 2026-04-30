<?php
namespace Mxs\Frame;

use SeaDrip\Tools\Path;

class ConfigManager
{
    public function __construct(
        protected readonly Path $path,
        protected readonly Path $cache_path,
    ) {
        app()->debug and $this->cache();
    }

    public function get(string $key, mixed $def = null): mixed
    {
        if (empty($key)) {
            return $def;
        }
        $key_parts = explode('.', $key);
        $file_name = array_shift($key_parts);
        if (!array_key_exists($file_name, $this->loaded_files)) {
            //  $cache_file = $this->cache_path->merge($file_name.'.php');
            $cache_file = $this->path->merge($file_name.'.php');
            if (!$cache_file->isReadable()) {
                return $def;
            }
            $all = include($cache_file);
            $this->loaded_files[$file_name] = $all;
        } else {
            $all = $this->loaded_files[$file_name];
        }
        while ($want = array_shift($key_parts)) {
            if (array_key_exists($want, $all)) {
                $all = $all[$want];
            } else {
                return $def;
            }
        }
        return $all ?? $def;
    }

    public function cache(): void
    {
        $this->path->create();
    }

    protected array $loaded_files = [];
}
