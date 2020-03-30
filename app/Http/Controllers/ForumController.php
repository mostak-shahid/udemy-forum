<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Discussion;
use Auth;

class ForumController extends Controller
{
    public function index(){
    	switch(request('filter')){
    		case 'me' :
    			$discussions = Discussion::where('user_id', Auth::id())->orderBy('id','desc')->paginate(3);
    			// $discussions = new Paginator($result, 3);
    		break;
    		case 'answered' :
                $answered = array();
    			$data = array();
    			foreach(Discussion::all() as $d):
    				if ($d->replies()->count()>0)
    				$answered[] = $d;
    			endforeach;
                // $discussions = new Paginator($answered,3);
                /*2nd Try*/
    			$discussions = $this->paginate($answered,3);

    		break;
    		default :
    			$discussions = Discussion::orderBy('id','desc')->paginate(3);
    		break;
    	}
    	return view('forum', ['discussions'=>$discussions]);
    }
    /*2nd Try*/
    public function paginate($items, $perPage = 5, $page = null, $options = [])    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
