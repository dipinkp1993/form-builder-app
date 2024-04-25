<?php

namespace App\Jobs;

use App\Mail\sendFormCreationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class sendFormCreationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $form;

    public function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to('dipinpnambiar@gmail.com')->send(new sendFormCreationMail($this->form));
    }
}
