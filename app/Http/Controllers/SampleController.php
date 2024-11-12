<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function table(Request $request) {
        $items = User::paginate(10);
        $columns = ['id' => 'ID', 'email' => 'メール', 'name' => '氏名'];

        return view('table_sample', compact('items', 'columns'));
    }
}
