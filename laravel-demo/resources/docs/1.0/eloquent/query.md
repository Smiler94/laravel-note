# Eloquent查询

在大多数情况下，会使用 Eloquent 模型的静态调用来获取数据

----

- 基本使用
- 获取单个数据

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