<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request){
        $validatedData = $request->validate([
            'name'=>['required', 'min:4', 'max:255'],
            'email'=>['required','email','unique:users'],
            'password'=>['required','min:5','max:255']
        ]);

        DB::beginTransaction();
        try {
            $user = new User($validatedData);
            $user->password = Hash::make($user->password);
            $user->saveOrFail();

            DB::commit();            
        } catch (Throwable $throwable) {
            DB::rollback();
            Throw $throwable;
        }

        return redirect('/login')->with('success','Registration successfull! Please Login');
    }
}
