<?php

include('CacheInterface.php');

class Cache implements CacheInterface
{
    private $cache_folder;
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->cache_folder = $this->config->cache_folder;
    }

    public function set(string $key, $value, int $duration)
    {
        $cache_file = $key . ".html";

        // Check if it has already been cached and not expired
        // If true then we output the cached file contents and finish
        if ($this->is_cached($cache_file, $this->cache_folder, $duration)) {
            $this->get($cache_file);
        } else {
            $cachefile = $this->cache_folder . $cache_file;
            $fp = fopen($cachefile, 'w');
            fwrite($fp, json_encode($value));
            fclose($fp);
            echo $cache_file . 'cached' . "<br>";
        }
    }

    public function get(string $key)
    {
        $content = json_decode($this->read_cache($key));
        foreach ($content as $k => $val) {
           echo $k  . ' => ' . $val . "<br>";
        }
        echo "<br>";
    }

    // Checks whether the page has been cached or not
    private function is_cached($file, $cache_folder, $duration)
    {
        $cachefile = $cache_folder . $file;
        $cachefile_created = (file_exists($cachefile)) ? @filemtime($cachefile) : 0;
        return ((time() - $duration) < $cachefile_created);
    }

    // Reads from a cached file
    private function read_cache($file)
    {
        $cachefile = $this->cache_folder . $file;
        return file_get_contents($cachefile);
    }
}