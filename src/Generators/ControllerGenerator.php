<?php

namespace Devesharp\Generators;


use Devesharp\Generators\Common\BaseGeneratorAbstract;

class ControllerGenerator extends BaseGeneratorAbstract
{

    public string $resourceType = 'controller';

    public function getFile(): string
    {
        return 'devesharp-generators::Controller/controller';
    }

    function renderRoutes() {
        return view('devesharp-generators::Routes/route-default', [...$this->getRootData(), ...$this->getData()])->render();
    }

    public function getData()
    {
        return [];
    }

    public function generate()
    {
        parent::generate();

        $render = $this->renderRoutes();
        $file = file_get_contents($this->config->apiRoutesPath);
        $baseFileName = str_replace(base_path(''), '', $file);

        if (strpos($file, $render) == false) {
            file_put_contents($this->config->apiRoutesPath, $render, FILE_APPEND);
            $this->infoEditFile($baseFileName);
        }
    }
}
