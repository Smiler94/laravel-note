# 查询构造器

Laravel的数据库核心功能是查询构造器，也就是与数据库交互的流畅界面

-----

- DB Facade的基本使用
- 原始 SQL 语句
- 查询构造器链
- 条件方法

## DB Facade的基本使用

DB Facade 用于查询构造链和简单的原始查询语句

```php
// 基本语句
DB::statement('drop table users');

// 原始查询和参数绑定
DB::select('select * from contacts where validated = ?', [true]);

// 流畅构造器
$user = DB::table('users')->get();

// join和其他调用
DB::table('users')->join('contacts', function ($join) {
    $join->on('users.id', '=', 'contacts.user_id')
            ->where('contacts.type', 'donor');
})
```

## 原始 SQL 语句

可以使用 DB Facade 以及 statement() 方法来实现任何原始调用，但对不同的操作有一些特定的方法

- select() 返回查询结果集
- insert() 返回自增长的id
- update() 返回受影响的行数
- delete() 返回受影响的行数

##### 原始查询

DB 的特殊方法中最简单的就是 `select()`，不用添加任何参数就可以运行

```php
$passwords = DB::select('select * from password');
```

会返回一个 stdClass 对象的集合

##### 参数和命名绑定

Laravel 的数据库结构允许使用 PDO 参数绑定，它可以保护查询不受潜在的 SQL 攻击。

```php
// 使用 ?
$password = DB::select('select * from password where type =?', [$type]);

// 使用 :arg
$password = DB::select('select * from password where type = :type', ['type' => $type]);
```

使用原生 sql 进行插入、更新、删除可以使用同样的方法进行参数和命名绑定

## 查询构造器链

查询构造器能把方法都链接起来，然后构造一个查询，在链接的最后，使用一些方法来触发之前构造的查询

```php
DB::table('password')->where('id', $id)->get();
```

- table('password') 查询 password 表
- where('id', $id) id 作为条件
- get() 触发查询的方法

## 条件方法

使用以下方法可以为查询添加一些查询条件，或指定返回的列

- select() 允许指定想选择的列

```php
$password = DB::table('password')->select('account', 'password as pwd')->get();

// 或者
$password = DB::table('password')->select('account')->addSelect('password as pwd')->get();
```

- where() 添加 and 条件，一般需要三个参数，列、比较运算符和值

```php
$password = DB::table('password')->where('created_at', '>', Carbon::now()->subDay())->get();

// 使用 = 运算符时可以省略第二个参数
$password = DB::table('password')->where('name', 'baidu')->get();

// 同样接受一个数组参数
$password = DB::table('password')->where([
    ['created_at', '>', Carbon::now()->subDay()],
    ['name', 'baidu']        
])->get();
```

- orWhere() 添加 or 条件，参数与where类似

```php
$password = DB::table('password')->where('name', 'baidu')->orWhere('name', 'tengxun')->get();

// 如果想创建更加复杂、多条件的 or 子句，则需要传入一个闭包
$password = DB::table('password')->where('type', 1)
            ->orWhere(function ($query) {
                $query->where('created_at', '>', Carbon::now()->subDay())->where('type', 2);
            })->();
// select * from password where type = 1 or (created_at > NOW and type = 2) 
```

- whereBetween(colName, [low, hight]) 添加介于两个值之间条件

```php
DB::table('password')->whereBetween('id', [1, 10]);

// select * from password where id > 1 and id < 10;
```

- whereIn(colName, [1,2,3]) 添加 in 条件

```php
DB::table('password')->whereIn('id', [1,10]);

// select * from password where id in (1,10);
```

- whereNotIn(colName, [1,2,3]) 添加 not in 条件

```php
DB::table('password')->whereNotIn('id', [1,10]);

// select * from password where id not in (1,10);
```

- whereNull(colName) 指定列为null

```php
DB::table('password')->whereNull('name');

// select * from password where name is null;
// whereNotNull('name') 即 name not null
```

- whereRaw($query) 添加 $query 到 where 子句后面

```php
DB::table('password')->whereIn('id', [1,2])->whereRaw('type = 2');

// select * from password where id in (1,2) and type = 2;
```

> {danger} 警惕SQL注入，传入 whereRaw() 的sql查询都是不能转义的，为了避免sql注入，尽量不适用这个方法

- whereExists()

```php
$commenters = DB::table('users')
            ->whereExists(function ($query) {
                $query->select('id')->from('comments')->whereRaw('comments.user_id = users.id');
            })
            ->get();
```

- distinct() 返回去重后的数据

```php
DB::table('password')->select('type,name')->distinct()->get();

// select distinct `type,name` from password
```

