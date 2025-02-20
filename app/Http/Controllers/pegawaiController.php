<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class pegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $data = User::paginate();
         $data = User ::where('name','like',"%{$search}%")
         ->orWhere('level', 'like',"%{$search}%")
         ->paginate();
        return view('pegawai.pegawai', compact(
        'data'
        ));
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'level' => 'required',
        ]);

        $save = new User();
        $save->name = $request->name;
        $save->email = $request->email;
        $save->password = Hash::make ($request->password);
        $save->level = $request->level;
        $save->save();

        // dd($save);

        return redirect()->back()->with(
            'message',
            'Data Pegawai Berhasil Ditambahkan'
        );



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
        $getData = User::find($id);
        return view( 'pegawai.editPegawai', compact(
            'getData'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'password' => 'nullable|min:6',
            'level' => 'nullable',
        ]);

        $updateUser = user::find($id);
        $updateUser->name = $request->name;

        if ($request->filled('email') && $request->email != $updateUser->email)  {
            $request->validate([
                'email' => 'unique:users,email',
            ], [
            ]);

            $updateUser->email = $request->email;
        # code...
        }

        if ($request->filled('password')) {
            $updateUser->password = hash::make($request->password);
            # code...
        }
        if ($request->filled('level')) {
            $updateUser->level = $request->level;
            # code...
        }
        //untuk save
        $updateUser->save();

        return redirect('/pegawai')->with(
            'massage',
            'Data Pegawai Berhasil Diubah'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $getData = user::find($id);
        $getData->delete();

        return redirect()->back()->with(
            'message',
            'Data Pegawai Berhasil Dihapus!!!'
        );
    }
}
