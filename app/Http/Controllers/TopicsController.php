<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        // 对除了 index() 和 show() 以外的方法使用 auth 中间件进行认证。
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request,Topic $topic,User $user,Link $link)
	{
        //$request->order 是获取 URI http://moom-bbs.test/topics?order=recent 中的 order 参数。
        $topics = $topic->withOrder($request->order)->paginate(20);
        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();
        return view('topics.index', compact('topics', 'active_users','links'));
	}

    //此处使用 Laravel 的 『隐性路由模型绑定』 功能
    public function show(Request $request, Topic $topic)
    {
        // URL 矫正
        //  需要访问用户请求的路由参数 Slug，在 show() 方法中我们注入 $request；
        // ! empty($topic->slug) 如果话题的 Slug 字段不为空；
        // && $topic->slug != $request->slug 并且话题 Slug 不等于请求的路由参数 Slug；
        // redirect($topic->link(), 301) 301 永久重定向到正确的 URL 上。
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        //将所有的分类读取赋值给变量 $categories
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
        return redirect()->to($topic->link())->with('success', '帖子创建成功！');	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

        return redirect()->to($topic->link())->with('success', '更新成功！');	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除成功.');
    }

    //图片上传
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}
