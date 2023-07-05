<?php

namespace App\Http\Controllers;

use App\Models\usd_gpd;
use Facade\FlareClient\Stacktrace\File;
use App\WebsiteScraper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class UsdGpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gpd = usd_gpd::select()->orderBy('id', 'desc')->get();
        return view('layout.supper-admin.usd-gdp')->with(['gpd'=>$gpd]);
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
        $iframeExplode = explode("'", $request->iframe)['1'];
        
        $ok = usd_gpd::create([
            'title'         => $request->title,
            'iframe'        => $iframeExplode,
            'fundamental'   => $request->fundamental,
        ]);
        if ($ok) {
            return redirect()->route('usd-gdp');
        } else {
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\usd_gpd  $usd_gpd
     * @return \Illuminate\Http\Response
     */
    public function show(usd_gpd $usd_gpd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\usd_gpd  $usd_gpd
     * @return \Illuminate\Http\Response
     */
    public function edit(usd_gpd $usd_gpd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\usd_gpd  $usd_gpd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, usd_gpd $usd_gpd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\usd_gpd  $usd_gpd
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usd_gpd = usd_gpd::find($id);
        $usd_gpd->delete();
        return redirect()->back();  
    }
    
    public function scrape()
    {
       
        $client = new Client();
        $response = $client->request('GET', 'https://snowdreamstudios.com');

        $body = $response->getBody();

        $dom = new \DOMDocument();
        @$dom->loadHTML($body);
        $technologies = [];
        $scripts = $dom->getElementsByTagName('script');
        foreach ($scripts as $script) {
            $src = $script->getAttribute('src');
            
        }
       
    }
}
