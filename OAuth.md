## OAuth协议简介
	OAuth协议要解决的问题
	OAuth协议中的各种角色
	OAuth协议运行流程
	
	目的是:
		用户将微信的(服务提供商的)用户名和密码不交给第三方应用的情况下,
		让第三方应用可以有权限访问用户存在微信(服务提供商)上的资源
	
## OAuth授权模式
	授权码模式(authorization code)
	简化模式(implicit)
	密码授权模式(resource owner password credentials)
	客户端模式(client credentials)
	
```sql
UserConnection
	create table UserConnection(
		userId varchar(255) not null,
		providerId varchar(255) not null,
		providerUserId varchar(255),
		rank int not null,
		displayName varchar(255),
		profileUrl varchar(512),
		imageUrl varchar(512),
		accessToken varchar(512) not null,
		secret varchar(512),
		refreshToken varchar(512),
		expireTime bigint,
		primary key (userId,providerId, providerUserId)
	);
	create unique index UserConnectionRank on UserConnection(userId,providerId,rank);

```

## OAuth App 认证框架
    1.App开发
    2.前后端分离部署架构的Web Server (比如:react+nodejs这种 WebService)
        html
    
    之前的浏览器架构,都是存在session,cookie中的
    而这两种架构如果也是针对cookie进行存储的话,开发是很繁琐的 安全性和客户体验差
    在某种情况下不支持cookie,比如:微信小程序
    
    当不是浏览器程序,而是各种应用程序的时候: 需要令牌(Token)不在是session了
    
    Spring Social 这个是给第三方应用的client开发方便使用的
    Spring Security OAuth 这个是使得我们的自己的主逻辑应用变成服务提供商的开发方便使用的
        服务提供商需要提供
            1.要实现认证服务器 Authorization Server
                实现OAuth4种授权模式->Token的生成和Token的存储 (token Spring Security OAuth已经帮我们实现了)
                自定义的认证(需要自己写)
            2.要实现资源服务器 Resource Server
                如何保护我们的资源
                 SpringSecurity过滤器
                 OAuth2Authentication ProcessingFilter(过滤器和监听器)
                
                资源(rest服务)

## OAuth App实现
    1.实现认证服务器 
        新增一个类的注解
        @EnableAuthorizationServer 
        class ZlerAuthorizationServerConfig{
        }
        
        首先给应用生成client_id和secret
        每个接口的头信息包含应用生成client_id和secret
            Type Basic
            Username zler
            Password zlersecret
         
        用户调过来认证授权的路劲 /oauth/authorize
            需要的参数(参考oauth官网https://tools.ietf.org/html/rfc6749#section-4.1): 
                response_type 必填 必须填'code'
                client_id 必填 (client_id:是每个应用系统都会生成一个client_id,带上这个我就知道是什么应用)
                redirect_uri 回调地址
                scope 必填 all 请求的什么样的权限是通过scope参数带过来的 这个是服务提供商自己定义的(比如一个字符串)
                state 
            
            用户名:请求是哪个用户来授权
            密码:   
        用户拿到了授权码来换取token的路径 /oauth/token
            需要的参数
                grant_type: authorization_code
                client_id : zler
                code：tj88Qa
                redirect_url： http://example.com
                scope: all
        以上是授权码模式(authorization code)授权流程走完了
    
    2.密码授权模式(resource owner password credentials)
        同样的头信息包含
            Type Basic
            Username zler
            Password zlersecret
        
        提供商告诉了第三方应用用户的账号和密码
        第三方应用户拿到了用户的账号和密码直接一步来换取token的路径 /oauth/token
            需要的参数
                grant_type : password
                username: jojo
                password: 123456
                scope：all
        这种授权模式服务提供商和第三方应用都是自己的公司
        
        无论是什么模式用户的token只要不过期,请求n次始终返回的是同一个token
        默认token存储模式是存储在内存中
        
    3.实现资源服务器
        新建一个类
            @EnableResourceServer
            public class MyResourceServerConfig{
            }
        获取用户信息 /user/me
           头信息
                Authorization: bearer + 空格 + accesstoken
                这个参数的数据是/oauth/token接口返回的
    
    这样我们的一个OAuth基本的默认流程就走完了

## JWT (Json Web Token)
    一种令牌的标准
        自包含 就是一般的token就是一个随机生成的字符串,自包含就是token里面包含了信息
        密签:就是对令牌要进行签名的,防止别人篡改,不要把业务敏感的信息放到token中
        可扩展
     
    基于JWT实现SSO
        SSO:单点登陆

## 授权
    前面所有解决的是登陆的到底是谁
    授权:是用户能不能访问url
    
    只区分是否登陆
    区分简单角色