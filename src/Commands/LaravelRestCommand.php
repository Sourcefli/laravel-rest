<?php

namespace Sourcefli\LaravelRest\Commands;

use Illuminate\Console\Command;

class LaravelRestCommand extends Command
{
    public $signature = 'laravel-rest';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
