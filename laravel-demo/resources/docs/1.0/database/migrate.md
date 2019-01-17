# 数据库迁移

Laravel能更容易地通过代码驱动的迁移来定义数据库结构，每一个新的表、列、索引和键都可以在代码中定义，在任何新的环境中都可以在数秒内实现将裸机数据库完整地和应用程序进行数据同步

----

- 定义迁移
- 创建表
- 创建列
- 建立额外的属性
- 删除表
- 索引

## 定义迁移

迁移是一个单独的文件，它定义了两项内容，分别是在运行迁移 up 和 down 时所需要的修改

> {info}迁移总是按照日期顺序运行的。迁移文件的命名都类似于这种形式：2014_10_12_000000_create_users_table.php 。当一个系统开始迁移时,就会从最早的日期开始抓取每一个迁移，然后执行它的 up() 方法，同样允许回滚最近的一系列迁移，抓取每一个迁移，然后执行 down() 方法，所以，可以把迁移的 up() 方法理解为执行迁移，down() 方法理解为撤销迁移。

## 创建迁移

使用 Artisan 命令可以创建迁移文件，参数是迁移的名称

````php
~ php artisan make:migration carete_users_table
````

还可以传入两个选项

- --create = table_name 创建名为 table_name 的表进行迁移
- --table = \_table_name_ 会将预修改迁移到现有的表中

迁移取决于 Schema facade 及其方法，所有能在迁移中进行的操作都依赖于 Schema 中的方法

## 创建表

使用 create() 方法来创建表，第一个参数是表名，第二个参数是定义列的闭包

````php
Schema::create('tablename', function(Blueprint $table) {
    // 创建列
});
````

## 创建列

使用传递到闭包中的 Blueprint 来创建列

````php
Schema::create('users', functon (Blueprint $table) {
    $table->string('name');
});
````

Blueprint 的方法：

|方法|说明|
|-----|-----|
|integer(colName)|添加一个 INTEGER 类型列，或者其他变体之一|
|tinyInteger(colName)|
|smallInteger(colName)|
|mediumInteger(colName)|
|bigInteger(colName)|
|string(colName, OPTIONAL length)|添加一个 varchar 类型列|
|binary(colName)|添加一个 blob 类型列|
|boolean(colName)|添加一个 boolean 类型列，在 mysql 中是 tinyint(1)|
|char(colName, length)|添加一个 char 类型列|
|datetime(colName)|添加一个 datetime 类型列|
|decimal(colName, precision, scale)|添加一个 decimal 类型列，指定精度和范围|

## 建立额外的属性

创建列之后，还可以通过链式方法来设置一些其他属性，例如 email 字段为null，将其放置在 last_name 字段后就可以这样写

````php
Schema::table('users', function (Blueprint $table) {
    $table->string('email')->nullable()->after('last_name');
});
````

常用的方法:

|方法|说明|
|----|----|
|nullable()|允许 null 值|
|default('default content')|设置默认值|
|unsigned()|标记为无符号型|
|first()|按列顺序把列放置到首列|
|after(colName)|按列顺序把列放在某一列后面|
|unique()|唯一索引|
|primary()|主键|
|index()|添加一个普通索引|

> {info} unique() primary() 和 index() 方法也可以在列创建环境以外使用

## 删除表

使用 drop 方法删除表

````php
Schema::drop('contracts');
````

#### 修改列

如果想要修改列,只需要像创建一个新的列那样调用方法,然后再最后调用 `change()` 方法即可

> {warning} 修改列需要依赖 doctrine/dbal 

将长度为255的 name 字段修改为长度100

````php
Schema::table('users', function (Blueprint $table) {
    $table->string('name', 100)->change();
});
````

使用 `renameColumn()` 方法对字段进行重命名

````php
Schema::table('users', function (Blueprint $table) {
    $table->renameColumn('user_name', 'name');
});
````

使用 `dropColumn()` 删除列

````php
Schema::table('users', function (Blueprint $table) {
    $table->dropColumn('votes');
});
````

## 索引

在创建了列之后，可以为列添加索引、删除索引

##### 添加索引

````php
$table->primary('id'); // 添加主键索引，如果使用了increments()，则默认添加了主键索引
$table->primary(['first_name','last_name']); // 复合键
$table->unique('email'); // 唯一索引
$table->unique('email', 'uniq_users_email'); // 唯一索引，第二个参数为索引名称
$table->index('amount'); // 普通索引
$table->index('amount', 'idx_users_amount'); // 普通索引，第二个参数为索引名称
````

##### 删除索引

````php
$table->dropPrimary('id'); // 删除主键索引
$table->dropUnique('uniq_users_email'); // 删除唯一索引
$table->dropIndex('idx_users_amount'); // 删除普通索引
````

## 运行迁移

可以使用 Artisan 命令来运行定义好的迁移

````php
~ php artisan migrate
````

> {info} Laravel 会追踪每一个正在运行和没有运行的迁移。每一次运行上面的命令，都会检查是否已经运行了所有可用的迁移，如果没有，它就会运行那些还没有运行的迁移

还有一些其他的命令可以使用

- migrate:install 创建数据库表来检测运行和没有运行的迁移，它会在你运行迁移时自动运行
- migrate:reset 回滚运行当前安装下的每一个数据库迁移
- migrate:refresh 回滚运行在当前安装下的每一个数据库迁移，然后运行每一个可用的迁移
- migrate:rollback 回滚上一次运行的迁移，或者通过添加 --step=1 选项来指定要回滚的次数
- migrate:status 显示出每次迁移的列表