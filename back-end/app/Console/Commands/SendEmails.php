<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\VendaController;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia um email com um relatório com a soma de todas as vendas efetuadas no dia.';

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
     * @return int
     */
    public function handle()
    {
        $venda = new VendaController();
        $venda->sendmail();
        return 0;
    }
}
