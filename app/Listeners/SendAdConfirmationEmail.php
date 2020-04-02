<?php

namespace App\Listeners;

use App\Mail\ConfirmAd;
use App\Events\AdCreated;
use App\Models\AdConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAdConfirmationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdCreated  $event
     * @return void
     */
    public function handle(AdCreated $event)
    {
        $length = 80;
        $token = bin2hex(random_bytes($length));

        $adConfirmation = new AdConfirmation();
        $adConfirmation->token = $token;
        $adConfirmation->ad_id = $event->ad->id;
        $adConfirmation->save();

        Mail::to($event->ad->email)->send(new ConfirmAd($token));
    }
}
