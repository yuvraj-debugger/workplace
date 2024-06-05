<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MailQueue;
use Illuminate\Support\Facades\Mail;

class LeaveMail extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mail-queue';

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
        $mailQueues = MailQueue::where('status', 0)->first();
        if (! empty($mailQueues)) {
            Mail::send($mailQueues->view, $mailQueues->data, function ($user) use ($mailQueues) {
                $user->to($mailQueues->email);
                $user->subject($mailQueues->subject);
            });
            echo "Mail Send successfully";
            $mailQueues->status = 1;
            $mailQueues->update();
        }
        echo "Mail Queue update Successfully";
    }
}
