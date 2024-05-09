<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class ResultController extends Controller
{
    use HasApiTokens;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        

        if ($request->type_result === 'repet') {
            $result = new Result([
                'repet'       => $request->repet,
                'activity_id'   => $request->activity_id,
                'user_id'     => auth::user()->id,
                'type_result' => $request->type_result
            ]);
        } elseif ($request->type_result === 'time') {
            $result = new Result([
                'time_spent'  => $request->time_spent,
                'activity_id'   => $request->activity_id,
                'user_id'     => auth::user()->id,
                'type_result' => $request->type_result
            ]);
        }

        $result->save();

        return response()->json([
            'user'=> auth::user()->name,
            'success' => true,
            'Message' => 'Data has been successfully saved.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request, $id)
    {
        //
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
