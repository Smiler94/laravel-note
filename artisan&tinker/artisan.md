### Artisan

新版本的 PHP 框架希望通过更多的交互来取代命令行。Laravel 主要提供了3中实现命令行交互的工具：
- Artisan，有一套内置的命令行操作可以自定义进行扩展
- Tinker，为应用提供了 REPL 或者交互的 shell
- 安装器，即 laravel-installer

#### Artisan 入门

前面在学控制器时，使用了一个命令生成一个控制器，这个就是 Artisan 命令的基本语法

`~ php artisan make:controller`

由于 Artisan 命令是可扩展的，所以可以使用以下命令查看一个应用程序所有可用的 Artisan 命令

`~ php artisan list`

#### Artisan 基本命令

- `help` 帮助命令，例如 `~ php artisan help commandName`
- `clear-compiled` 删除 laravel 的编译文件，当遇到问题却不知原因的时候，可以先尝试运行这个命令
- `down` 把应用切换到*维护模式*以解决错误、迁移或者其他运行方式，`up` 可以恢复应用
- `env` 显示当前应用的环境
- `migrate` 迁移数据库
- `optimaze` 通过把重要的 PHP 类缓存到 `bootstrap/cache/compile.php` 来优化应用
- `serve` 部署一个 PHP 服务器到 `localhost:8000` (可以通过 --host 和 -port 来指定主机名和端口号)
- `tinker` 打开 Tinker 到 REPL

##### 选项

Artisan 命令有一些选项，这些选项在任何时刻都可以使用

- `-q` 隐藏所有的输出
- `-v、-vv 和 -vv` 对应三种不同形式的输出，正常、详细和调试
- `--no-interaction` 不会询问任何有关交互的问题，所以使用这个命令不会中断自动化流程
- `--env` 可以定义 Artisan 命令操作的环境，如 local、production 等
- `--version` 显示应用的 laravel 版本

##### 组合命令

其他可以开箱即用的命令可以按照上下文进行分组，暂时列出一些，后面使用到新的继续补充

- `app`
    - `name` 用选定的命名空间替换每一个默认的、顶层的 `App\` 命名空间实例
- `auth`
    - `clear-resets` 刷新所有过期的密码，然后通过数据库中的令牌重置
- `cache`
    - `clear` 清除缓存
    - `table` 如果想使用数据库缓存驱动，可以使用这个命令迁移数据库
- `config`
    - `cache` 缓存所有配置
    - `clear` 清除配置缓存
- `db`
    - `seed` 如果配置了数据库的 seeder，则可以使用这个命令来填充数据库
- `event`
    - `generate` 建立缺失事件和事件监听文件
- `key`
    - `generate` 会在 .env 文件中创建一个随机的应用加密秘钥
- `make`
    - `auth` 为用户登录、注册、仪表盘功能创建视图和对应的路由器
    - `controller` 创建一个控制器
    - `migration` 创建一个数据迁移
- `migrate`
    - `install` 创建秦阿姨及追踪执行的任务
    - `reset` 重置迁移
    - `refresh` 迁移的重置和再次运行
    - `rollback` 进行迁移回滚
    - `status` 查看迁移的状态
- `notifications`
    - `table` 生成一个能产生数据库通知表的迁移
- `queue`
    - `listen` 开始监听一个队列
    - `table` 为数据库支持队列穿件一个迁移
    - `flush` 刷掉所有失败的队列任务
- `route`
    - `list` 查看应用中的所有路由
    - `cache` 缓存路由
    - `clear` 清理路由