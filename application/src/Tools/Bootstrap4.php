<?php
namespace Main\Tools;

use E4u\Tools\Console;

class Bootstrap4 extends Console\Base
{
    const HELP = 'Compile Bootstrap4 from source';

    public function execute()
    {
        $bootstrap_vendor = 'vendor/twbs/bootstrap/';
        $bootstrap_public = 'public/bootstrap/';
        $currentDir = getcwd();

        copy($bootstrap_public . '_custom.scss', $bootstrap_vendor . 'scss/_custom.scss');
        echo $bootstrap_public . '_custom.scss' . ' -> ' . $bootstrap_vendor . 'scss/_custom.scss' . "\n";

        chdir($bootstrap_vendor);
        passthru('npm install --loglevel=error');
        passthru('grunt dist');

        chdir($currentDir);
        $this->copyDirectory($bootstrap_vendor . 'dist/css/', $bootstrap_public . 'css/');
        $this->copyDirectory($bootstrap_vendor . 'dist/js/',  $bootstrap_public . 'js/');
        echo "OK\n";
    }

    private function copyDirectory($src, $dst) {
        echo $src . ' -> ' . $dst . ": ";
        foreach (glob($src . '*') as $file) {
            copy($file, $dst . basename($file));
            echo '.';
        }

        echo "\n";
    }
}