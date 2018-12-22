### 收集和处理用户请求

用户的输入往往是多样的：URL路径、查询参数、POST 数据、文件上传等，Laravel 提供了一组工具，用于收集、验证、归一化和过滤用户提供的数据

#### 注入请求对象

在 Laravel 中访问用户数据的最常见工具是注入 `Illuminate\Http\Request` 对象的示例，它可以轻松访问用户能够在站点中输入的所有形式的数据：POST 、posted JSON 、 GET 和 URL 片段等 

可以通过制定控制器方法的参数来注入一个 Request 对象

````php
// TaskController.php

public function store(\Illuminate\Http\Request $request)
{
    // $request->input('')
}
````

Request 对象常用方法

|方法名|作用|参数|
|----|----|----|
|all()|返回一个包含用户所有输入的数组|-|
|except()|返回除某些字段外的所有输入|字段名或字段名数组|
|only()|与except相反，返回指定字段的输入|字段名或字段名数组|
|has()|判断某些字段是否存在|字段名或字段名数组|
|exists()|判断某些字段是否存在|字段名或字段名数组|
|input()|返回单个字段的值|字段名，默认值|
|json()|从请求的json数据中获取数据|字段名，默认值|
|filled()|判断某些字段是否存在且有值|字段名或字段名数组|

> 从 Laravel5.4 开始加入了 `ConvertEmptyStringsToNull` 和 `TrimStrings` 两个中间价，默认将请求数据里的空字符串转换为了 null

> has 和 exists，试验了下，发现这两个方法的逻辑是一样的，都只是判断某些字段是否存在，可以用 filled 方法来判断字段是否存在且有值

> json 存在的原因
> - 明确应用程序的输入源为 json 格式
> - 如果 POST 没有 `application/json` 请求头，json 仍能正确读取到数据，但是 input 不能

#### 路由数据

URL 中可能也会包含有部分用户数据，有两种方法可以获取到这些数据

##### 通过 Request 对象

对于URL，在域名之后的每组字符都称为片段

`http://laraval.lz/users/15` 这个 URL 包含有 `users` 和 `15` 两个片段

使用 `$request` 的 `segment` 方法可以获取指定索引的单个片段，索引值从1开始，所以上述例子中 `$request->segment(1)` 将返回 `users`

##### 通过路由参数

路由中的参数同样可以被注入到控制器的方法中

````php
// routes/web.php
Route::get('test/{id}', 'TaskController@view');

// TaskController
public function show($id)
{
    return "id is {$id}";
}
````

#### 文件上传

使用 request 对象实例的 `file` 方法可以访问任何上传的文件，该方法的参数是文件的输入名称，并返回 `Symfony\Component\HttpFoundation\File\UploadedFile` 的实例

````php
// FileController.php
public function upload(Request $request)
{
    if ($request->hasFile('file')) {
        var_dump($request->file('file'));
    }
}
````

> 确保表单上添加了 `enctype="multipar/form-data"` 属性

> 使用 postman 测试时，需要把 Headers 里的 `Content-type` 属性去掉

#### 数据验证

主要有两种方式用于验证传入的数据

##### 在控制器中使用 `ValidatesRequests` 的 `validate` 方法

````php
// RecipeController.php
public function store(Request $request)
{
    //
    $this->validate($request, [
        'title' => 'required|max:125',
        'body' => 'required'
    ]);

}
````