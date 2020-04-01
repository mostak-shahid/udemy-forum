<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discussion;
use App\Reply;
use App\Like;
use App\User;
use Auth;
use Session;
use Notification;
use App\Notifications\MyFirstNotification;

class ReplyController extends Controller
{
    public function create(Request $request){
        $discussion = Discussion::find($request->discussion_id);
        $this->validate($request,[
            'discussion_id' => 'required',
            'content' => 'required',
        ]);
        Reply::create([
            'user_id' => Auth::id(),
            'discussion_id' => $request->discussion_id,
            'content' => $request->content,         
        ]);
        /*$watchers = array();
        foreach($discussion->watches as $watcher):
            $watchers[] =  User::find($watcher->user_id);
        endforeach;*/
        $user = User::all();
  
        $details = [
            'greeting' => 'Hi Artisan',
            'body' => 'This is my first notification from ItSolutionStuff.com',
            'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
            'actionText' => 'View My Site',
            'actionURL' => url('/'),
            'order_id' => 101
        ];
  
        Notification::send($user, new MyFirstNotification($details));

        Session::flash('success', 'Comment has been created');
        return redirect()->back();
    }
    public function update(Request $request, $id){
        $reply = Reply::findOrFail($id);
        if (Auth::id() === $reply->user_id){
            $this->validate($request,[
                'discussion_id' => 'required',
                'content' => 'required',
            ]);
            $reply->user_id = Auth::id();
            $reply->discussion_id = $request->discussion_id;
            $reply->content = $request->content;
            $reply->save();
        }
        return redirect()->back();
    }
    public function like($id){
    	Like::create([
    		'reply_id' => $id,
    		'user_id' => Auth::id(),
    	]);
    	Session::flash('success', 'You liked the reply');
    	return redirect()->back();
    }
    public function dislike($id){
    	Like::where('reply_id', $id)->where('user_id',Auth::id())->first()->delete();
    	Session::flash('success', 'You disliked the reply');
    	return redirect()->back();
    }
    public function best($id){
        $reply = Reply::findOrFail($id);
        $auth = $reply->discussion()->first()->user_id;
        // dd($auth);
        if ($auth == Auth::id()){
            $reply->best = 1;
            $reply->save();
            Session::flash('success', 'Best answer has been choosen.');
            return redirect()->back();
        } else {
            return abort(404);
        }
    }
}
