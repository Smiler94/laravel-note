### Tinker

Tinker 是一种 REPL(交互式解释器)，也被叫做 读取-执行-输出 循环

REPL 会弹出一个提示，和命令行中的提示很类似，类似于应用中的 "等待" 状态。在 REPL 中输入命令后敲回车，然后程序会根据输入的内容响应并打印结果

````
~ php artisan tinker
>>> $user = new App\User;
=> App\User {#2914}
>>> $user->email = 'linzhen@qq.com'
=> "linzhen@qq.com"
>>> $user->name = 'linzhen'
=> "linzhen"
>>> $user->password = scrypt('123456')
=> "$2y$10$RI36leo7hi.pgNZHqUzBwev332jVvxOu5O/mXtaL.xLWZBdc0Zbrq"
>>> $user->save()
=> true
````