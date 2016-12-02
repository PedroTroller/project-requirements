<?php

namespace Knp\ProjectRequirements\DependencyInjection\Container;

use Exception;
use Knp\ProjectRequirements\Composer;
use Knp\ProjectRequirements\Composer\Ordering;
use Knp\ProjectRequirements\DependencyInjection\Container;
use Knp\ProjectRequirements\File\Contributing;
use Knp\ProjectRequirements\File\CsFixerRecipe;
use Knp\ProjectRequirements\File\License;
use Knp\ProjectRequirements\Filesystem\Local;
use Knp\ProjectRequirements\Github\InformationProvider;
use Knp\ProjectRequirements\Github\Remotes;

class Builder
{
    /**
     * @return Container
     */
    public static function build()
    {
        $container = new Container();

        $container['PROJECT_ROOT'] = function () {
            $composer = sprintf('%s/composer.json', getcwd());

            if (file_exists($composer)) {
                return getcwd();
            }

            throw new Exception(sprintf('File %s not found, this application must be used in the root folder of your php project.', $composer));
        };

        $container['GIT_REPOSITORY'] = function (Container $container) {
            $remotes = (new Remotes($container['PROJECT_ROOT']))->getRemotes();

            return current($remotes);
        };

        $container['git.information_provider'] = function (Container $container) {
            return new InformationProvider($container['GIT_REPOSITORY']);
        };

        $container['filesystem.lib'] = function (Container $container) {
            return new Local(realpath(sprintf('%s/../../../../..', __DIR__)));
        };

        $container['filesystem.project'] = function (Container $container) {
            return new Local($container['PROJECT_ROOT']);
        };

        $container['operator.composer.authors'] = function (Container $container) {
            return new Authors($container['filesystem.project'], $container['git.information_provider']);
        };

        $container['operator.composer.bin_dir'] = function (Container $container) {
            return new Composer\ConfigBin($container['filesystem.project']);
        };

        $container['operator.composer.license'] = function (Container $container) {
            return new Composer\License($container['filesystem.project']);
        };

        $container['operator.composer.ordering'] = function (Container $container) {
            return new Composer\Ordering($container['filesystem.project']);
        };

        $container['operator.file.contributing'] = function (Container $container) {
            return new Contributing($container['filesystem.project'], $container['filesystem.lib']);
        };

        $container['operator.file.license'] = function (Container $container) {
            return new License($container['filesystem.project'], $container['filesystem.lib']);
        };

        $container['operator.file.php_cs'] = function (Container $container) {
            return new CsFixerRecipe($container['filesystem.project'], $container['filesystem.lib']);
        };

        $container['operators'] = function (Container $container) {
            return [
                $container['operator.composer.bin_dir'],
                $container['operator.composer.license'],
                $container['operator.composer.ordering'],
                $container['operator.file.contributing'],
                $container['operator.file.license'],
                $container['operator.file.php_cs'],
            ];
        };

        return $container;
    }
}
