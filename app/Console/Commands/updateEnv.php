<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command as CommandAlias;

class updateEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:env {env_name=env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('optimize:clear');
        $env_name = $this->argument('env_name');
        $arr = [];
        $contents = file_get_contents(base_path('vars.txt'));
        foreach (explode("\n", $contents) as $key=>$line){
            $arr[$key] = explode(',', $line);
        }

        if (!trim($contents)){
            $this->info('The vars fie is empty');
            return false;
        }

        if ($arr[0][0] == '.'.$env_name){
            $this->info('The env file already loaded');
            return false;
        }

        if (!file_exists(base_path('.'.$env_name))){
            $this->info('The env file not found');
            return false;
        }

        file_put_contents(base_path('vars.txt'), '');
        file_put_contents(base_path('vars.txt'), '.'.$env_name);
        $this->info('env updated successfully');
        return CommandAlias::SUCCESS;
    }
}
