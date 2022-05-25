<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyLinks;
use App\Services\ShortenUrlServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShortenUrlController extends Controller
{

    protected $shorten_url;
    public function __construct(ShortenUrlServices $shorten_url)
    {
        $this->shorten_url = $shorten_url;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('pages.shorten-url.shorten-url-index', [
            'my_links' => MyLinks::collection($this->shorten_url->get_my_links($user)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'long_url' => 'required|active_url',
        ]);

        $user = Auth::user();

        try {
            $this->shorten_url->short_my_link($user, $request->long_url);
        } catch (\Throwable $th) {
            return back()->with('store_error', $th->getMessage());
        }

        return redirect(route('shorten-url.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($shorten_url)
    {
        try {
            $destination_url = $this->shorten_url->add_perclick($shorten_url);
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }

        return redirect($destination_url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|integer',
            'title' => 'required|string',
            'shorten_url' => 'required|string|max:100|regex:/^\S*$/u|unique:short_links,shorten_url,' . $request['id'],
            'destination_url' => 'required|active_url|max:500',
        ], [
            'shorten_url.regex' => 'the shorten url cannot contain whitespace',
        ]);

        try {
            $this->shorten_url->update_my_link($validate);
        } catch (\Throwable $th) {
            return $th->getMessage();
            return back()->with('update_error', $th->getMessage());
        }
        return redirect(route('shorten-url.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
