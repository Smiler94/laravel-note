### Artisan

新版本的 PHP 框架希望通过更多的交互来取代命令行。Laravel 主要提供了3中实现命令行交互的工具：
- Artisan，有一套内置的命令行操作可以自定义进行扩展
- Tinker，为应用提供了 REPL 或者交互的 shell
- 安装器，即 laravel-installer

#### Artisan 入门

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