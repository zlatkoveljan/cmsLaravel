<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\HttpFoundation\Request;
use App\User;

class UpdateLastLoginWithIp
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        
        $users = User::all();
        foreach ($users as $u){
            if($event->user->email === $u->email){
                $u->number_of_logins++;
                $u->save();
            }
        }     
        
    }
}
