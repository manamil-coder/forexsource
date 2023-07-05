<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Vedmant\FeedReader\Facades\FeedReader;
use Carbon\Carbon;
use App\Models\chat_notify;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if(!empty($id)){
            $eidtBlog = Blogs::select()->where('id', $id)->first();
        }else{
            $eidtBlog = null;
        }
        $thisDate = today()->format('Y-m-d');

        $blogs = Blogs::select()->where('date', '>=', $thisDate)->orderBy('id', 'desc')->get();
        
        return view('layout.supper-admin.breaking-news-squawk')->with(['blogs'=>$blogs, 'eidtBlog'=>$eidtBlog]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $img = uploadFils($request, 'file');

        
        
        if(!empty($request->description) or !empty($request->file_name)){
            $collapse = 'collapse';
        }else{
            $collapse = null;
        }

        $ok = Blogs::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'status'        => $request->status,
            'link'           => $request->link,
            'file_name'     => $request->file_name,
            'collapse'      => $collapse,
            'webname'       => 'Forex Source',
            'date'          => date('Y-m-d H:i'),
            'file'          => $img['file'],
            'type'          => $img['type'],
        ]);

        if ($ok) {
            return  redirect()->back()->with('success', 'Post Successfully Created.');
        } else {
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function show($id ='')
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function edit(Blogs $blogs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blogs $blogs)
    {
        $blog = Blogs::find(intval($request->id));

        if(!empty($request->file)){
            $img = uploadFils($request, 'file');
            $file  = $img['file'];
            $type = $img['type'];
        }else{
            $file = $blog->file;
            $type = $blog->type;
        }
        try{
            $blog->title       = $request->title;
            $blog->description  = $request->description;
            $blog->status       = $request->status;
            $blog->link         = $request->link;
            $blog->file_name    = $request->file_name;
            $blog->file         = $file;
            $blog->type         = $type;
            $blog->save();
            return redirect()->route('breaking-news-squawk')->with('success', 'save changes Successfully.');
        } catch (\Throwable$th) {
            return redirect()->back();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blogs::find($id);
        $blog->delete();
        return redirect()->route('breaking-news-squawk')->with('success', 'Delete video Successfully.');
    }


    public function breakingNews() {
        $user   = Auth::user();
        $currentDate = date('Y-m-d');
        $FxStreet = FeedReader::read('https://www.fxstreet.com/rss');
        foreach ($FxStreet->get_items() as $values) {
            if(date('Y-m-d', strtotime($values->get_date())) == $currentDate){
                $feedItem = Blogs::firstOrCreate(
                    ['title' => $values->get_title()],
                    [
                        'webname' => 'FXStreet',
                        'date' => date('Y-m-d H:i', strtotime($values->get_date())),
                        'link' => $values->get_link(),
                    ]
                );
            }
        }
        
        if (Schema::hasColumns('chat_notify', ['user_id', 'blogs_id'])) {
            $existingData = chat_notify::where('user_id', $user->id)->pluck('blogs_id')->toArray();
        
            $currentDate = date('Y-m-d');
            
            $Blogs = Blogs::whereDate('date', $currentDate)
            ->whereNotExists(function ($query) use ($existingData) {
                $query->select('blogs_id')
                    ->from('chat_notify')
                    ->whereColumn('blogs.id', 'chat_notify.blogs_id')
                    ->whereIn('blogs_id', $existingData);
            })
            ->take(1)
            ->get();
            
            $BlogsIDs = $Blogs->pluck('id')->toArray();
            
            if (count($BlogsIDs) > 0) {
                foreach ($BlogsIDs as $ID) {
                    // Check if the blogs_id already exists in chat_notify for the user
                    if (!in_array($ID, $existingData)) {
                        $chatNotify = new chat_notify;
                        $chatNotify->user_id = $user->id;
                        $chatNotify->blogs_id = $ID;
                        $chatNotify->save();
                    }
                    return $Blogs->toJson(); 
                }
            } else {
                return 'false';
            }
        } else {
            return 'The chat_notify table does not have the required columns.';
        }
    }

    
}
