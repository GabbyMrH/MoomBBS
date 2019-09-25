<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    //在 Topic 模型保存时触发的 saving 事件
    public function saving(Topic $topic)
    {
        //过滤器
        $topic->body = clean($topic->body, 'user_topic_body');

        //make_excerpt()为自定义辅助函数-需要在helpers.php中添加
        $topic->excerpt = make_excerpt($topic->body);
    }
}
