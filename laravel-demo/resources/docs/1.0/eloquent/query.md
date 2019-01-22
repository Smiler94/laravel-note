# Eloquent查询

在大多数情况下，会使用 Eloquent 模型的静态调用来获取数据

----

- 基本使用
- 获取单个数据
- 获取多个数据
- 分块查询
- 聚合

#### 基本使用

获取所有数据

```PHP
$allContacts = Contact::all();

// select * from contacts;
```

添加查询条件

```PHP
$userContact = Contact::where('user_id', 2)->get();

// select * from contacts where user_id = 2;
```

> {info} 可以发现，Eloquent 模型的静态调用与 DB Facade 一样可以进行链式约束，任何使用 DB Facade 的查询构造器可以进行的操作都可以在 Eloquent 模型中使用，实际上，Eloquent 模型可以进行更多操作

#### 获取单个数据

Eloquent 模型同样可以使用 `find()`、`first()` 或者后面加上 “orFail” 等方法来查询一条数据。

不同的是，DB Facade 返回的是一个 StdClass，而模型查询后返回的模型实例

```PHP
$contact = Contact::find(1);

dump($contact);
// Contact {#316 ▶}
```

> {primary} 使用 `findOrFail()` 或者 `firstOrFail()` 时，如果未查询到数据，会抛出 `Illumate\Database\Eloquent\ModelNotFoundException`，可以根据自己的需求进行捕获并处理

#### 获取多个数据

Eloquent 和 DB Facade 一样可以使用 `get()` 来获取结果

```PHP
$userContact = Contact::where('user_id', 2)->get();
```

不过 Eloquent 有自己独有的方法 `all()`，用于获取整张表的数据，但是不建议使用这个方法，因为 `Contact::all()` 和 `Contact::get()` 是等效的，但有查询条件时，就不能使用 `all()` 了

#### 分块查询

如果需要处理大量的记录时，如果一次性把数据读取到内存中，会遇到内存溢出的问题，Laravel 提供了 `chunk()` 方法，可以把请求分割成小块，进行分批处理

```PHP
Contact::chunk(10, function ($contacts) {
    // $contacts 集合的元素个数最多10个，可以进行批量处理
}); 
```

假设 `contacts` 表中共有25条记录，则上述代码将会执行以下sql，每次只会查询出10条记录

```PHP
select * from `contacts` order by `contacts`.`id` asc limit 10 offset 0
select * from `contacts` order by `contacts`.`id` asc limit 10 offset 10 
select * from `contacts` order by `contacts`.`id` asc limit 10 offset 20
```

#### 聚合

Eloquent 的聚合方法与 DB Facade 一致

- count() 统计记录数
- min(colName) 获取指定列的最小值
- max(colName) 获取指定列的最大值
- sum(colName) 获取指定列的和
- avg(colName) 获取指定列的平均值