<?php

/**
 * Created by PhpStorm.
 * User: tom
 * Date: 18/06/2016
 * Time: 16:23
 */

namespace twhiston\twLib\Discovery;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use RegexIterator;

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
        $this->path = ($path === null)?__DIR__:$path;
        $this->data = [];
    }

    public function find($needle = null, $rebuild = FALSE)
    {
        if($rebuild === TRUE || empty($this->data))
        {
            $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->path));
            $phpFiles = new RegexIterator($allFiles, '/\.php$/');
            foreach ($phpFiles as $phpFile) {
                $content = file_get_contents($phpFile->getRealPath());
                $tokens = token_get_all($content);
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
                        $this->data[] = $namespace.'\\'.$tokens[$index][1];
                    }
                }
            }
        }

        return array_values(array_filter($this->data, function ($var) use ($needle) {
            if (strpos($var, $needle) !== false) {
                return TRUE;
            }
            return FALSE;
        }));

    }


}