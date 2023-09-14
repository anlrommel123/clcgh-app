<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->json()->all(); //Get the JSON object

        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'contact_no' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $arrErrors = [];

            foreach ($errors->all() as $message) {
                $arrErrors[] = $message;
            }

            return $arrErrors;
        } else {
            $user = new User;

            $user->first_name = $data['first_name'];
            $user->middle_name = $data['middle_name'];
            $user->last_name = $data['last_name'];
            $user->address = $data['address'];
            $user->contact_no = $data['contact_no'];
            $user->email = $data['email'];
            $user->password = $data['password'];

            $user->save();

            return response()->json([
                'success' => TRUE,
                'message' => 'Successfully registered the user.'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
