<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $profiles = [
        [
            'id' => 1,
            'name' => 'Khaled Hesham',
            'age' => 23,
            'email' => 'khaledhesham007@gmail.com'
        ],
        [
            'id' => 2,
            'name' => 'Desmond Miles',
            'age' => 32,
            'email' => 'Desmond.M@abstergo.org'
        ],
        [
            'id' => 3,
            'name' => 'Thomas Shelby',
            'age' => 34,
            'email' => 'BigTommy@shelbycompany.ltd'
        ],
    ];

    public function index()
    {
        return view('profiles.index', ['profiles' => $this->profiles]);
    }
    public function show($id)
    {
        $profile = collect($this->profiles)->firstWhere('id', $id);

        if (!$profile) {
            abort(404);
        }

        return view('profiles.show', ['profile' => $profile]);
    }
}
