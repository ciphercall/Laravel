<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Version extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busts css & script cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = 'app/Providers/VersionServiceProvider.php';
        $regex = '/^\s*config\(\)->set\(\'version\',\s*(.*?)(?=\))\);\s*$/';
        $v = 0;
        if (file_exists($path)) {
            $file = fopen($path, 'r');
            while (!feof($file)) {
                if (preg_match($regex, fgets($file), $matches)) {
                    $v = $matches[1] + 0.01;
                    break;
                }
            }
            fclose($file);
            $file = fopen($path, 'w');
            fwrite($file, $this->prepareData($v));
            fclose($file);
        }
        Artisan::call('config:clear');
        $this->info($v);
        return 0;
    }

    private function prepareData($v)
    {
        return '<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VersionServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set(\'version\', ' . $v . ');
    }
}';
    }
}
