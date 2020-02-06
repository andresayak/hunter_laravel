<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;

class DomainGetInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:getInfo {--domain_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
        $domain = Domain::findOrFail($this->option('domain_id'));
        dispatch(new \App\Jobs\DomainGetInfoJob($domain));
        echo "Done!\n";
    }
}
