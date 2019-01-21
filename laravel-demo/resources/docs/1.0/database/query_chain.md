# 查询构造器链

查询构造器能把方法都链接起来，然后构造一个查询，在链接的最后，使用一些方法来触发之前构造的查询

```PHP
DB::table('password')->where('id', $id)->get();

// table('password') 查询 password 表
// where('id', $id) id 作为条件
// get() 触发查询的方法
```

-------

- 条件方法
- 修改方法
- 结束/返回结果
- 联表查询
- union连接
- 插入数据
- 更新数据
- 删除数据

### 条件方法

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

#### 修改方法

这些方法改变了查询的结果

- orderBy(colName, direction) 对结果进行指定列排序

```php
DB::table('password')->orderBy('id', 'desc')->get();

// select * from password order by desc;
// 第二个参数默认为 asc
```

- groupBy(colName) 和 having()或者havingRaw() 组合输出结果，having和havingRaw可以对组合的属性添加条件

```php
DB::table('password')->groupBy('type')->havingRaw('count(id) > 10')->get();

// select * from password group by type having count(id) > 10;
```

- skip() 和 take() 大多时候用于分页，可以用它们来定义返回的行数以及在返回之前跳过多少行

```php
DB::table('password')->skip(10)->take(10)->get();

// select * from `password` limit 10 offset 10;
```

- latest(colName) 按传入列按降序排序，相当于orderBy(colName, 'desc')
- oldest(colName) 按传入列按升序排序，相当于orderBy(colName, 'asc')

```php
DB::table('password')->latest('id')->get();

// select * from password order by desc;
```

- inRandomOrder() 将结果随机排序

```php
DB::table('password')->inRandomOrder()->get();

// select * from `password` order by RAND()
```

#### 结束/返回结果

定义好构造器，就可以用这些方法触发 sql 的执行

- get() 获取所有结果

```php
// 可以传入数组来指定返回的列
DB::table('password')->get(['name', 'url']);

// select `name`, `url` from `password`
```

- first() 获取第一个结果 
- firstOrFail() 同first()，如果没有结果则抛出异常

```php
DB::table('password')->first(['name', 'url']);

// select `name`, `url` from `password` limit 1
```
- find(id) 获取指定id的值
- findOrFail(id) 同find(id)，如果没有结果则抛出异常

```php
DB::table('password')->find(1);

// select * from `password` where `id` = 1
```
> {warning} firstOrFail 和 findOrFail 只能应用于 Eloquent 模型，会抛出 `ModelNotFoundException` 异常

- value(colName) 从第一行结果中取某个字段

```php
DB::table('password')->value('url');

// select `url` from `password` limit 1

```

- count() 统计结果的数量

```php
DB::table('password')->count();

// select count(*) as aggregate from `password`
```

- min(colName) 获取指定列的最小值
- max(colName) 获取指定列的最大值
- sum(colName) 获取指定列的和
- avg(colName) 获取指定列的平均值

```php
DB::table('password')->min('id');

// select min(`id`) as aggregate from `password` 
```

#### join 连接

可以使用 `join()` 方法来创建连接

```php
$password = DB::table('password')
            ->join('user', 'user.id', '=', 'password.user_id')
            ->select('password.*', 'user.name', 'user.email')
            ->first();

// select `password`.*, `user`.`name` as `u_name`, `user`.`email` as `u_email` from `password` inner join `user` on `user`.`id` = `password`.`user_id` limit 1
```

`join()` 方法会创建一个内连接，也可以使用 `leftJoin()` 来创建左连接

#### union 连接

使用 `union()` 或者 `unionAll()` 来连接两个查询

```php
$first = DB::table('password')->where('id', 1);
$password = DB::table('password')->union($first)->where('id', 2)->get();

// select * from `password` where `id` = 1) union (select * from `password` where `id` = 2) 

```

#### 插入

可以用 `insert()` 传入一个一维数组或者二维数组来插入数据，也可以使用 `insertGetId()` 来插入数组的同时获得自增的ID

```php
$password = DB::table('password')->insert([
            'user_id' => 1,
            'name' => 'abcds',
            'account' => 'asdf',
            'url' => '',
            'type' => 1,
            'password' => '123123',
            'remark' => 'test'
        ]);
dump($password);
// true

$id = DB::table('password')->insertGetId([
            'user_id' => 1,
            'name' => 'abcds',
            'account' => 'asdf',
            'url' => '',
            'type' => 1,
            'password' => '123123',
            'remark' => 'test'
        ]);
dump($id);
// 32
```

#### 更新

使用 `update()` 方法来更新数据，参数为修改的数据，返回结果为影响的行数

```php
$line = DB::table('password')->where('id', 32)->update(['name' => 'name32']);

// update `password` set `name` = 'name32' where `id` = 32
```

也可以使用 `increment()` 和 `decrement()` 来快速递增和递减列

```php
$line = DB::table('password')->where('id', 32)->increment('type', 2);

// update `password` set `type` = `type` + 2 where `id` = 32
``` 

#### 删除

使用 `delete()` 方法来删除数据，将会删除所有满足查询条件的数据，返回删除的行数

```php
$line = DB::table('password')->where('url', '')->delete();

// delete from `password` where `url` = ''
```

#### json操作

可以使用 arrow 语法来操作json列

```PHP
DB::table('password')->where('attributes->isAdmin', true)->get();

// select * from `password` where `attributes`->'$."isAdmin"' = true
```

> {warning} 只有 Mysql5.7支持该特性
