<?php

/**
 * Created by PhpStorm.
 * User: tom
 * Date: 18/06/2016
 * Time: 16:23
 */

namespace twhiston\twLib\Discovery;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use twhiston\twLib\Str\Str;

class FindByNamespace
{

    protected $path;

    protected $data;

    /**
     * FindByNamespace constructor.
     * @param $path
     */
    public function __construct($path = null)
    {
        $this->path = ($path === null || $path === '') ? __DIR__ : $path;
        $this->data = [];
        $this->data[$path] = [];
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return null
     */
    public function getPath()
    {
        return $this->path;
    }



    public function find($needle = null, $rebuild = false)
    {
        $this->buildData($rebuild);
        return $this->filterData($needle);
    }

    protected function buildData($rebuild)
    {

        if ($rebuild === true || empty($this->data[$this->path])) {
            $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->path));
            $phpFiles = new RegexIterator($allFiles, '/\.php$/');
            $this->data[$this->path] = [];
            foreach ($phpFiles as $phpFile) {
                //tokenize file
                $realPath = $this->getRealPath($phpFile);
                if (file_exists($realPath)) {
                    $content = file_get_contents($realPath);
                    $this->processTokens(token_get_all($content), $this->path);
                }
            }
        }
    }

    protected function getRealPath($phpFile)
    {
        if (Str::startsWith($this->path, ['phar'])) {
            $realPath = $phpFile->getPath() . '/' . $phpFile->getFilename();
        } else {
            $realPath = $phpFile->getRealPath();
        }
        return $realPath;
    }

    protected function processTokens(array $tokens, $realPath)
    {
        $namespace = '';
        for ($index = 0; isset($tokens[$index]); $index++) {
            if (!isset($tokens[$index][0])) {
                continue;
            }
            if (T_NAMESPACE === $tokens[$index][0]) {
                $index += 2; // Skip namespace keyword and whitespace
                while (isset($tokens[$index]) && is_array($tokens[$index])) {
                    $namespace .= $tokens[$index++][1];
                }
            }
            if (T_CLASS === $tokens[$index][0]) {
                $index += 2; // Skip class keyword and whitespace
                if (is_array($tokens[$index]) && array_key_exists(1, $tokens[$index])) {
                    $this->data[$realPath][] = $namespace . '\\' . $tokens[$index][1];
                }
            }
        }
    }


    protected function filterData($needle)
    {
        return array_values(array_filter($this->data[$this->path], function ($var) use ($needle) {
            if (strpos($var, $needle) !== false) {
                return true;
            }
            return false;
        }));
    }

}