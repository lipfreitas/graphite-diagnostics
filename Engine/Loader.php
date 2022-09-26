<?php

class Loader {
    public static function folder($foldername){
        $dirfiles = (new Components\DirectoryReader)->listFilesFromPath($foldername);
        require $foldername . '/' . $dirfiles[0];
    }
}
