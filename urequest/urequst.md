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