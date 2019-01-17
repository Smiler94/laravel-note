# 数据库填充

填充主要用于在数据库迁移后，往数据库里写入一些测试数据，来进行应用测试。

------

- 填充的方法
- 创建填充器
- 模型工厂

## 填充的方法

Laravel 使用 `database/seeds` 目录下的 DatabaseSeeder 类来进行数据填充，该类有一个 run() 方法，在运行填充时调用。

运行填充有两种方法：

- 和迁移一起运行 

```php
~ php artisan migrate --seed
~ php artisan migrate:refresh --seed
```

- 单独运行

```php
~ php artisan db:seed  // 运行所有 DatabaseSeeder 的 run() 方法
~ php artisan db:seed --class=VotesTableSeeder 运行指定类的 run() 方法
```

## 创建填充器

通过 Artisan 命令来创建一个填充器

```php
~ php artisan make:seeder PasswordsTableSeeder
```

需要先把它加入到 DatabaseSeeder 类中，在运行填充时才能正常执行

```php
// database/seeds/DatabaseSeeder.php

public function run()
{
    $this->call(PasswordTableSeeder::class);
}
```
 
在 PasswordTableSeeder 的 run() 方法中就可以编写填充的逻辑，比如手动新增一条数据
 
```php
// database/seeds/PasswordTableSeeder.php
 
public function run()
{
    DB::table('password')->insert([
        'name' => 'test',
        'account' => 'test',
        'url' => 'test',
        'type' => 1,
        'password' => 'test',
        'remark' => 'test'
    ]);
}
```

## 模型工厂

为了在数据库中生成测试数据，模型工厂定义了一个或多个模式。模型工厂一般是以一个 Eloquent 类命名的。

##### 创建一个模型工厂

模型工厂在 `database/factories/ModelFactory.php` 中定义，每个工厂包含名称和指明如何在定义类中创建一个新实例的定义。

```php
$factory->define(Password::class, function (Faker\Generator $faker) {
    return [
        'name' => 'test',
        'account' => 'test',
        'url' => 'test',
        'type' => 1,
        'password' => 'test',
        'remark' => 'test'
    ];
});
```

使用闭包中传入 Faker 实例轻松地创建结构化的假数据。

```php
// database/seeds/PasswordTableSeeder.php

$factory->define(App\Password::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'account' => $faker->text(),
        'url' => $faker->url(),
        'type' => 1,
        'password' => 'test',
        'remark' => $faker->text()
    ];
});

```

现在可以通过 `factory()` 助手函数在填充和测试里创建一个 Password 实例

```php
// 创建一个
$password = factory(App\Password::class)->create();

// 创建多个，将会返回实例的集合，可以当做一个数组
factory(App\Password::class, 20)->create();
```

##### 使用模型工厂

模型工厂的使用主要包含两个方面

- 测试

- 数据填充

使用 `factory()` 助手函数后，会返回一个工厂，然后就可以运行工厂的 `make()` 或者 `create()` 了

> {primary} 这两个方法都会通过 modelFacotry.php 里的定义，为当前类生成一个实例。不同之处在于 `make()` 创建了实例但不会把它保存到数据库中，而 `create()` 会马上保存实例。


