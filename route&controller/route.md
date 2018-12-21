### 路由

#### 路由定义

在一个 Laravel 应用中，可以在 `routes/web.php` 中定义 Web 路由，也可以在 `routes/api.php` 中定义 Api 路由。Web 路由是提供给终端用户进行访问的，Api 路由则是提供 Api 服务的。

> 在 Laravel 5.3版本之前的项目中，只有一个路由文件，该路由文件位于 `app/Http/routes.php` 中

使用以下代码定义一个简单路由

````php
Route::get('/hello', function() {
    return 'hello, world';
});
````

第一个参数为访问路径，第二个参数为一个闭包，这时候访问 `/hello` 就会执行定义好的闭包，返回结果。

> 闭包的执行结果应该 return 而不是 echo 或者 print，原因是 Laravel 的请求和响应过程包含很多封装起来的内容，包括所谓的中间件。仅仅定义好路由闭包以及控制器方法，还不足以将输出发送到浏览器，所以这里采用返回内容的方式，这样返回的内容可以继续在 response stack 以及中间件中运行，运行完成后再返回给浏览器。

##### 路由方法

Laravel 可以使用 HTTP 方法来定义路由，与之前的定义类似，只是将 `get` 换成其他 HTTP 方法

````php
Route::post('/hello', function() {
    return 'hello,post';
});
````

`put`,`delete`,`patch` 类似

也可以使用 `any` 来匹配任意一个方法，或者使用 `match` 来匹配指定的方法

````php
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

````php
Route::get('/welcome', 'WelcomeController@index');
````

其含义为，让 `\Http\Controllers\WelcomeController` 的 `index` 方法来处理 `/welcome` 这个请求

##### 路由参数

如果定义的路由具有参数（可变的URL地址段），那么可以在路由中定义它们，并传递给闭包

````php
Route::get('param/{id}', function($id) {
    return 'id is '.$id;
});
````

当有多个参数时，路由定义中的参数和闭包中的形参从左到右进行匹配，名称可以不同，但建议保持一致

````php
Route::get('param/multi/{id1}/{id2}, function($id3, $id4) {
    return "id1 is {$id3},id2 is {$id4}";
});
````

> 参数数量需要严格保持一致，否则会报错

还可以通过在参数名称后添加一个 `?` 来实现路由参数的选择，但这种情况必须给对应的参数设置默认值

````php
Route::get('/param/option/{id?}', function($id = 2) {
    return "id is {$id}";
});
````

还可以使用正则表达式来定义一个路由，这时，只有参数满足特定的模式时才会匹配

````php
Route::get('/param/preg/{id}', function($id) {
    return "id is {$id}";
})->where('id', '[0-9]+');

Route::get('/param/preg_multi/{id}/{name}', function($id, $name) {
    return "id is {$id}, name is {$name}";
})->where(['id' => '[0-9]+', 'name' => '[A-Za-z]+']);
````

##### 路由名称

Laravel 允许为每个路由起一个名字，这样就可以在不明确引用什么 URL 的情况下引用该路由

````php
Route::get('login', function() {
    return 'login';
})->name('login');
````

#### 路由组

通常，一组路由会有一些特定的特征，比如：一定的认证要求、路径前缀，或者是控制器与命名空间等。

路由组允许多个路由组合在一起，将任何共享的配置应用于整个路由组

````php
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

````php
Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', function() {
        return 'dashboard';
    });
});
````

当没登录时访问 `/dashboard`，会发现跳转到前面定义路由名称为 `login` 的那条路由

##### 路由前缀

如果有一组路由需要共享某个路径段，那么可以使用路由组来简化结构

````php
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

````php
Route::group(['namespace' => 'API'], function () {
    Route::get('/api', 'ControllerB@index');
});
````

#### 路由缓存

Laravel 的引导程序需要解析 routes/*.php 文件，这个过程大概需要几十到几百毫秒，路由缓存则可以极大程度上加快这一过程的速度

使用以下命令对路由文件进行缓存，Laravel 会将 routes/*.php 文件的结果进行序列化

`~ php artisan route:cache`

如果要删除缓存，使用以下命令

`~ php artisan route:clear`

> * 要想进行路由缓存，要求路由文件中不能包含闭包路由，因此推荐所有的路由定义使用控制器和资源路由
> * 修改了路由文件后，需要重新执行命令来更新路由缓存，否则修改将不生效。因此在本地开发时，建议不进行路由缓存，部署到生产环境后再进行

> 可以使用 `~ php artisan route:list` 命令查看当前应用程序中定义了哪些路由