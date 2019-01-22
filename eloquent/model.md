### Eloquent模型

Eloquent是一个 ActiveRecord ORM，是一个数据库抽象层，它提供了一个与多个类型的数据库进行交互的方法。Eloquent主要关注简洁性，依赖于“公约配置”，能以最少的代码建立强大的模型。

#### 新建和定义 Eloquent 模型

可以使用 artisan 命令来新建模型

```PHP
~ php artisan make:model Contact
```

将会生成 `app/Contact.php` 文件

```PHP
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
}
```

> {info} 可以加上 --migration 选项来新建模型的同时自动创建一个迁移
> ```PHP
> ~ php artisan make:model Contact --migration
> ```

##### 表名

表名的默认行为是 Laravel 的 “snake case”，并且它会将类名复数话，所以 UserContact 模型对应的表名 user_contacts，如果想要自定义表名，可以在模型中设置 `$table` 属性

```PHP
protected $table = 'contact';
```

##### 主键

Laravel 默认每一个表都会有一个 integer 类型且自增的主键 id

如果想要修改主键的名字，可以设置 `$primaryKey` 属性

```PHP
protected $primaryKey = 'contact_id';
```

如果不想让主键自增，可以设置 `$incrementing` 属性

```PHP
protected $incrementing = false;
```

##### 时间戳

Laravel 默认每张表都会包含 `created_at` 和 `updated_at` 时间戳列，如果不想要这两个字段，可以设置 `$timestamp` 属性来关闭

```PHP
protected $timestamp = false;
```

同时可以设置 `$dateFormat` 属性来修改时间戳的格式，将按照 PHP 的 date() 函数来解析这个属性

```PHP
protected $dateFormat = 'U';
// 按Unix版本的秒来存储 1548160706

protected $dateFormat = 'Y-m-d H:i:s'
// 默认的格式 2019-01-22 20:30:00
```