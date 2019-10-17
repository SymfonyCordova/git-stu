```
http://www.php.cn/php-weizijiaocheng-406069.html

$pimple['user'] = function ($pimple) { //保存User这个对象状态 闭包特性 php的闭包等同于匿名函数
	return new User($pimple['access_token']);
};

服务提供者
	是连接容器与具体功能实现类的桥梁
	服务提供者需要实现接口ServiceProviderInterface


symfony的依赖注入
	
```