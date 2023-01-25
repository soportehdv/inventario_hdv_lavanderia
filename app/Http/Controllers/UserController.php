<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Datatables;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }



    public function getUser(Request $request)
    {

        if($request){

            $query= trim($request->get('search'));
            $user= User::where('name','LIKE', '%' . $query . '%')
            ->orderBy('id', 'asc')
            ->get();


            return view('user/lista', [
                'users' => $user,
                'search' => $query
            ]);

        }
    }

    public function create()
    {
        return view('user/create');
    }

    public function createUser(Request $request)
    {

        //validamos los datos
        $validate = request()->validate( [
            'name'      => 'required',
            'cargo'     => 'required',
            'email'     => 'required',
            'rol'       => 'required',
            'password'  => ['required','min:6','confirmed'],
        ],[
            'name.required'      => 'El campo nombre es obligatorio',
            'cargo.required'      => 'El campo cargo es obligatorio',
            'email.required'      => 'El campo correo es obligatorio',
            'rol.required'      => 'El campo rol es obligatorio',
            'password.required'  => 'El campo contraseña es obligatorio',
            'password.min'  => 'La contraseña debe tener al menos 6 caracteres',
            'password.confirmed'  => 'Las contraseñas no coinciden',
        ]);

        $user = new User;
        $user->name = $request->input('name');
        $user->cargo = $request->input('cargo');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->rol = $request->input('rol');
        $user->save();
        $request->session()->flash('alert-success', 'Usuario registrado con exito!');


        return redirect()->route('user.lista');
    }

    public function update($id)
    {
        $user = User::where('id', $id)->first();

        return view('user/edit', [
            'user' => $user
        ]);
    }

    public function updateUser(Request $request, $user_id)
    {

        $user = User::where('id', $user_id)->first();

        if ($request->input('password') != null) {
            //validamos los datos
            $validate = request()->validate( [
                'password'  => ['required','min:6','confirmed'],
            ],[
                'password.required'  => 'El campo contraseña es obligatorio',
                'password.min'  => 'La contraseña debe tener al menos 6 caracteres',
                'password.confirmed'  => 'Las contraseñas no coinciden',
            ]);

            $user->password = bcrypt($request->input('password'));
            $user->save();
        }
        else{
            //validamos los datos
         $validate = request()->validate( [
            'name'      => 'required',
            'cargo'     => 'required',
            'email'     => 'required',
            'rol'       => 'required',
        ],[
            'name.required'      => 'El campo nombre es obligatorio',
            'cargo.required'      => 'El campo cargo es obligatorio',
            'email.required'      => 'El campo correo es obligatorio',
            'rol.required'      => 'El campo rol es obligatorio',
        ]);


        $user->name = $request->input('name');
        $user->cargo = $request->input('cargo');
        $user->email = $request->input('email');
        $user->rol = $request->input('rol');
        $user->save();
        }


        $request->session()->flash('alert-success', 'Usuario actualizado con exito!');


        return redirect()->route('user.lista');
    }


    public function deleteUser()
    {
    }
}
