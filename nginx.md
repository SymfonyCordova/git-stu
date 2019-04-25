## 什么是Nginx
    nginx是一个开元且高性能,可靠的HTTP中间见,代理服务

    Nginx特性_实现优点
        IO多路复用epoll
        功能模块少 代码模块化
        cpu亲和(affinity)
                是一种把cpu核心和nginx工作进程绑定方式,每个worker进程固在一个cpu上执行,减少切换cpu的cache miss,获得更好的性能。
        sendfile
    
    Nginx快速安装
        Mainline version 开发版
        Stable version 稳定版
        Legacy version 历史版
        
        安装方式nginx官方网址上面有详细的安装

        建议docker安装

    对于centos 用yum源安装的可以使用: 
        命令:rpm -ql nginx
    来查看安装目录

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

    Nginx的目录和配置语法_Nginx编译配置参数
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

## Nginx的目录和配置语法与默认站点启动
    user                设置nginx服务的系统使用用户
    worker_processess   工作进程数 设置和cpu个数一样
    error_log           nginx的错误日志
    pid                 nginx服务启动时候pid
    
    events
        worker_connections  每个进程允许最大连接数 65535
        use                 工作进程数 内和模型 epoll
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
    =============================================
    nginx.conf 文件代码:
        user  nginx;
        worker_processes  1;
        error_log  /var/log/nginx/error.log warn;
        pid        /var/run/nginx.pid;
        events {
            worker_connections  1024;
        }
        http {
            include       /etc/nginx/mime.types;
            default_type  application/octet-stream;

            log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                            '$status $body_bytes_sent "$http_referer" '
                            '"$http_user_agent" "$http_x_forwarded_for"';

            access_log  /var/log/nginx/access.log  main;
            sendfile        on;
            #tcp_nopush     on;
            keepalive_timeout  65;
            #gzip  on;
            include /etc/nginx/conf.d/*.conf;
        }


    default.conf文件代码:
        server {
            listen       80;
            server_name  localhost;

            #charset koi8-r;
            #access_log  /var/log/nginx/host.access.log  main;

            location / {
                root   /usr/share/nginx/html;
                index  index.html index.htm;
            }

            #error_page  404              /404.html;

            # redirect server error pages to the static page /50x.html
            #
            error_page   500 502 503 504  /50x.html;
            location = /50x.html {
                root   /usr/share/nginx/html;
            }

            # proxy the PHP scripts to Apache listening on 127.0.0.1:80
            #
            #location ~ \.php$ {
            #    proxy_pass   http://127.0.0.1;
            #}

            # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
            #
            #location ~ \.php$ {
            #    root           html;
            #    fastcgi_pass   127.0.0.1:9000;
            #    fastcgi_index  index.php;
            #    fastcgi_param  SCRIPT_FILENAME  /scripts$fastcgi_script_name;
            #    include        fastcgi_params;
            #}

            # deny access to .htaccess files, if Apache's document root
            # concurs with nginx's one
            #
            #location ~ /\.ht {
            #    deny  all;
            #}
        }

## HTTP请求
    request - 包括请求行,请求头,请求数据 
    respone - 包含状态行,消息报文,响应正文

    curl -v http://www.baidu.com


## Nginx日志模块 log_format
    日志类型
        包括:error.log access_log
        /var/log/nginx/error.log; 记录到请求的错误状态以及nginx本身的错误状态 会按照不同的级别记录到error.log里面
        /var/log/nginx/access.log; 记录到每次http请求访问的状态
    
    怎么配置日志
        log_format
        Syntax: log_format name [escape=default|json]string ...;
        Default:log_format combined "...";
        Context:http 必须配置在http模块下面

        Nginx变量
            Http请求变量: arg_PARAMETER、http_HEADER、sent_http_HEADER
            内置变量: Nginx内置的 可以查看nginx内置变量 https://nginx.org/en/docs/http/ngx_http_log_module.html
            自定义变量: 自己定义
    
        具体的配置参考:nginx.conf 文件代码
            $remote_addr 客户端的地质
            $remote_user 客户端认证请求nginx的用户名 默认没有开启认证模块 是不会记录的
            $time_local 时间
            $request 请求行
            $status 服务器返回的状态
            $body_bytes_sent 从服务器返回给客户段body的大小
            $http_referer 上以及页面的url地址(用这个可以用来防盗链)
            $http_user_agent 表示的客户端的内容 比如ie chrome curl ...
            $http_x_forwarded_for 请求是每一集携带的信息

        nginx -tc /etc/nginx/nginx.conf 检查nginx配置是否正确
        nginx -s reload -c /etc/nginx/nginx.conf 重载服务不需要关闭nginx服务器

## Nginx模块
    模块介绍
        Nginx官方模块
        第三方模块
    
    可以通过nginx-V 注意这个是大写的V 可以查看到有那些已经安装的模块

    1. --with-http_stub_status_module模块 
        作用: 监听nginx的客户端状态
        语法:
            http_stub_status_module配置
                Syntax: stub_status;
                Default: -- 默认是没有配置的
                Context:server,location 位置在server和location下面进行配置
        例子
            location /mystatus {
                stub_status;
            }
        效果
            Active connections: 2 
            server accepts handled requests
            7 7 18 
            Reading: 0 Writing: 1 Waiting: 1 

    2. --with-http_random_index_module模块 
        作用: 目录中选择一个随机主页
        语法:
            http_random_index_module配置
                Syntax: random_index on|off;
                Default: random_index off; 默认是关闭的
                Context: location 位置在location下面进行配置 
        例子
            location / {
                root   /usr/share/nginx/html;
                random_index on;
                # index  index.html index.htm;
            }
        效果
            每次刷新看到主页是不一样的

    
    3. --with-http_sub_module模块 
        作用: HTTP内容替换 服务器发送给客户端的时候将程序员写好的response的内容进行替换后发送给客户端
        语法:
            http_sub_module配置语法1
                Syntax: sub_filter string replacement;
                Default: --; 默认是关闭的
                Context: http, server, location
            http_sub_module配置语法2 服务器段返回response的内容发现与上一次访问的内容不一样就返回新的,一样就不返回新的内容 主要用于缓存
                Syntax: sub_filter_last_modified on|off;
                Default: sub_filter_last_modified off; 默认是关闭的
                Context: http, server, location
            http_sub_module配置语法3 
                Syntax: sub_filter_once on|off;
                Default: sub_filter_once on; 默认是替换第一个
                Context: http, server, location
        例子
            location / {
                root   /usr/share/nginx/html;
                index  index.html index.htm;
                sub_filter '<p>lei</p>' '<a>LEI</a>';
                sub_filter_once off;
            }
        效果
            就是将页面的 所有的<p>lei</p>替换了<a>LEI</a>

    4. limit_conn_module模块 连接频率限制 (三次握手)
       limit_req_module模块  请求频率限制
        作用: 实现请求限制
            HTTP请求建立在一次TCP连接基础上,一次TCP请求至少产生一次HTTP请求

        语法:
            limit_conn_module配置语法
                Syntax: limit_conn_zone key zone=name:size; 开辟空间保存
                Default: --; 默认是关闭的 
                Context: http
            
                Syntax: limit_conn zone number;
                Default: --; 默认是关闭的
                Context: http, server, location
            
            limit_req_module配置语法
                Syntax: limit_req_zone key zone=name:size rate=rate; 开辟空间保存
                Default: --; 默认是关闭的 
                Context: http
            
                Syntax: limit_req zone=name[burst=number][nodelay];
                Default: --; 默认是关闭的
                Context: http, server, location
        
        压力测试工具 ab -n 40 -c 20 http:www.baidu.com
            -n 总共发起的次数
            -c 同时并发的个数
            tail -f 去监听log文件

        例子
            location / {
                root   /usr/share/nginx/html;
                index  index.html index.htm;
                sub_filter '<p>lei</p>' '<a>LEI</a>';
                sub_filter_once off;
            }
        效果
            就是将页面的 所有的<p>lei</p>替换了<a>LEI</a>

## Nginx的访问控制
    基于IP的访问控制 - http_access_module模块
    基于用户的信任登陆 - http_auth_basic_module模块 2-23
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
            
        B负载均衡服务器
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
    ```
        upstream backend {
            server backend1.example.com weight=5;
            server backend2.example.com:8080;
            server unix:/tmp/backend3;
            
            server backup1.example.com:8080 backup;
            server backup2.example.com:8080 backup;
        }
        
        down            当前的server暂时不参与负载均衡
        backup          预留的备份服务器
        max_fails       允许请求失败的次数
        fail_timeout    经过max_fails失败后,服务暂停的时间
        max_conns       限制最大的接收的连接数
    ```
## Nginx作为负载均衡服务_backup状态演示
    ```
        负载均衡服务器 
            upstream imocc {
                server 116.62.103.228:8001 down;
                server 116.62.103.228:8002 backup;
                server 116.62.103.228:8003 max_fails=1 fail_timeout=10s;
            }
            server {
                listen 80;
                server_name localhost zler.it.com;
                access_log /var/log/nginx/test_proxy.access.log main;
                resolver 8.8.8.8;
                
                location / {
                    proxy_pass http://imocc;
                    include proxy_params;
                }
                
                error_page 500 502 503 504 /50x.html;
                location = /50x.html { 
                    root /usr/share/nginx/html;
                }
            }
    ```
## Nginx作为负载均衡服务_轮询策略与加权轮询
    ```
        调度算法
            轮询              按时间顺序逐一分配到不同的后端服务器(默认)
            加权轮询           weight值越大,分配到的访问几率越高
            ip_hash          每个请求按访问IP的hash结果分配,这样来自同一个IP的 固定访问一个后端服务器
            url_hash         按照访问的URL的hash结果来分配请求,使每个URL定向到同一个后端服务器
            least_conn       最少链接数,那个机器连接数少就分发
            hash关键数值       hash自定义的key
            
        负载均衡服务器 加权轮询
                    upstream imocc {
                        server 116.62.103.228:8001;
                        server 116.62.103.228:8002 weight=5;
                        server 116.62.103.228:8003;
                    }
                    server {
                        listen 80;
                        server_name localhost zler.it.com;
                        access_log /var/log/nginx/test_proxy.access.log main;
                        resolver 8.8.8.8;
                        
                        location / {
                            proxy_pass http://imocc;
                            include proxy_params;
                        }
                        
                        error_page 500 502 503 504 /50x.html;
                        location = /50x.html { 
                            root /usr/share/nginx/html;
                        }
                    }    
    ```
## Nginx作为负载均衡服务_负载均衡策略ip_hash方式
    ```
        upstream imocc {
            ip_hash;
            server 116.62.103.228:8001;
            server 116.62.103.228:8002;
            server 116.62.103.228:8003;
        }
        server {
            listen 80;
            server_name localhost zler.it.com;
            access_log /var/log/nginx/test_proxy.access.log main;
            resolver 8.8.8.8;
                                
            location / {
                proxy_pass http://imocc;
                include proxy_params;
            }
                                
            error_page 500 502 503 504 /50x.html;
            location = /50x.html { 
                root /usr/share/nginx/html;
            }
        } 
    ```
## Nginx作为负载均衡服务_负载均衡策略url_hash策略
    ```
        Syntax: hash key [consistent];
        Default: -
        Context:upstream
        This directive appeared in version 1.7.2
        
        
    ```
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