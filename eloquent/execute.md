### Eloquent插入和更新

插入和更新是 Eloquent 与 DB Facade 语法不同的地方之一

#### 数据插入

Eloquent 插入主要有两种方法

##### 使用模型实例

实例化一个模型，手动给属性赋值，然后调用模型的 `save()` 方法

```PHP
$contact = new Contact();
$contact->name = 'abc';
$contact->user_id = 3;
$contact->email = 'test@abc.com';
$contact->phone = '1231231';
$contact->save();
```

或者使用一个数组来初始化模型

```PHP
$contact = new Contact([
    'name' => 'abcd',
    'user_id' => 3,
    'email' => 'test@abcd.com',
    'phone' => '1231231123',
]);
$contact->save();
```

##### 使用模型静态调用

向模型的 `create()` 方法传入一个数组来直接新增一条记录

```PHP
$contact = Contact::create([
    'name' => 'abcd',
    'user_id' => 3,
    'email' => 'test@abcd.com',
    'phone' => '1231231123',
]);
```

> 通过 `create()` 方法来插入数据时，要保证传入的数组中的每一个元素都要在模型的 `$fillable` 属性中

#### 数据更新

更新操作和插入类似，也有两种方法可以使用

##### 使用模型实例

先获得一个模型实例，然后改变属性，再使用 `save()` 方法进行保存

```PHP
$contact = Contact::find(1);
$contact->name = 'test contact';
$contact->save();
```

##### 通过调用update()

先构造查询链，再调用 `update()` 方法，传入一个数组来更新

```PHP
Contact::where('id',1)->update([
    'name' => 'test contact'
]);
```