<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Client;
use Input;
use Redirect;
use DB;
use Response;
use Session;

class ClientController extends Controller
{
    /**
     * Display a client list.
     *
     * @return Response
     */
    public function index()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1)
      {
        $client_info = Client::get();
        return view('client/index', compact('client_info'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Show the form for creating a new client.
     *
     * @return Response
     */
    public function create()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        return view('client/create');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Store a newly created client in database.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        // $this->validate($request, [
        //   'client-name'         => 'required'
        // ]);

        $client = new Client;
        $client->client_name = Input::get('client-name');
        $client->save();

        return Redirect::to('/client-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Display the specified client.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified client.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $client = Client::find($id);
        return view('client/edit', compact('client'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Update the specified client in database.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
          // $this->validate($request, [
        //   'client-name'         => 'required'
        // ]);

        $client = Client::find($id);
        $client->client_name = Input::get('client-name');
        $client->save();

        return Redirect::to('/client-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Remove the specified client from database.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $client = Client::find($id);
        $client->delete();

        return Redirect::to('/client-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }
}
