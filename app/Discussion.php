<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Discussion extends Model
{
    protected $fillable = ['user_id','channel_id','title','slug','content'];
    public function channel(){
    	return $this->belongsTo('App\Channel');
    }
    public function user(){
    	return $this->belongsTo('App\User');
    }
    public function replies(){
    	return $this->hasMany('App\Reply');
    }
    public function watches(){
        return $this->hasMany('App\Watcher');
    }
    public function is_beign_watched_by_auth_user(){
        $id = Auth::id();
        $watchers = array();
        foreach($this->watches as $watch){
            $watchers[] = $watch->user_id; 
        }
        if (in_array($id, $watchers))
            return true;
        return false;
    }
    public function has_best_reply(){
        $arrayName = array();
        foreach($this->replies as $reply){
            $arrayName[] = $reply->best;
        }
        if (in_array(1, $arrayName)) return true;
        return false;
    }   
}
