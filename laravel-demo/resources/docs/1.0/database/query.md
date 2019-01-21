# 查询构造器

Laravel的数据库核心功能是查询构造器，也就是与数据库交互的流畅界面

-----

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
