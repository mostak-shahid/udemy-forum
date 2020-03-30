<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discussion;
use App\Reply;
use App\User;
use Session;
use Auth;
use Notification;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $discussions = App\Discussion::orderBy('id','desc')->get();
        $discussions = Discussion::orderBy('id', 'DESC')->paginate(10);
        return view('discussions.index')->with('discussions',$discussions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discussions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'channel_id'=>'required',
            'title'=>'required|max:255',
            'content'=>'required',
        ]);
        $discussion = Discussion::create([
            'user_id'=>Auth::id(),
            'channel_id'=>$request->channel_id,
            'title'=>$request->title,
            'slug'=>str_slug($request->title),
            'content'=>$request->content,
        ]);
        Session::flash('success', 'Discussion has been created');
        return redirect()->route('discussion.show',['discussion'=>$discussion->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discussion = Discussion::where('slug',$id)->first();
        $best = $discussion->replies()->where('best', 1)->first();
        return view('discussions.show')
            ->with('discussion',$discussion)
            ->with('best',$best);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discussion = Discussion::findOrFail($id);
        if ($discussion->user_id === Auth::id())
            return view('discussions.edit')->with('discussion',$discussion);
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'channel_id'=>'required',
            'title'=>'required|max:255',
            'content'=>'required',
        ]);
        $discussion = Discussion::findOrFail($id);
        $discussion->channel_id = $request->channel_id;
        $discussion->title = $request->title;
        $discussion->slug = str_slug($request->title);
        $discussion->content = $request->content;
        $discussion->save();
        Session::flash('success', 'Discussion has been updated.');
        return redirect()->route('discussion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Discussion::destroy($id);
        Session::flash('success', 'Discussion has been deleted.');
        return redirect()->back();
    }
}
