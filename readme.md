### laravel的学习笔记

#### 安装

##### Composer

需要全局安装[composer](https://getcomposer.org),用于管理PHP的依赖关系，类似Node的NPM或python的pip

##### 开发环境
    
- Laravel Valet
    
- Laravel Homested
    
##### 创建laravel项目

- 使用 Laravel 安装工具
    
如果已经全局安装好 Composer ，可以执行以下命令来安装 Laravel 安装工具

`composer global require "laravel/installer=~1.1"`

现在可以使用以下命令来创建一个新的 Laravel 项目

`lavavel new projectName`

当前目录下会创建一个新的名为`projectName` 的子目录，并在其中创建了一个全新的 Laravel 项目