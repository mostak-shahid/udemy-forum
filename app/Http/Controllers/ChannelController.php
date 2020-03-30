<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use Session;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $channels = Channel::all(); //orderBy('id', 'DESC')->get()
        // $channels = Channel::orderBy('id', 'DESC')->get();
        $channels = Channel::orderBy('id', 'DESC')->paginate(3);
        return view('channels.index')->with('channels', $channels);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('channels.create');
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
            'title'=>'required|max:255',
        ]);
        Channel::create([
            'title' => $request->title,
            'slug' => str_slug($request->title),
        ]);
        Session::flash('success', 'Channel has been created');
        return redirect()->route('channel.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $channel = Channel::where('slug', $id)->first();
        return view('channels.show')->with('discussions',$channel->discussions()->orderBy('id','desc')->paginate(3));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $channel = Channel::findOrFail($id);
        return view('channels.edit')->with('channel', $channel);
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
        // dd($request);
        $this->validate($request,[
            'title'=>'required|max:255',
        ]);

        $channel = Channel::findOrFail($id);
        $channel->title = $request->title;
        $channel->slug = str_slug($request->title);
        $channel->save();
        Session::flash('success', 'Channel has been updated');
        return redirect()->route('channel.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        Channel::destroy($id);
        return redirect()->back();
    }
}
