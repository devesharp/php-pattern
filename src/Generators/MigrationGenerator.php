<?php

namespace Devesharp\Generators;


use Devesharp\Generators\Common\BaseGeneratorAbstract;
use Devesharp\Generators\Common\TemplateGenerator;

class MigrationGenerator extends TemplateGenerator
{
    public string $resourceType = 'migration';

    public string $replaceFilename = "";

    static $interator = 0;

    public function getFileName(): string
    {
        if (!empty($this->replaceFilename)) {
            return $this->replaceFilename;
        }

        return $this->templateData->now . '_' . MigrationGenerator::$interator++ .  '_create_' . $this->templateData->tableName . '_table.php';
    }

    public function getTemplateFilename(): string
    {
        return 'devesharp-generators::Migration/migration-table';
    }

    public function getData(): array
    {
        return [];
    }

    public function handle()
    {
        $filename = $this->getPath();

        foreach (glob($filename . '/**/*', GLOB_MARK) as $file) {
            // Não vai criar outro migrate se já existir um
            if (preg_match('/(.*)_create_' . $this->templateData->tableName . '_table.php/', $file)) {
                $this->replaceFilename = explode('/', $file)[count(explode('/', $file)) - 1];

                if (TemplateGenerator::$replace) {
                    return parent::handle(); // TODO: Change the autogenerated stub
                }
                return;
            }
        }

        foreach (glob($filename . '/*', GLOB_MARK) as $file) {
            // Não vai criar outro migrate se já existir um
            if (preg_match('/(.*)_create_' . $this->templateData->tableName . '_table.php/', $file)) {
                $this->replaceFilename = explode('/', $file)[count(explode('/', $file)) - 1];

                if (TemplateGenerator::$replace) {
                    return parent::handle(); // TODO: Change the autogenerated stub
                }
                return;
            }
        }

        return parent::handle(); // TODO: Change the autogenerated stub
    }
}
