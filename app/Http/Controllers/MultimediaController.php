<?php

namespace App\Http\Controllers;

use App\Traits\MultimediaTrait;
use Illuminate\Http\Request;

class MultimediaController extends Controller
{
    use MultimediaTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Multimedia  $multimedia
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Multimedia  $multimedia
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
     * @param  \App\Models\Multimedia  $multimedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Multimedia  $multimedia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = self::destroyTrait($id);
        if (request()->wantsJson()) {
            
            $data = $response ? ['type' => 'success','text' => 'Se eliminó con éxito el contenido multimedia']
                    : ['type' => 'error','text' => 'Sucedió un error,No se eliminó con éxito el contenido multimedia'];
            return response()->json($data, 200);
        }
    }

    public function download($id)
    {
        return self::downloadTrait($id);
    }
}
