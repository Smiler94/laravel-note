# 原始 SQL 语句

可以使用 DB Facade 以及 statement() 方法来实现任何原始调用，但对不同的操作有一些特定的方法

----------

- 原始查询
- 参数和命名绑定

#### 原始查询

DB 的特殊方法中最简单的就是 `select()`，不用添加任何参数就可以运行

```php
$passwords = DB::select('select * from password');
```

会返回一个 stdClass 对象的集合

#### 参数和命名绑定

Laravel 的数据库结构允许使用 PDO 参数绑定，它可以保护查询不受潜在的 SQL 攻击。

```php
// 使用 ?
$password = DB::select('select * from password where type =?', [$type]);

// 使用 :arg
$password = DB::select('select * from password where type = :type', ['type' => $type]);
```

> {info} 使用原生 sql 进行插入、更新、删除可以使用同样的方法进行参数和命名绑定

|方法|返回结果|
|----|----|
|select()|返回查询结果集|
|insert()|返回自增长的id|
|update()|返回受影响的行数|
|delete()|返回受影响的行数|
