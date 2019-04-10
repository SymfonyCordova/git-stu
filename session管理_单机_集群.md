```
session管理
  session超时处理
    设置session的过期时间
  session并发控制
	当前用用户在一处登陆后
	每次登陆时将当前session覆盖掉
  集群session管理
    需要将session放到一台机器上redis

  PC端
    手机短信验证码登陆,第三方登陆,都是存在session里面的
  
  App需要另做
```