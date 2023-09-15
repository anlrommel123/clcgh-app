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
        $user = User::all();

        return $user;
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
            'password' => 'required|min:5|confirmed'
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
        $user = User::find($id);

        if ($user) {
            return $user;
        } else {
            return response()->json([
                'success' => FALSE,
                'message' => 'Error, id not found'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->json()->all(); //Get the JSON object

        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'contact_no' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $arrErrors = [];

            foreach ($errors->all() as $message) {
                $arrErrors[] = $message;
            }

            return $arrErrors;
        } else {
            $user = User::find($id);

            if ($user) {
                $user->first_name = $data['first_name'];
                $user->middle_name = $data['middle_name'];
                $user->last_name = $data['last_name'];
                $user->address = $data['address'];
                $user->contact_no = $data['contact_no'];
                $user->password = $data['password'];

                $user->save();

                return response()->json([
                    'success' => TRUE,
                    'message' => 'Successfully updated the user.'
                ], 200);
            } else {
                return response()->json([
                    'success' => FALSE,
                    'message' => 'Error, id not found.'
                ], 401);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();

            return response()->json([
                'success' => TRUE,
                'message' => 'Successfully deleted the user.'
            ]);
        } else {
            return response()->json([
                'success' => FALSE,
                'message' => 'Error, id not found.'
            ], 401);
        }
    }

    //Update user email
    public function updateEmail(Request $request, string $id)
    {
        $data = $request->json()->all();

        $user = User::find($id);

        if ($user) {
            $validator = Validator::make($data, [
                'email' => 'required|unique:users'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $arrErrors = [];

                foreach ($errors->all() as $message) {
                    $arrErrors[] = $message;
                }

                return $arrErrors;
            } else {
                $user->email = $data['email'];

                $user->save();
    
                return response()->json([
                    'success' => TRUE,
                    'message' => 'Successfully updated the email.'
                ]);
            }
        } else {    
            return response()->json([
                'success' => FALSE,
                'message' => 'Error, id not found'
            ]);
        }
    }
}
