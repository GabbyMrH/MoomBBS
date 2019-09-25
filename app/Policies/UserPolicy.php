<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //用户更新时权限验证
    //参数分别为当前登录用户实例和要进行授权的用户实例
    //比对当前登录用户和将授权用户是否相同
    public function update(User $currentUser,User $user)
    {
       return $currentUser->id === $user->id;
    }
}
