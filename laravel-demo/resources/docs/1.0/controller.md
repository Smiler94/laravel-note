# 控制器

控制器并不是一个应用程序的唯一入口，还可能有 cron作业(定时任务)、Artisan 命令行调用、队列作业等

因此业务逻辑尽量不在控制器中处理，控制器的主要任务是捕获 HTTP 请求，并传递给其他部分处理

-------

- [获取用户输入](#获取用户输入)
- [资源控制器](#资源控制器)

控制器统一放在 `app/Http/Controllers` 目录下，可以使用 Artisan 来创建一个新的控制器

`~ php artisan make:controller NewController`

## 获取用户输入

控制器中最常见的操作上试从用户那里获取输入内容并对其进行处理，从 POST 中获取用户输入主要有两种方式：使用 Input facade或者请求对象 Request

##### 使用 Input

````php
// TaskController.php

use Illuminate\Support\Facades\Input;
// 书上说也可以使用 \Input，实际操作发现会报错
...
public function store()
{
    $title = Input::get('title');
    $description = Input::get('description');
    
    return "title is {$title}, description is {$description}";
}
````

##### 使用 Request 对象注入到控制器

在控制器的方法中指定需要的 Request 对象

````php
// TaskController.php

public function store(\Illuminate\Http\Request $request)
{
    $title = $request->input('title');
    $description = $request->input('description');

    return "title is {$title}, description is {$description}";
}
````

## 资源控制器

对于传统的 Rest/CURD 控制器，Laravel 定义了一套命名规范、开箱即用的开发工具以及对应的路由定义，这样就可以提高开发 Rest 接口的效率

使用以下命令创建一个资源控制器

`~ php artisan make:controller TaskController --resource`

##### 资源控制器的方法

生成的控制器中预先包含了 `index` 、`create` 、`store` 、`show` 、`edit` 、`update`  、`destory` 几个方法

|HTTP动词|URI|控制器方法|路由名称|描述|
|----|----|----|----|----|
|GET|task|index()|task.index|显示所有任务|
|GET|task/create|create()|task.create|显示创建任务表单|
|POST|task|store()|task.store|新建表单提交数据|
|GET|task/{taskId}|show()|task.show|显示一个任务|
|GET|task/{taskId}/edit|edit()|task.edit|显示编辑任务表单|
|PUT/PATCH|tasks/{taskId}|update()|task.update|根据Id更新表单提交数据|
|DELETE|tasks/{taskId}|destroy()|task.destroy|删除一个任务|

> {info} 考虑能否使用给一个通用的控制器集成所有的 CURD 入口

##### 绑定资源控制器

为了不用手动为资源控制器的每个方法建立一个路由，Laravel 提供了“资源控制器绑定”的方法

````php
// routes/web.php
// 资源控制器的路由定义
Route::resource('task', 'TaskController');
````