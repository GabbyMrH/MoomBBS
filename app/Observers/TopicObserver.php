<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;

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
        //xss过滤器
        $topic->body = clean($topic->body, 'user_topic_body');

        //生成话题摘录 make_excerpt()为自定义辅助函数-需要在helpers.php中添加
        $topic->excerpt = make_excerpt($topic->body);

    }

    //保存
    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        //is_Dirty() 查询模型类是否已对其进行编辑，或者未保存模型
        if ( ! $topic->slug || $topic->isDirty('title')) {

            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }

    //监听器-监听删除
    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
