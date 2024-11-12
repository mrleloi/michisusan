<?php

namespace App\Services;

use Auth;
use App\Models\User;

class UserService
{
    public const DEFAULT_PER_PAGE = 10;

    public function getUsers($params)
    {
        return User::query()->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }
    
    public function findById(int $id)
    {
        return User::find($id);
    }
    
    public function store(array $data)
    {
        $user = new User();
        $user->site_id = Auth::user()->site_id;
        $user->fill($data);
        $user->save();
        return $user;
    }

    public function update(int $id, array $data)
    {
        if (!$data['password']) {
            unset($data['password']);
        }
        return $this->findById($id)->update($data);
    }

    public function destroy(int $id)
    {
        $this->findById($id)->delete();
    }

    public function deleteAll($ids)
    {
        return User::whereIn('id', $ids)->delete();
    }
}
