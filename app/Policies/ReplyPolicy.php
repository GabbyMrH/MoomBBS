<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {
        // 『回复的作者』或者『回复话题的作者』才具有删除权限
        //isAuthorOf()是自定义辅助方法
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
