<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('index', compact('users'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|digits:10|unique:users',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|min:8',
        ]);

        $path = $request->file('profile_pic') ? $request->file('profile_pic')->store('profile_pics') : null;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'profile_pic' => $path,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('public/profile_pics');
            $user->profile_pic = $path;
        }
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('users.index');  // Redirect to the index route
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index'); 
    }

   

    public function export()
    {
        
        $filename = 'users.csv';
        $users = User::all();
       // dd($users);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($users) {
            $handle = fopen('php://output', 'w');
            // Add the headers of the CSV file
            fputcsv($handle, ['ID', 'Name', 'Email', 'Mobile', 'Profile Pic', 'Created At', 'Updated At']);

            // Add the rows of the CSV file
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->mobile,
                    $user->profile_pic,
                    $user->created_at,
                    $user->updated_at,
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}

