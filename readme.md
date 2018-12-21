## laravel的学习笔记

### 安装

#### Composer

需要全局安装[composer](https://getcomposer.org),用于管理PHP的依赖关系，类似Node的NPM或python的pip

#### 开发环境
    
- Laravel Valet
    
- Laravel Homested
    
#### 创建laravel项目

- 使用 Laravel 安装工具
    
如果已经全局安装好 Composer ，可以执行以下命令来安装 Laravel 安装工具

`~ composer global require "laravel/installer=~1.1"`

现在可以使用以下命令来创建一个新的 Laravel 项目

`~ lavavel new projectName`

当前目录下会创建一个新的名为`projectName` 的子目录，并在其中创建了一个全新的 Laravel 项目

- 通过 composer 的 create-project

Composer 提供了一个 create-project 的命令，用于创建具有特定结构的新项目

`~ composer create-project laravel/laravel project-name --prefer-dist "5.5.*"`

执行效果和 Laravel 安装工具一致

### Laravel 目录结构

创建一个 demo，目录结构如下

````
- app/             应用程序大部分文件存放的地方，比如模型、控制器、路由定义、命令，以及 PHP 域名代码等
- bootstrap/       包含了 Laravel 框架每次运行时使用的文件
- config/          用于放置所有的配置文件
- database/        用于放置数据库迁移和数据库种子文件
- public/          当做站点运行时服务器指向的目录，该目录包含 index.php 入口文件，也放置一些公共文件，如图片、样式表、脚本或下载的文件等
- resources/       用于放置所有非 PHP 的其他脚本文件，比如视图文件、语言文件、Sass/Lass，以及javaScript等
- routes/          用于放置所有路由定义文件，包括 HTTP 路由、控制台路由和 Artisan 命令等 
- storage/         用于放置缓存、日志和系统编译文件
- tests/           用于放置单元测试用例和集成测试文件
- vendor/          用于放置 Composer 安装的依赖关系文件，是一个 git 忽略文件
- .env             指定环境变量，不同环境一些变量有差异在这里进行配置，是一个 git 忽略文件
- .env.example     .env文件的模板
- .gitattributes   git 配置文件
- .gitignore       git 配置文件
- artisan          从命令行运行 Artisan 命令的入口文件
- composer.json    定义了项目的基本信息和依赖关系
- composer.lock    composer 配置文件，不可编辑
- package.json     npm 的配置文件，处理前端依赖
- phpunit.xml      PHPUnit 的配置文件
- readme.md        介绍项目的信息
- server.php       备份服务器文件，尝试在功能较差的服务器中仍然对 Laravel 应用程序进行预览
- webpack.mix.js   Glup 的配置文件
````

### 启动和运行

- 使用自带的服务器

在项目根目录下使用以下命令来使用 php 自带服务器运行 Laravel 应用

`~ php artisan serve`

将会出现以下提示

`Laravel development server started: <http://127.0.0.1:8000>`

这时可以通过访问 `127.0.0.1:8000` 来访问应用

### 路由和控制器

#### 路由定义

在一个 Laravel 应用中，可以在 `routes/web.php` 中定义 Web 路由，也可以在 `routes/api.php` 中定义 Api 路由。Web 路由是提供给终端用户进行访问的，Api 路由则是提供 Api 服务的。

> 在 Laravel 5.3版本之前的项目中，只有一个路由文件，该路由文件位于 `app/Http/routes.php` 中

使用以下代码定义一个简单路由

````
Route::get('/hello', function() {
    return 'hello, world';
});
````

第一个参数为访问路径，第二个参数为一个闭包，这时候访问 `/hello` 就会执行定义好的闭包，返回结果。

> 闭包的执行结果应该 return 而不是 echo 或者 print，原因是 Laravel 的请求和响应过程包含很多封装起来的内容，包括所谓的中间件。仅仅定义好路由闭包以及控制器方法，还不足以将输出发送到浏览器，所以这里采用返回内容的方式，这样返回的内容可以继续在 response stack 以及中间件中运行，运行完成后再返回给浏览器。

##### 路由方法

Laravel 可以使用 HTTP 方法来定义路由，与之前的定义类似，只是将 `get` 换成其他 HTTP 方法

````
Route::post('/hello', function() {
    return 'hello,post';
});
````

`put`,`delete`,`patch` 类似

也可以使用 `any` 来匹配任意一个方法，或者使用 `match` 来匹配指定的方法

````
Route::any('/any', function() {
    return 'hello,world';
});
Route::match(['get', 'post'], '/hello', function() {
    return 'hello,world';
});
````

##### 路由处理

使用闭包进行路由处理虽然快速、简单，但是闭包会将所有的路由处理信息放在一个文件中，当应用程序越来越大时，路由信息也会越来越多。并且，使用路由闭包不能利用 Laravel 的路由缓存功能。

除了闭包，还可以使用控制器名和方法名来定义路由处理，如下

````
Route::get('/welcome', 'WelcomeController@index');
````

其含义为，让 `\Http\Controllers\WelcomeController` 的 `index` 方法来处理 `/welcome` 这个请求

##### 路由参数

如果定义的路由具有参数（可变的URL地址段），那么可以在路由中定义它们，并传递给闭包

````
Route::get('param/{id}', function($id) {
    return 'id is '.$id;
});
````

当有多个参数时，路由定义中的参数和闭包中的形参从左到右进行匹配，名称可以不同，但建议保持一致

````
Route::get('param/multi/{id1}/{id2}, function($id3, $id4) {
    return "id1 is {$id3},id2 is {$id4}";
});
````
> 参数数量需要严格保持一致，否则会报错

还可以通过在参数名称后添加一个 `?` 来实现路由参数的选择，但这种情况必须给对应的参数设置默认值

````
Route::get('/param/option/{id?}', function($id = 2) {
    return "id is {$id}";
});
````

还可以使用正则表达式来定义一个路由，这时，只有参数满足特定的模式时才会匹配

````
Route::get('/param/preg/{id}', function($id) {
    return "id is {$id}";
})->where('id', '[0-9]+');

Route::get('/param/preg_multi/{id}/{name}', function($id, $name) {
    return "id is {$id}, name is {$name}";
})->where(['id' => '[0-9]+', 'name' => '[A-Za-z]+']);
````

##### 路由名称

Laravel 允许为每个路由起一个名字，这样就可以在不明确引用什么 URL 的情况下引用该路由

````
Route::get('login', function() {
    return 'login';
})->name('login');
````

#### 路由组

通常，一组路由会有一些特定的特征，比如：一定的认证要求、路径前缀，或者是控制器与命名空间等。

路由组允许多个路由组合在一起，将任何共享的配置应用于整个路由组

````
Route::group([], function() {
    Route::get('/hello', function() {
        return 'hello';
    });
    Route::get('/world', function() {
        return 'world';
    });
});
````

##### 中间件

路由组最常见的功能就是将中间件应用于一组路由中，比如应用在权限控制方面，限制某组路由只能在用户登录状态才能访问

````
Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', function() {
        return 'dashboard';
    });
});
````

当没登录时访问 `/dashboard`，会发现跳转到前面定义路由名称为 `login` 的那条路由

##### 路由前缀

如果有一组路由需要共享某个路径段，那么可以使用路由组来简化结构

````
Route::group(['prefix' => 'prefix'], function() {
    Route::get('/', function() {
        return 'prefix root';
    });
    
    Route::get('/api', function() {
        return 'prefix api';
    });
});
````

##### 子域名路由（先跳过）

##### 命名空间前缀

当按照子域名或者路由前缀的方式对路由进行分组时，它们的控制器可能会有相同的 PHP 命名空间。所有的 API 控制器都可能在一个 API 命名空间内，通过使用路由组命名空间前缀，就可以避免在群组内使用很长的控制器进行引用

````
Route::group(['namespace' => 'API'], function () {
    Route::get('/api', 'ControllerB@index');
});
````

#### 控制器

控制器并不是一个应用程序的唯一入口，还可能有 cron作业(定时任务)、Artisan 命令行调用、队列作业等。因此业务逻辑尽量不在控制器中处理，控制器的主要任务是捕获 HTTP 请求，并传递给其他部分处理

控制器统一放在 `app/Http/Controllers` 目录下，可以使用 Artisan 来创建一个新的控制器

`php artisan make:controller NewController`

#### 获取用户输入

控制器中最常见的操作上试从用户那里获取输入内容并对其进行处理，从 POST 中获取用户输入主要有两种方式：使用 Input facade或者请求对象 Request

##### 使用 Input

````
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

````
// TaskController.php

public function store(\Illuminate\Http\Request $request)
{
    $title = $request->input('title');
    $description = $request->input('description');

    return "title is {$title}, description is {$description}";
}
````

#### 资源控制器

对于传统的 Rest/CURD 控制器，Laravel 定义了一套命名规范、开箱即用的开发工具以及对应的路由定义，这样就可以提高开发 Rest 接口的效率

使用以下命令创建一个资源控制器

`php artisan make:controller TasksController --resource`

生成的控制器中预先包含了 `index` 、`create` 、`store` 、`show` 、`edit` 、`update`  、`destory` 几个方法

|HTTP动词|URI|控制器方法|路由名称|描述|
|----|----|----|----|----|
|GET|tasks|index()|tasks.index|显示所有任务|
|GET|tasks/create|create()|tasks.create|显示创建任务表单|
|POST|tasks|store()|tasks.store|新建表单提交数据|
|GET|tasks/{taskId}|show()|tasks.show|显示一个任务|
|GET|tasks/{taskId}/edit()|tasks.edit|显示编辑任务表单|
|PUT/PATCH|tasks/{taskId}/update()|tasks.update|根据Id更新表单提交数据|
|DELETE|tasks/{taskId}|destroy()|tasks.destroy|删除一个任务|