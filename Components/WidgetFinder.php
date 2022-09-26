<?php

class WidgetFinder
{
    const WIDGETS_PATH = 'protected\extensions\widgets';
    public function list(): array
    {
        $path = env('GRAPHITE_DIR') . self::WIDGETS_PATH;
        $dirfiles = (new Components\DirectoryReader)->listFilesFromPath($path);
        $widgets = [];
        foreach ($dirfiles as $file) {
            $widgets[] = $this->getWidgetName($file);
        }
        return $widgets;
    }

    private function getWidgetName($file)
    {
        $widget = explode('.', $file);
        return $widget[0];
    }
}