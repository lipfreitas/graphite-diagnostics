<?php
namespace Components;

class DirectoryReader
{
    public function listFilesFromPath($path): array
    {
        // add slash to the start and end of the path if it's not there
        $path = $this->addEndSlash($path);

        // Check if path exists
        if (!file_exists($path)) {
            throw new \Exception("Path does not exist" . $path);
        }

        $files = scandir($path);
        $files = array_diff($files, array('.', '..'));
        return array_values($files);
    }

    private function addEndSlash($path)
    {
        if (substr($path, -1) !== '/') {
            $path .= '/';
        }
        return $path;
    }
}