# 第一章 课程前言

## 课程介绍
## 学习环境准备

# 第二章 基础篇

## 什么是Nginx
    ```
        高性能 web服务器 中间件 代理服务器
    ```
## 常见的中间件服务
## Nginx特性_实现优点
    ```
        IO多路复用epoll
        功能模块少 代码模块化
        cpu亲和(affinity)
            是一种把cpu核心和nginx工作进程绑定方式,每个worker进程固在一个cpu上执行,减少切换cpu的cache miss,获得更好的性能。
        sendfile
    ```
## Nginx快速安装
```
    Mainline version 开发版
    Stable version 稳定版
    Legacy version 历史版
    
    安装方式nginx官方网址上面有详细的安装
```
## Nginx的目录和配置语法_Nginx安装目录
```
    对于centos 用yum源安装的可以使用: 
        命令:rpm -ql nginx
    来查看安装目录
```
|路径 | 类型  | 作用 |
| ------------ | ------------ | ------------ |
| /etc/logrotate.d/nginx | 配置文件 | nginx日志轮转,用于logrotate服务的日志切割 |
| /etc/nginx <br> /etc/nginx/nginx.conf <br> /etc/nginx/conf.d <br> /etc/nginx/conf.d/default.conf | 目录,配置文件 | nginx主配置文件 |
| /etc/nginx/fastcgi_params <br> /etc/nginx/uwsgi_params <br> /etc/nginx/scgi_params | 配置文件 | cgi配置相关,fastcgi配置 |
| /etc/nginx/koi-utf <br> /etc/nginx/koi-win <br> /etc/nginx/win-utf | 配置文件 | 编码转换映射转化文件 |
| /etc/nginx/mime.types | 配置文件 | 设置http协议的Content-Type与扩展名对应关系 |
| /usr/lib/systemd/system/nginx-debug.service <br> /usr/lib/systemd/system/nginx.servoce <br> /etc/sysconfig/nginx <br> /etc/sysconfig/nginx-debug | 配置文件 | 用于配置出系统守护进程管理器管理方式 |
| /usr/lib64/nginx/modules <br> /etc/nginx/modules | 目录 | Nginx模块目录 |
| /usr/sbin/nginx <br> /usr/sbin/nginx-debug | 命令 | Nginx服务器的启动管理的终端命令 |
| /usr/share/doc/nginx-1.12.2 <br> /usr/share/doc/nginx-1.12.2/COPYRIGHT <br> /usr/share/man/man8/nginx.8.gz | 文件,目录 | Nginx手册和帮助文件 |
| /var/cache/nginx | 目录 | Nginx的缓存目录 |
| /var/log/nginx | 目录 | Nginx的日志目录 |

## Nginx的目录和配置语法_Nginx编译配置参数
```
    nginx -V
    nginx version: nginx/1.12.2
    built by gcc 4.8.5 20150623 (Red Hat 4.8.5-16) (GCC) 
    built with OpenSSL 1.0.2k-fips  26 Jan 2017
    TLS SNI support enabled
    configure arguments: 
        --prefix=/usr/share/nginx 
        --sbin-path=/usr/sbin/nginx 
        --modules-path=/usr/lib64/nginx/modules 
        --conf-path=/etc/nginx/nginx.conf 
        --error-log-path=/var/log/nginx/error.log 
        --http-log-path=/var/log/nginx/access.log 
        --http-client-body-temp-path=/var/lib/nginx/tmp/client_body 
        --http-proxy-temp-path=/var/lib/nginx/tmp/proxy #缓冲区的临时文件
        --http-fastcgi-temp-path=/var/lib/nginx/tmp/fastcgi 
        --http-uwsgi-temp-path=/var/lib/nginx/tmp/uwsgi 
        --http-scgi-temp-path=/var/lib/nginx/tmp/scgi 
        --pid-path=/run/nginx.pid 
        --lock-path=/run/lock/subsys/nginx 
        --user=nginx 
        --group=nginx 
        --with-file-aio --with-ipv6 
        --with-http_auth_request_module 
        --with-http_ssl_module 
        --with-http_v2_module 
        --with-http_realip_module 
        --with-http_addition_module 
        --with-http_xslt_module=dynamic 
        --with-http_image_filter_module=dynamic 
        --with-http_geoip_module=dynamic 
        --with-http_sub_module 
        --with-http_dav_module 
        --with-http_flv_module 
        --with-http_mp4_module 
        --with-http_gunzip_module 
        --with-http_gzip_static_module 
        --with-http_random_index_module 
        --with-http_secure_link_module 
        --with-http_degradation_module 
        --with-http_slice_module 
        --with-http_stub_status_module 
        --with-http_perl_module=dynamic 
        --with-mail=dynamic 
        --with-mail_ssl_module 
        --with-pcre 
        --with-pcre-jit 
        --with-stream=dynamic 
        --with-stream_ssl_module 
        --with-google_perftools_module 
        --with-debug --with-cc-opt='-O2 -g -pipe -Wall -Wp,-D_FORTIFY_SOURCE=2 -fexceptions -fstack-protector-strong --param=ssp-buffer-size=4 -grecord-gcc-switches -specs=/usr/lib/rpm/redhat/redhat-hardened-cc1 -m64 -mtune=generic' --with-ld-opt='-Wl,-z,relro -specs=/usr/lib/rpm/redhat/redhat-hardened-ld -Wl,-E'

```

## Nginx的目录和配置语法_默认配置语法
```
    user                设置nginx服务的系统使用用户
    worker_processess   工作进程数
    error_log           nginx的错误日志
    pid                 nginx服务启动时候pid
    
    events
        worker_connections  每个进程允许最大连接数
        use                 工作进程数
        
    http{               每个server就是一个站点
        server{
            listen 80;     
            server_name localhost;
            
            location / { 默认访问路径的位置
                root /usr/share/nginx/html
                index index.html index.htm
            }
            
            error_page 500 502 503 504 /59x.html
            location = /50x.html{
                root /usr/share/nginx/html
            }
        }
    
        server{
            ......
        }
    }   
```
## Nginx的目录和配置语法_默认配置与默认站点启动
## HTTP请求
## Nginx日志_log_format
```
    日志类型
        包括:error.log access_log
        /var/log/nginx/error.log;
        /var/log/nginx/access.log;
    
    
    log_format
    Syntax: log_format name [escape=default|json]string ...;
    Default:log_format combined "...";
    Context:http
    
    Nginx变量
        Http请求变量: arg_PARAMETER、http_HEADER、sent_http_HEADER
        内置变量: Nginx内置的
        自定义变量: 自己定义
    
    
    nginx -tc /etc/nginx/nginx.conf 检查nginx配置是否正确
    nginx -s reload -c /etc/nginx/nginx.conf 重载服务不需要关闭nginx服务器
```
## Nginx模块讲解_模块介绍
```
    Nginx官方模块
    第三方模块
```
## Nginx模块讲解_sub_status
```
    Nginx的客户端状态
    http_stub_status_module配置
```
## Nginx模块讲解_random_index
```
    目录中选择一个随机主页
    
```
## Nginx模块讲解_sub_module
```
    HTTP内容替换
    
```
## Nginx模块讲解_sub_module配置演示
## Nginx的连接请求限制_配置语法与原理
```
   HTTP请求建立在一次TCP连接基础上
   一次TCP请求至少产生一次HTTP请求
   
   连接频率限制 limit_conn_module
   请求频率限制 limit_req_module
```
## Nginx的访问控制_介绍实现访问控制的基本方式
## Nginx的访问控制—access_module配置语法介绍
## Nginx的访问控制—access_module配置
## Nginx的访问控制—access_module局限性
## Nginx的访问控制—auth_basic_module配置
## Nginx的访问控制—auth_basic_module局限性

# 第三章 场景实践篇

## 场景实践篇内容介绍
    ```
        静态资源WEB服务
        代理服务
        负载均衡调度器SLB
        动态缓存
    ```
## Nginx作为静态资源web服务_静态资源类型
## Nginx作为静态资源web服务_CDN场景
## Nginx作为静态资源web服务_配置语法
    ```
        配置语法-文件读取
            Syntax: sendfile on | off;
            Default: sendfile off;
            Context: http,server,location, if in location
        
        引读: --with-file-aio异步文件读取
        
        配置语法-tcp_nopush
            Syntax: tcp_nopush on | off;
            Default: tcp_nopush off;
            Context: http, server, location
        作用: sendfile开启的情况下,提高网络包的传输效率
        
        配置语法-tcp_nodelay
            Syntax: tcp_nodelay on | off
            Defaul: tcp_nodelay on;
            Context:http,server,location
        作用: keepalive连接下,提高网络包的传输实时性
        
        配置语法-压缩
            Syntax: gzip on | off
            Default: gzip off;
            Context: http,server,location,if in location
        作用: 压缩传输
        
        压缩比
            Syntax: gzip_comp_level level;
            Default: gzip_comp_level 1;
            Context: http, server, location
        
        压缩版本
            Syntax: gzip_http_version 1.0|1.1
            Default: gzip_http_version 1.1
            Context:http, server, location
        
        扩展Nginx压缩模块
            http_gzip_static_module - 预读gzip功能
            http_gunzip_module - 应用支持gunzip的压缩方式
         
    ```
## Nginx作为静态资源web服务_场景演示
    ```
        server {
            listen 8081;
            server_name localhost;
            sendfile on;
            access_log  /var/log/nginx/access.log  main;
            
            location ~ .*\.(jpg|gif|png)$ {
                gzip on;
                gzip_http_version 1.1;
                gzip_comp_level 2;
                gzip_types text/plain application/javascript application/x-javascript text/css application/xml text/javascript application/x-httpd-php image/jpeg image/gif image/png;
                root /opt/app/code/images;
            }
        
            location ~ .*\.(txt|xml)$ {
                gzip on;
                gzip_http_version 1.1;
                gzip_comp_level 1;
                gzip_types text/plain application/javascript application/x-javascript text/css application/xml text/javascript application/x-httpd-php image/jpeg image/gif image/png;
                root /opt/app/code/doc;
            }
        
            location ~ ^/download {
                gzip_static on;
                tcp_nopush on;
                root /opt/app/code;
            }
        }

    ```
## Nginx作为静态资源web服务_浏览器缓存原理
## Nginx作为静态资源web服务_浏览器缓存场景演示
    ```
        配置语法-expires
        添加Cache-Control、Expires头
        Syntax: expires [modified] time;
                expires epoch | max | off;
        Default: expires off
        Context: http, server, location, if in location
        
         location ~ .*\.(htm|html)$ {
        	expires 24h;
            root /opt/app/code;
         }
    ```
## Nginx作为静态资源web服务_跨站访问
    ```
        Syntax: add_header name value [always];
        Default: -
        Context: http, server, location, if in location
        
        Access-Control-Allow-Origin
    ```
## Nginx作为静态资源web服务_跨域访问场景配置
    ```
        location ~ .*\.(htm|html)$ {
            add_header Access-Control-Allow-Origin *;
            add_header Access-Control-Allow-Methods GET,POST,PUT,DELETE,OPTIONS;
            root /opt/app/code;
        }

    ```
## Nginx作为静态资源web服务_防盗链
    ```
        基于http_refer防盗链配置模块
        Syntax: valid_referers none | blocked | server_names | string ...;
        Default: -
        Context: server,location
    ```
## Nginx作为代理服务_代理服务
    ```
        可以用作HTTP,ICMP\POP\IMAP,HTTPS,RTMP代理
        
        HTTP代理
            正向代理
            反向代理
            正向代理和反向代理的区别
                区别在于代理的对象不一样
                正向代理代理的对象是客户端
                反向代理代理的对象是服务端
            
    ```
## Nginx作为代理服务_配置语法及反向代理场景
    ```
       配置语法
         Syntax: proxy_pass URL
         Default: -
         Context: location, if in location, limit_except
         
         http://location:8000/uri/
         https://192.168.1.1:8000/uri/
         http://unix:/tmp/backend.socket:/uri/;
    ```
## Nginx作为代理服务_正向代理配置场景
    ```
        location / {
            if($http_x_forwarded_for !~* "^116\.62\.103\.228") { #$http_x_forwarded_for获取到所有客户端的ip,包括中间件的ip
                return 403;
            }
            root /opt/app/code;
            index index.html index.htm;
        }
        只允许特定的ip访问
        
        在228这台机器配置正向代理
        resolver 8.8.8.8; #DNS解析 谷歌的DNS解析
        location / {
            proxy_pass http://$http_host$request_uri;
        }
    ```
## Nginx作为代理服务_代理配置语法补充
    ```
        其他配置语法 - 缓冲区
            Syntax: proxy_buffering on | off;
            Default: proxy_buffering on;
            Context: http,server,location
            
            扩展: proxy_buffer_size、proxy_buffers、proxy_busy_buffers_size
            
        其他配置语法 - 跳转重定向
            Syntax: proxy_redirect default;
            proxy_redirect off; proxy_redirect redirect replacement;
            Default: proxy_redirect default;
            Context: http,server,location
         
        其他配置语法 - 头信息
            Syntax: proxy_set_header field value;
            Default: proxy_set_header Host $proxy_host;
                    proxy_set_hedaer Connection close;
            Context:http,server,location
        
            扩展:proxy_hide_header, proxy_set_body
            
        其他配置语法 - 超时
            Syntax: proxy_connect_timeout time;
            Default: proxy_connect_tomeout 60s;
            Context: http,server,location
            
            扩展: proxy_read_timeout, proxy_send_timeout
    ```
    
## Nginx作为代理服务_代理补充配置和规范
    ```
        location / {
            proxy_pass http://127.0.0.1:8080;
            proxy_redirect default;
            
            proxy_set_header Host $http_host;
            proxy_set_header X-Real-IP $remote_addr;
            
            proxy_connect_timeout 30;
            proxy_send_timeout 60;
            proxy_read_timeout 60;
            
            proxy_buffer_size 32k;
            proxy_bufferinng on;
            proxy_buffers 4 128k;
            proxy_busy_buffers_size 256k;
            proxy_max_temp_file_size 256k;
        }
        
        也可以将这些个参数存到proxy_params文件中 然后include这个配置文件proxy_params
        location / {
            proxy_pass http://127.0.0.1:8000;
            include proxy_params;
        }
    ```
## Nginx作为负载均衡服务_负载均衡与Nginx
    ```
        按地域分：   GSLB
                    SLB
        
        四层负载均衡和七层负载均衡
            nginx是典型的七层负载均衡SLB
    ```
## Nginx作为负载均衡服务_配置语法
    ```
       通过代理转发到一个upstream服务组
       Syntax: upstream name { ... } 
       Default: -
       Context: http
    ```
## Nginx作为负载均衡服务_配置场景
    ```
        A台服务器
            多个server配置文件分别对应3个不同的端口
            server1 server2 server3
        server1:
            server{
                listen 8001;
                server_name localhost;
                access_log /var/log/nginx/log/sever1.access.log main;
                location / {
                    root /opt/app/code1;
                    index index.html index.htm;
                }
                
                error_page 500 502 503 504 404 /50x.html;
                location = /50x.html{
                    root /usr/share/nginx/html
                }
            }
            
        server2:
            server{
                listen 8002;
                server_name localhost;
                access_log /var/log/nginx/log/sever2.access.log main;
                location / {
                    root /opt/app/code2;
                    index index.html index.htm;
                }
                
                error_page 500 502 503 504 404 /50x.html;
                location = /50x.html{
                    root /usr/share/nginx/html
                }
            }
            
        server3:
            server{
                listen 8003;
                server_name localhost;
                access_log /var/log/nginx/log/sever3.access.log main;
                location / {
                    root /opt/app/code3;
                    index index.html index.htm;
                }
                
                error_page 500 502 503 504 404 /50x.html;
                location = /50x.html{
                    root /usr/share/nginx/html
                }
            } 
            
        负载均衡服务器
            upstream imocc { 
                server 116.62.103.8001;
                server 116.62.103.8002;
                server 116.62.103.8003;
            }
            server {
                listen 80;
                server_name localhost zler.imocc.com;
                
                access_log /var/log/nginx/test_proxy.access.log main;
                
                location / {
                    proxy_pass http://imocc; # 转发到imocc
                    include proxy_params;
                }
                
                
                error_page 500 502 503 504 404 /50x.html;
                location = /50x.html{
                    root /usr/share/nginx/html
                }              
                
            }
    ```
## Nginx作为负载均衡服务_server参数讲解
## Nginx作为负载均衡服务_backup状态演示
## Nginx作为负载均衡服务_轮询策略与加权轮询
## Nginx作为负载均衡服务_负载均衡策略ip_hash方式
## Nginx作为负载均衡服务_负载均衡策略url_hash策略
## Nginx作为缓存服务_Nginx作为缓存服务
## Nginx作为缓存服务_缓存服务配置语法
## Nginx作为缓存服务_场景配置演示
## Nginx作为缓存服务_场景配置补充说明
## Nginx作为缓存服务_分片请求

# 第四章 深度学习篇

## Nginx动静分离_动静分离场景演示
## Rewrite规则_rewrite规则作用
## Rewrite规则_rewrite配置语法
## Rewrite规则_rewrite正则表达式
## Rewrite规则_rewrite规则中的flag
## Rewrite规则_redirect和permanent区别
## Rewrite规则_rewrite规则场景
## Rewrite规则_rewrite规则书写
## Nginx进阶高级模块_secure_link模块作用原理
## Nginx进阶高级模块_secure_link模块实现请求资源验证
## Nginx进阶高级模块_Geoip读取地域信息模块介绍
## Nginx进阶高级模块_Geoip读取地域信息场景展示
## 基于Nginx的HTTPS服务_HTTPS原理和作用
## 基于Nginx的HTTPS服务_证书签名生成CA证书
## 基于Nginx的HTTPS服务_证书签名生成和Nginx的HTTPS服务场景演示
## 基于Nginx的HTTPS服务_实战场景配置苹果要求的openssl后台HTTPS服务
## 基于Nginx的HTTPS服务_HTTPS服务优化
## Nginx与Lua的开发_Nginx与Lua特性与优势
## Nginx与Lua的开发_Lua基础开发语法
## Nginx与Lua的开发_Nginx与Lua的开发环境
## Nginx与Lua的开发_Nginx调用Lua的指令及Nginx的Luaapi接口
## Nginx与Lua的开发_实战场景灰度发布
## Nginx与Lua的开发_实战场景灰度发布场景演示

# 第五章 Nginx架构篇

## Nginx常见问题_架构篇介绍
## Nginx常见问题__多个server_name中虚拟主机读取的优先级
## Nginx常见问题_多个location匹配的优先级
## Nginx常见问题_try_files使用
## Nginx常见问题_alias和root的使用区别
## Nginx常见问题_如何获取用户真实的ip信息
## Nginx常见问题_Nginx中常见错误码
## Nginx的性能优化_内容介绍及性能优化考虑
## Nginx的性能优化_ab压测工具
## Nginx的性能优化_系统与Nginx性能优化
## Nginx的性能优化_文件句柄设置
## Nginx的性能优化_CPU亲和配置
## Nginx的性能优化_Nginx通用配置优化
## Nginx安全_基于Nginx的安全章节内容介绍
## Nginx安全_恶意行为控制手段
## Nginx安全_攻击手段之暴力破解
## Nginx安全_文件上传漏洞
## Nginx安全_SQL注入
## Nginx安全_SQL注入场景说明
## Nginx安全_场景准备mariadb和lnmp环境
## Nginx安全_模拟SQL注入场景
## Nginx安全_Nginx+LUA防火墙功能
## Nginx安全_Nginx+LUA防火墙防sql注入场景演示
## Nginx安全_复杂的访问攻击中CC攻击方式
## Nginx安全_Nginx版本更新和本身漏洞
## Nginx架构总结_静态资源服务的功能设计
## Nginx架构总结_Nginx作为代理服务的需求
## Nginx架构总结_需求设计评估