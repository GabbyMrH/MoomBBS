<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    //过滤未登录用户的操作
    public function __construct()
    {
        //middleware接收两个参数，分别为中间件名称和要过滤的动作,此处意思除此动作外，其他都需要登录才能访问
        $this->middleware('auth',['expect'=>['show']]);
    }
    //个人页面
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    //编辑页面
    public function edit(User $user)
    {
        //通过授权策略验证用户操作是否与当前登录用户相符,此处的update时值授权策略类的update方法
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }
    //更新个人资料-调用了FormRequest请求验证用户提交数据
    //ps:上传文件要在form表单添加enctype="multipart/form-data"
    public function update(UserRequest $request,ImageUploadHandler $uploader,User $user)
    {
        $this->authorize('update',$user);
        //赋值 $data 变量，以便对更新数据的操作
        $data = $request->all();
        //验证上传文件
        if($request->avatar){    //416为尺寸
            $result = $uploader->save($request->avatar,'avatars',$user->id,416);
            //将返回参数插入data数组，用于更新路径
            if($result){
                $data['avatar'] = $result['path'];
            }
        }
        //更新数据
        $user->update($data);
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功');
    }

}
