# 事务

Laravel 查询构造器的事务特性表现在：不论在任何时候，如果事务闭包中抛出了异常，那么事务中的所有查询都会回滚。如果事务闭包成功结束，那么所有的查询都会被提交

---- 

```PHP
DB::transaction(function () use ($userId, $name) {
    // 可能失败的查询
    DB::table('user')->where('id', $userId)->update(['name', 'test']);

    DB::table('password')->where('user_id', $userId)->delete();
});
```

也可以手动开启或终止事务，这些操作会同时在查询构造器和 Eloquent 查询中生效

|方法|作用|
|----|----|
|DB::beginTransaction()|开启事务|
|DB::commit()|提交事务|
|DB::rollBack()|回滚查询|