<?php

/**
 * Contains methods to handle necessary file operations for things such as loading JS/CSS, searching for a template, joining directories..etc
 */

 namespace Framework\Traits;

use InvalidArgumentException;

trait FileOperations
{

    /**
     * Joins paths provided as a string array and returns a string containing the final path
     * 
     * @param array $paths
     * @return string $newpath
     */
    public static function joinPaths(array $paths) :string
    {
        $newpath = '';
        if (is_array($paths)) {
            foreach ($paths as $key=>$path){
                $newpath.=$path;
                if(substr($path, -1)!='/' && $key!=array_key_last($paths))
                    $newpath.='/';
               
            }
        }
        else
        {
            throw new InvalidArgumentException("Directories array expected");
        }
        return $newpath;
    }

    /**
     * Get all files from the provided directory with the provided file extension, as an array of strings containing the filenames
     * 
     * @param string $directory
     * @param string extension
     * @return array $files
     */
    public static function loadFilesFromDirectory(string $directory, string $extension) :array 
    {
        $files = [];
        $files_list = scandir($directory);
        foreach ($files_list as $filename) {
            if(pathinfo($filename, PATHINFO_EXTENSION) == $extension){
                array_push($files, $filename);
            }
        }
        return $files;
    }
}