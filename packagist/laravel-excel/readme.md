### laravel-excel

- **Easily export collections to Excel** 能够处理 Laravel 的 collections，可以直接导出成 Excel 或者 CSV 文件
- **Supercharged exports** 使用自动分块查询导出以提高性能，对于大数据量的导出，可以在后台使用队列进行处理
- **Supercharged imports** 导入的工作表可自动转换成 Eloquent 模型，支持批量写入数据库。较大的文件可以分割成小块丢到队列中去处理

#### 安装

````
~ composer reuqire maatwebsite/excel
````

#### 简单的导出

先创建一个模型 Export 类，根目录在 `App/Exports`，可以使用 Artisan 创建

````
~ php artisan make:export UsersExport --model = User
````

生成的文件如下

````php
// App/Exports/UsersExport.php
namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }
}
````

然后就可以使用以下代码进行导出操作

````php
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

Excel::download(new UsersExport, 'users.xlsx');
````
