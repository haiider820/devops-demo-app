<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RedirectTodos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redirect:todos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds first default todo and redirects user to todos index (used after login failure cases)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // This command is intentionally left empty.
        // (Route redirects handle navigation.)
        return self::SUCCESS;
    }
}

