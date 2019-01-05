## laravel的学习笔记

### 安装

#### Composer

需要全局安装[composer](https://getcomposer.org),用于管理PHP的依赖关系，类似Node的NPM或python的pip

#### 开发环境
    
- Laravel Valet
    
- Laravel Homested
    
    
#### 创建laravel项目

- 使用 Laravel 安装工具
    
如果已经全局安装好 Composer ，可以执行以下命令来安装 Laravel 安装工具

`~ composer global require "laravel/installer=~1.1"`

现在可以使用以下命令来创建一个新的 Laravel 项目

`~ lavavel new projectName`

当前目录下会创建一个新的名为`projectName` 的子目录，并在其中创建了一个全新的 Laravel 项目

- 通过 composer 的 create-project

Composer 提供了一个 create-project 的命令，用于创建具有特定结构的新项目

`~ composer create-project laravel/laravel project-name --prefer-dist "5.5.*"`

执行效果和 Laravel 安装工具一致

### Laravel 目录结构

创建一个 demo，目录结构如下

````
- app/             应用程序大部分文件存放的地方，比如模型、控制器、路由定义、命令，以及 PHP 域名代码等
- bootstrap/       包含了 Laravel 框架每次运行时使用的文件
- config/          用于放置所有的配置文件
- database/        用于放置数据库迁移和数据库种子文件
- public/          当做站点运行时服务器指向的目录，该目录包含 index.php 入口文件，也放置一些公共文件，如图片、样式表、脚本或下载的文件等
- resources/       用于放置所有非 PHP 的其他脚本文件，比如视图文件、语言文件、Sass/Lass，以及javaScript等
- routes/          用于放置所有路由定义文件，包括 HTTP 路由、控制台路由和 Artisan 命令等 
- storage/         用于放置缓存、日志和系统编译文件
- tests/           用于放置单元测试用例和集成测试文件
- vendor/          用于放置 Composer 安装的依赖关系文件，是一个 git 忽略文件
- .env             指定环境变量，不同环境一些变量有差异在这里进行配置，是一个 git 忽略文件
- .env.example     .env文件的模板
- .gitattributes   git 配置文件
- .gitignore       git 配置文件
- artisan          从命令行运行 Artisan 命令的入口文件
- composer.json    定义了项目的基本信息和依赖关系
- composer.lock    composer 配置文件，不可编辑
- package.json     npm 的配置文件，处理前端依赖
- phpunit.xml      PHPUnit 的配置文件
- readme.md        介绍项目的信息
- server.php       备份服务器文件，尝试在功能较差的服务器中仍然对 Laravel 应用程序进行预览
- webpack.mix.js   Glup 的配置文件
````

### 启动和运行

- 使用自带的服务器

在项目根目录下使用以下命令来使用 php 自带服务器运行 Laravel 应用

`~ php artisan serve`

将会出现以下提示

`Laravel development server started: <http://127.0.0.1:8000>`

这时可以通过访问 `127.0.0.1:8000` 来访问应用

### 路由和控制器

[路由](./route&controller/route.md)

[控制器](./route&controller/controller.md)

[收集和处理用户请求](./urequest/urequst.md)

### Artisan 和 Tinker

[Artisan](./artisan&tinker/artisan.md)
[tinker](./aritsan&tinker/tinker.md)

### 数据库和 Eloquent

[配置](./database/配置.md)
[迁移](./database/迁移.md)
[填充](./database/填充.md)