<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        //在创建时，监听并净化xss攻击
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    //监听created事件，当 Elequont 模型数据成功创建时，created 方法将会被调用。
    public function created(Reply $reply)
    {
        //自增1
        //$reply->topic->increment('reply_count', 1);

        //将评论数存入数据库
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }

    public function updating(Reply $reply)
    {
        //
    }

}
