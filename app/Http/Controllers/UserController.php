<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    protected $service;

    public function __construct(
        UserService $service,
    ) {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $per_page_options = [
            ['label' => '10件表示', 'count' => '10'],
            ['label' => '20件表示', 'count' => '20'],
            ['label' => '50件表示', 'count' => '50'],
            ['label' => '100件表示', 'count' => '100'],
            ['label' => '200件表示', 'count' => '200'],
        ];
        $validated = $request->validate(
            [
            'per_page' => ['integer'],
            ]
        );
        $users = $this->service->getUsers($validated);
        $columns = [
            'name' => '名前',
            'email' => 'メールアドレス',
            'role_name' => '権限',
        ];

        return view(
            'users.index', [
            'items' => $users,
            'columns' => $columns,
            'actions' => ['edit', 'delete', 'bulk_delete', 'selectable'],
            'query' => ['per_page_options' => $per_page_options],
            'perPageOptions' => $per_page_options,
            ]
        );
    }
    
    public function create(Request $request)
    {
        return view('users.create');
    }
    
    public function store(StoreUserRequest $request)
    {
        $result = $this->service->store($request->validated());
        if ($result) {
            return redirect()->route('users.index')->with('success', '正常に保存しました。');
        }
        return back()->withInput()->with('error', 'エラーが発生しました。');
    }
    
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    
    public function update(UpdateUserRequest $request, int $id)
    {
        $result = $this->service->update($id, $request->validated());
        if ($result) {
            return redirect()->route('users.index')->with('success', '正常に保存しました。');
        }
        return back()->withInput()->with('error', 'エラーが発生しました。');
    }
    
    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return redirect()->back()->withInput()->with('success', '削除しました');
    }
    
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            $this->service->deleteAll($validated['checks']);
        }
        return redirect()->back()->withInput()->with('success', '一括削除しました。');;
    }
    
}
