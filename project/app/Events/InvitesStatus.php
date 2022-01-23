<?php

namespace App\Events;

use App\Models\Invites;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class InvitesStatus implements ShouldBroadcast{

    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $invites_n;
    public $user_id;
    public function __construct($user)
    {

        $this->invites_n = DB::table('invites')
            ->where('user_id', $user->id)
            ->where('displayed',False)->count();
        $this->user_id = $user->id;
    }

    public function broadcastOn()
    {
        return ['invites-sent'];
    }

    public function broadcastAs()
    {
        return 'invites-status';
    }



}
