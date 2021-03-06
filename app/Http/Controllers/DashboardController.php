<?php

namespace App\Http\Controllers;

use Auth;
use App\Campaign;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(){
        $campaigns = Campaign::ByUserId(Auth::user()->id)->get();
        $count = Auth::user()->newMessagesCount();

        return view('dashboard.my-campaigns', [
            'heading' => 'My campaigns',
            'campaigns' => $campaigns,
            'count' => $count
        ]);
    }

    /**
     * Show all of the message threads to the user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function messages(){
        $count = Auth::user()->newMessagesCount();
        $currentUserId = Auth::user()->id;
        // All threads that user is participating in
        $threads = Thread::forUser($currentUserId)->latest('updated_at')->get();

        return view('dashboard.messages', [
            'heading' => 'Inbox',
            'threads' => $threads,
            'currentUserId' => $currentUserId,
            'count' => $count
        ]);
    }

    public function notifications(){
        return view('dashboard.notifications', [
            'heading' => 'Notifications'
        ]);
    }
}
