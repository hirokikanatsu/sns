<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;

class sendMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sendMail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->mailController = new MailController();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = 'テスト ユーザー';
        $email = 'test@example.com';
        $this->mailController->send($name, $email);
        return 0;
    }
}
