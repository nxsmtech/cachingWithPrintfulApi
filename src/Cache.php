<?php

include('CacheInterface.php');

class Cache implements CacheInterface
{

    public function set(string $key, $value, int $duration)
    {
        $cache_folder = "C:/wamp64/www/cachingWithPrintfulApi/cache/";
        $cache_file = md5($key) . ".html";

        // Check if it has already been cached and not expired
        // If true then we output the cached file contents and finish
        if ($this->is_cached($cache_file)) {
            $this->get($cache_file);
        } else {
            $cachefile = $cache_folder . $cache_file;
            $fp = fopen($cachefile, 'w');
            fwrite($fp, json_encode($value));
            fclose($fp);
        }
    }

    public function get(string $key)
    {
        echo $this->read_cache($key);
        exit();
    }

    // Checks whether the page has been cached or not
    private function is_cached($file)
    {
        global $cache_folder, $cache_expires;
        $cachefile = $cache_folder . $file;
        $cachefile_created = (file_exists($cachefile)) ? @filemtime($cachefile) : 0;
        return ((time() - $cache_expires) < $cachefile_created);
    }

    // Reads from a cached file
    private function read_cache($file)
    {
        global $cache_folder;
        $cachefile = $cache_folder . $file;
        return file_get_contents($cachefile);
    }
}