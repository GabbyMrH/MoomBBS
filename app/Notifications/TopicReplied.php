<?php

namespace App\Notifications;

use App\Models\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

//检测 ShouldQueue 接口并自动将通知的发送放入队列中
class TopicReplied extends Notification implements ShouldQueue
{
    use Queueable;
    public $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        // 注入回复实体，方便 toDatabase 方法中的使用
        $this->reply = $reply;
    }

    /**
     * 每个通知类都有个 via() 方法，它决定了通知在哪个频道上发送。我们写上 database 数据库来作为通知频道
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //默认为邮件通知
        //return ['mail'];

        // 开启通知的频道
        return ['database','mail'];

    }
    //因为使用数据库通知频道，我们需要定义 toDatabase()。
    //这个方法接收 $notifiable 实例参数并返回一个普通的 PHP 数组。这个返回的数组将被转成 JSON 格式并存储到通知数据表的 data 字段中
    public function toDatabase($notifiable)
    {
        $topic = $this->reply->topic;
        $link =  $topic->link(['#reply' . $this->reply->id]);

        // 存入数据库里的数据
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'user_id' => $this->reply->user->id,
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'topic_link' => $link,
            'topic_id' => $topic->id,
            'topic_title' => $topic->title,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $topic = $this->reply->topic;
        $url = $this->reply->topic->link(['#reply' . $this->reply->id]);
        $content = [
            'topic_title'=>$topic->title
        ];

        return (new MailMessage)
                    ->line('你的话题有新回复！')
                    ->line('话题名称:'.$content['topic_title'])
                    ->action('查看回复', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
