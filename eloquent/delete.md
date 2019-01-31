### Eloquent删除

Eloquent 中删除和更新操作类似

#### 普通删除

##### 通过获取模型实例来删除

```PHP
$contact = Contact::find(1);
$contact->delete();

// select * from `contacts` where `contacts`.`id` = 1
// delete from `contacts` where `id` = 1
```

##### 通过destory()方法

将一个或多个ID传入destory()方法

```PHP
Contact::destory(1);
//
Contact::destory([1,2,3])
```

##### 批量删除

先构造查询器，再调用delete()方法

```PHP
Contact::where('id', '>', 2)->delete();
```

#### 软删除

软删除会记录删除的行，但是不会真的从数据库中删除掉对应的记录。同时也允许用户恢复部分或全部数据。

Eloquent的软删除需要在表中添加delete_at列，只要在Eloquent模型中开启了软删除，那么进行任何查询都会忽略被删除的数据，除非希望把它们包含进来

##### 开启软删除

开启软删除需要做三件事情

- 在迁移中添加delete_at列

在迁移中有可以使用SoftDeletes()方法给迁移添加delete_at列

```PHP
Schema::table('contacts', function (Blueprint $table) {
    $table->SoftDeletes();
});
```

- 在模型中导入SoftDeletes特征

在需要使用软删除的模型中引入SoftDeletes这个trait

```PHP
// Contact.php
<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;
    // 
}
```

- 最后把delete_at列添加到$dates属性中

delete_at字段需要被标记为日期

```PHP
protected $dates = ['delete_at'];
```

##### 基于软删除的查询

开启了软删除之后，正常的查询将会自动过滤已经被删除的数据，且删除操作不会真的删除记录，而是在 delete_at 字段上记录被删除的时间

```PHP
$contact = Contact::find(2);
// select * from `contacts` where `contacts`.`id` = 2 and `contacts`.`deleted_at` is null limit 1
$contact = $contact->delete();
// update `contacts` set `deleted_at` = '2019-01-29 11:07:23', `updated_at` = '2019-01-29 11:07:23' where `id` = 2
```

可以通过 `withTrashed()` 方法来查询被软删除的数据

```PHP
$contact = Contact::withTrashed()->find(2);
if ($contact->trashed()) {
    // 操作
}
```

也可以通过 `onlyTrashed()` 方法只获取软删除的数据

##### 从软删除中恢复实体

如果想恢复已经被软删除的条目，则可以在实例或查询中执行 `restore()` 方法

```PHP
$contact->restore();
// 或者
Contact::onlyTrashed()->where('id', 2)->restore();
// update `contacts` set `deleted_at` = null, `updated_at` = '2019-01-31 12:05:59' where `contacts`.`deleted_at` is not null and `id` = 2
```

##### 强制删除软删除的实体

可以在实体或查询中调用 `forceDelete()` 方法来删除一个软删除的实体

```PHP
$contact = Contact::onlyTrashed()->find(2);
$contact->foreDelete();

// select * from `contacts` where `contacts`.`id` = 2 limit 1
// delete from `contacts` where `id` = 2
```