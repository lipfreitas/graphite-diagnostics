<?php

class DirectoryReader
{
    public function listFilesFromPath($path)
    {
        $files = scandir($path);
        $files = array_diff($files, array('.', '..'));
        return $files;
    }
}