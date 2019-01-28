### Eloquent删除

Eloquent 中删除和更新操作类似

#### 普通删除

##### 通过获取模型实例来删除

```PHP
$contact = Contact::find(1);
$contact->delete();
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