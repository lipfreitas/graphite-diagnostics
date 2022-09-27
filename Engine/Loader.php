<?php

class Loader {
    public static function folder($foldername){
        $dirfiles = (new Components\DirectoryReader)->listFilesFromPath($foldername);
        foreach($dirfiles as $file){
            require_once $foldername . '/' . $file;
        }

    }
}
