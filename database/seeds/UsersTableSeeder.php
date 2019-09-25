<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // 获取 Faker 实例
       $faker = app(Faker\Generator::class);

       // 头像假数据
       $avatars = [
           'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
           'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
           'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
           'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
           'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
           'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
       ];

       // 生成数据集合
       $users = factory(User::class)
                       ->times(10) //指定生成数量
                       ->make()
                       //use 是 PHP 中匿名函数提供的本地变量传递机制，匿名函数中必须通过 use 声明的引用，才能使用本地变量
                       ->each(function ($user, $index)
                           use ($faker, $avatars)
       {
           // 从头像数组中随机取出一个并赋值
           $user->avatar = $faker->randomElement($avatars);
       });

       // 让隐藏字段可见，并将数据集合转换为数组
       $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

       // 插入到数据库中
       User::insert($user_array);

       // 单独处理第一个用户的数据
       $user = User::find(1);
       $user->name = 'gabby';
       $user->email = '201824001@qq.com';
       $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
       $user->save();

   }
}
