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

#### 批量赋值 

在前面的很多例子中往 Eloquent 类的方法中传入数组，但是前提是传入的字段必须是“可填充”的，否则将不能更新

这样做的目的是防止用户输入恶意数据，比如在一些不应该被更新的字段上填入新值

并且我们在控制器中一般会接收用户输入的所有数据，所以需要在模型层面加以控制

```PHP
// ContactController.php
public function update(Contact $contact, Reuqest $request)
{
    $contact->update($request->all());
}
```

`Request` 实例的 `all()` 方法会获取所有的 URL 参数以及表单输入，所以可以轻松地在里面添加一些内容，比如id，实际上我们不希望id会被更新

Eloquent 模型定义了白名单 `fillable` 以及黑名单 `guarded`，这个决定改了数据能否通过批量赋值来更新

```PHP
class Contact
{
    // 可填充字段，即白名单
    protected $fillable = ['name', 'email'];

    // 防护字段，即黑名单
    protected $guarded = ['id', 'created_at', 'updated_at', 'user_id'];
}
```

#### firstOrCreate() 和 firstOrNew()

这两个方法的作用类似，都是用于根据属性返回一个实例，如果实例不存在，则新建一个

```PHP
$contact = Contact::firstOrNew(['email' => 'linzhen@shein.com']);
```

区别在于 `firstOrCreate()` 新建一个实例兵持久化到数据库，而 `firstOrNew()` 新建一个实例但不会保存到数据库

第二个参数可以传入一个数组，可以作为新建实例时的数据

```PHP
$contact = Contact::firstOrCreate(['email' => 'linzhen@shein.com'], [
    'user_id'=>1,
    'name'=>'linzhen',
    'phone' => '1231231'
]);

// select * from `contacts` where (`email` = 'linzhen@shein.com') limit 1 
// insert into `contacts` (`email`, `user_id`, `name`, `phone`, `updated_at`, `created_at`) values ('linzhen@shein.com', 1, 'linzhen', '1231231', '2019-01-26 06:19:05', '2019-01-26 06:19:05');
```