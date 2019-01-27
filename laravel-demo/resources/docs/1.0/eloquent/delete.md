### Eloquent删除

Eloquent 中删除和更新操作类似

#### 普通删除

```PHP
$contact = Contact::find(1);
$contact->delete();
```