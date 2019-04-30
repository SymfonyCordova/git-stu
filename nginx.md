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
            $http_referer 上一及页面的url地址(用这个可以用来防盗链)
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
            limit_conn_zone $binary_remote_addr zone=conn_zone:1m;
            limit_req_zone $binary_remote_addr zone=req_zone:1m rate=1r/s;
            server {
                location / {
                    root   /usr/share/nginx/html;
                    index  index.html index.htm;
                    limit_conn conn_zone 1;
                    #limit_req zone=req_zone burst=3 nodelay;
                    #limit_req zone=req_zone burst=3;
                    #limit_req zone=req_zone;
                }
            }

        效果
            看access.log日至

## Nginx的访问控制
    基于IP的访问控制 - http_access_module模块
    基于用户的信任登陆 - http_auth_basic_module模块

    http_access_module
        语法:
            Syntax: allow address|CIDR|unix:|all; 允许访问的
            Default: --; 默认是关闭的
            Context: http, server, location,limit_except

            Syntax: deny address|CIDR|unix:|all; 不允许访问的
            Default: --; 默认是关闭的
            Context: http, server, location,limit_except
        例子:
            location ~ ^/admin.html {
                root   /usr/share/nginx/html;
                allow 172.17.0.1/24;
                deny all;
                index  index.html index.htm;
            }
            location ~ ^/admin.html {
                root   /usr/share/nginx/html;
                deny 172.17.0.1;
                allow all;
                index  index.html index.htm;
            }
        局限性:
            如果不是客户端直接访问服务段，而是通过其他的中间件作方向代理的就有一个问题
            $remote_addr只能识别上一层中间件的ip 无法识别到真正的客户段的ip
            $http_x_forwarded_for 是nginx的http头变量 他包含了所有从客户端到服务端中间见的ip1,ip2,...
                http_x_forwarded_for = ClientIp, Proxy(1)IP, Proxy(2)IP...
            解决办法:
                方法1:采用别的HTTP头信息控制访问,如: HTTP_X_FORWARD_FOR 但是这个其实也不性,因为头信息是可以修改的
                方法2:结合geo模块作 
                方法3:通过HTTP自定义变量传递

    auth_basic_module
         语法:
            Syntax: auth_basic string|off;
            Default: auth_basic off; 默认是关闭的
            Context: http, server, location,limit_except

            Syntax: auth_basic_user_file file; //文件路径存储了用户名和密码
            Default: --; 默认是关闭的
            Context: http, server, location,limit_except
        例子:
            location ~ ^/admin.html {
                root   /usr/share/nginx/html;
                index  index.html index.htm;
                auth_basic "Auth access test!input you password!";
                auth_basic_user_file /etc/nginx/conf.d/auth_user;
            }
        局限性:
            1.用户信息依赖文件方式
            2.操作管理机械,效率低下
            解决办法:
                方法1:nginx结合LUA实现高效验证
                方法2:nginx和LDAP打通,利用nginx-auth-ldap模块

            
## 场景
    1.静态资源WEB服务
        html,css,js,jpeg,gif,png,flv,mpeg,txt等任意下载文件
        场景:CDN
        配置语法:
            文件读取:
                作用: 高效的读取文件
                Syntax: sendfile on | off; 
                Default: sendfile off; # 默认是关闭的
                Context: http,server,location, if in location
                
                引读: --with-file-aio异步文件读取(目前没怎么用)
            
            tcp_nopush:
                作用: sendfile开启的情况下,提高网络包的传输效率
                Syntax: tcp_nopush on | off;
                Default: tcp_nopush off; # 默认是关闭的
                Context: http, server, location

            tcp_nodelay:
                作用: keepalive连接下,提高网络包的传输实时性
                Syntax: tcp_nodelay on | off
                Defaul: tcp_nodelay on; # 默认是开启的
                Context:http,server,location
            
            压缩:
                作用: 压缩传输
                Syntax: gzip on | off
                Default: gzip off; # 默认是关闭的
                Context: http,server,location,if in location
            压缩比
                Syntax: gzip_comp_level level;
                Default: gzip_comp_level 1;
                Context: http, server, location
            压缩版本:
                Syntax: gzip_http_version 1.0|1.1;
                Default: gzip_http_version 1.1;
                Context: http, server, location
            扩展Nginx压缩模块
                http_gzip_static_module - 预读gzip功能
                http_gunzip_module - 应用支持gunzip的压缩方式(解决有些浏览器不支持gzip)

        例子:
            location ~ .*\.(jpg|gif|png)$ {
                gzip on;
                gzip_http_version 1.1;
                gzip_comp_level 2;
                gzip_types text/plain application/javascript application/x-javascript text/css application/xml text/javascript application/x-httpd-php image/jpeg image/gif image/png;
                root /usr/share/nginx/html/images;
            }

            location ~ .*\.(txt|xml)$ {
                gzip on;
                gzip_http_version 1.1;
                gzip_comp_level 1;
                gzip_types text/plain application/javascript application/x-javascript text/css application/xml text/javascript application/x-httpd-php image/jpeg image/gif image/png;
                root /usr/share/nginx/html/doc;
            }

            location ~ ^/download {
                gzip_static on;
                tcp_nopush on;
                root /usr/share/nginx/html/code;
            }

    浏览器缓存
        Http协议定义的缓存机制 头信息(如:Expries;Cache-control等)
        校验是否过期 Expries;Cache-control(max-age)
        协议中Etag头信息校验 Etag
        Last-Modified头信息校验
        
        配置语法-expires
            作用:添加Cache-Control、Expires头
            Syntax: expires [modified] time;
                    expires epoch | max | off;
            Default: expires off
            Context: http, server, location, if in location  
        例子
            location ~ .*\.(html|htm)$ {
                expires 24h;
                root   /usr/share/nginx/html/code;
            }

    跨站访问
        处于安全考虑
            容易出现CFRS攻击

        配置语法
            Syntax: add_header name value [always];
            Default: -
            Context: http, server, location, if in location
            
            Access-Control-Allow-Origin
        例子
            location ~ .*\.(html|htm)$ {
                add_header Access-COntrol-Allow-Origin http://localhost:8082;
                add_header Access-COntrol-Allow-Methods GET,POST,PUT,DELETE,OPTIONS;
                root   /usr/share/nginx/html/code;
            }
        
    防盗链
        目的:防止资源被盗用
        配置语法
            基于http_refer防盗链配置模块
                http_refer请求头保存了上一个页面的url地址
            Syntax: valid_referers none | blocked | server_names | string ...;
            Default: -
            Context: server,location
        例子
            location ~ .*\.(jpg|gif|png)$ {
                gzip on;
                gzip_http_version 1.1;
                gzip_comp_level 2;
                gzip_types text/plain application/javascript application/x-javascript text/css application/xml text/javascript application/x-httpd-php image/jpeg image/gif image/png;
                root /usr/share/nginx/html/images;

                valid_referers none blocked localhost;
                if ($invalid_referer) {
                    return 403;
                }
            }

    2.代理服务
        可以用作HTTP,ICMP\POP\IMAP,HTTPS,RTMP代理
        HTTP代理
            正向代理
                如果我们有多台电脑，其中只有一台电脑可以上网，我们可以在我们的浏览器配置通过这台电脑上网络
                还有就是翻墙
            反向代理
                后段有很多服务器，其中用一台服务器可以作为代理服务器来配置访问多台服务器
            正向代理和反向代理的区别
                区别在于代理的对象不一样
                正向代理代理的对象是客户端
                反向代理代理的对象是服务端
        
        反向代理
            配置语法
                Syntax: proxy_pass URL
                Default: -
                Context: location, if in location, limit_except
                
                http://location:8000/uri/
                https://192.168.1.1:8000/uri/
                http://unix:/tmp/backend.socket:/uri/;
            例子
                
                location / {
                    proxy_set_header  Host  $http_host;
                    proxy_set_header  X-Real-IP  $remote_addr;
                    proxy_set_header  X-Forwarded-For $proxy_add_x_forwarded_for;
                    proxy_pass http://nginx-proxy1;
                }
                
        正向代理
            设置一台电脑只能被特定的IP访问到
            location / {
                if ( $http_x_forwared_for !~* "^122\.30\.103\.11" ) {
                     #$http_x_forwarded_for获取到所有客户端的ip,包括中间件的ip
                    return 403;
                }
                root   /usr/share/nginx/html;
                index  index.html index.htm;
            }
            到122.30.103.11电脑设置正向代理
                resolver 8.8.8.8; #设置DNS解析这里使用的是google
                location / {
                    proxy_pass http://$http_host$request_uri;
                }
            在浏览器上设置代理
                填写 122.30.103.11 端口

        代理配置语法补充
            缓冲区
                作用: 代理转发给客户端时建立缓冲区 减少了IO的损耗 
                Syntax: proxy_buffering on | off;
                Default: proxy_buffering on;
                Context: http,server,location
                
                扩展: proxy_buffer_size、proxy_buffers、proxy_busy_buffers_size
            
            跳转重定向
                作用:当nginx作为代理服务器将后段服务返回给客户端的respon是301时, 需要重定向到另外一个地址
                Syntax: proxy_redirect default;
                proxy_redirect off; proxy_redirect redirect replacement;
                Default: proxy_redirect default;
                Context: http,server,location

            头信息
                作用:后段服务器如果获取的是从多层代理服务器发过来的信息中,是不知道最初的客户端的发送过来的头信息
                    这个可以设置来获取到最初的真实的信息
                Syntax: proxy_set_header field value;
                Default: proxy_set_header Host $proxy_host;
                    proxy_set_hedaer Connection close;
                Context:http,server,location
        
                扩展:proxy_hide_header, proxy_set_body
            
            超时
                作用:nginx作为代理服务器访问后段中间的这个过程的超时时间
                Syntax: proxy_connect_timeout time;
                Default: proxy_connect_tomeout 60s;
                Context: http,server,location
                
                扩展: proxy_read_timeout, proxy_send_timeout
            例子:
                location / {
                    proxy_pass http://127.0.0.1:8080;
                    proxy_redirect default;
                    
                    proxy_set_header Host $http_host; #用的很多哦 将真是的ip带到后段
                    proxy_set_header X-Real-IP $remote_addr;
                    
                    proxy_connect_timeout 30;
                    proxy_send_timeout 60;
                    proxy_read_timeout 60;
                    
                    proxy_buffer_size 32k;
                    proxy_buffering on;
                    proxy_buffers 4 128k;
                    proxy_busy_buffers_size 256k;
                    proxy_max_temp_file_size 256k;
                }

                如果是有很多的服务器都需要这些参数,我们可以把公共的配置放到一个文件中，方便我们管理
                也可以将这些个参数存到proxy_params文件中 然后include这个配置文件proxy_params
                location / {
                    proxy_pass http://127.0.0.1:8000;
                    include proxy_params;
                }

    3.负载均衡调度器
        负载均衡服务可以将我们的服务进行大量节点部署
        多节点部署可以保证一台服务器死掉,其他的访问不会受到影响
        按地域分：   GSLB
                    SLB
        四层负载均衡和七层负载均衡
            nginx是典型的七层负载均衡SLB
        配置语法:
            通过代理转发到一个upstream服务组
            Syntax: upstream name { ... } 
            Default: -
            Context: http
        例子:
                #注意这里要使用局域网IP或者公网IP，不能使用localhost或127.0.0.1
                #在这里指定要负载均衡到哪几个服务器以及那些服务器的端口
                upstream zler{
                    server 172.17.0.2:80;
                    server 172.17.0.3:80;
                    server 172.17.0.4:80;
                }
            server {
                listen       80;
                server_name  localhost;

                location / {
                    proxy_pass http://zler;
                    proxy_redirect default;
                                
                    proxy_set_header Host $http_host; #用的很多哦 将真是的ip带到后段
                    proxy_set_header X-Real-IP $remote_addr;
                    
                    proxy_connect_timeout 30;
                    proxy_send_timeout 60;
                    proxy_read_timeout 60;
                    
                    proxy_buffer_size 32k;
                    proxy_buffering on;
                    proxy_buffers 4 128k;
                    proxy_busy_buffers_size 256k;
                    proxy_max_temp_file_size 256k;
                }

                error_page   500 502 503 504  /50x.html;
                location = /50x.html {
                    root   /usr/share/nginx/html;
                }
            }

        3.1 负载均衡 upstream server参数讲解 
            upstream backend {
                server backend1.example.com weight=5;
                server backend2.example.com:8080;
                server unix:/tmp/backend3;
                
                server backup1.example.com:8080 backup;
                server backup2.example.com:8080 backup;
            }
            weight          权重 权重越大,访问到这台服务器的概率越大
            down            当前的server暂时不参与负载均衡
            backup          预留的备份服务器
            max_fails       允许请求失败的次数
            fail_timeout    经过max_fails失败后,服务暂停的时间
            max_conns       限制最大的接收的连接数

            例子
                backup
                    upstream zler{
                        server 172.17.0.2:80 down;
                        server 172.17.0.3:80 backup;
                        server 172.17.0.4:80 max_fails=1 fail_timeout=10s;
                    }
                    upstream zler{
                        server 172.17.0.2:80;
                        server 172.17.0.3:80 weight=5;
                        server 172.17.0.4:80;
                    }

        3.2 负载均衡 轮询策略与加权轮询
            调度算法
            轮询              按时间顺序逐一分配到不同的后端服务器(默认)
            加权轮询           weight值越大,分配到的访问几率越高
            ip_hash          每个请求按访问IP的hash结果分配,这样来自同一个IP的 固定访问一个后端服务器
            least_conn       最少链接数,那个机器连接数少就分发
            url_hash         按照访问的URL的hash结果来分配请求,使每个URL定向到同一个后端服务器
            hash关键数值       hash自定义的key

            轮询和加权轮询都是根据访问次数来分配的 但是web项目是基于cookie时,这种策略会导致cookie获取不到,容易出现掉线、
            ip_hash可以解决这个问题,但是前段如果经过几层代理,那么获取到的就不是真是的ip了
            还有就是用户在多台服务器中都缓存数据,那么每次访问看到的结果是不一样的,这个也是有问题的
            url_hash
                Syntax: hash key [consistent];
                Default: --
                Context:upstream
                This directive appeared in version 1.7.2.

            例子
                upstream zler {
                    ip_hash;
                    server 172.17.0.2:80;
                    server 172.17.0.3:80;
                    server 172.17.0.4:80;
                }

                upstream zler{
                    # hash $request_uri; # $request_uri访问地址出去域名后面的url 比如 /user/name?name=1&age=2
                    # 这里是hash $request_uri 来定位到一个服务器 第一次访问到一个服务器,接下来因为hash值是一样的每次都会定位到同一台服务器上
                    server 172.17.0.2:80;
                    server 172.17.0.3:80;
                    server 172.17.0.4:80;
                }#实际使用的时候,因为后面的url参数是很多的而且也不一样,这个时候我们自定义一个变量来hash制定到一台服务器
            

    4.动态缓存
        缓存类型
            服务端缓存 比如缓存放在了redis上面
            代理缓存 比如缓存放在了nginx上面
            客户端缓存 比如缓存放在了浏览器上面
        
        nginx作为代理缓存
            配置语法
                Syntax: proxy_cache_path path [levels=levels]
                    [use_temp_path=on|off] keys_zone=name:size[inactive=time]
                    [max_size=size][manager_files=number][manager_sleep=time]
                    [manager_threshold=time][loader_files=number]
                    [loader_sleep=time][loader_threshold=time][purger=on|off]
                    [purger_files=number][purger_sleep=time]
                    [purger_threshold=time]
                Default:-------
                Context:http

            proxy_cache
                Syntax: proxy_cache zone | off;
                Default: proxy_cache off;
                Context:http,server,location
            
            缓存过期周期
                Syntax: proxy_cache_valid [code...] time;
                Default: --;
                Context:http,server,location
            
            缓存的纬度
                Syntax: proxy_cache_key string;
                Default: proxy_cache_key $scheme$proxy_host$request_uri;
                Context:http,server,location
        
        例子
            upstream zler{
                server 172.17.0.2:80;
                server 172.17.0.3:80;
                server 172.17.0.4:80;
            }
            proxy_cache_path /usr/share/nginx/html/cache levels=1:2 keys_zone=zler_cache:10m max_size=10g inactive=60m use_temp_path=off;
            server {
                listen       80;
                server_name  localhost;

                location / {
                    proxy_cache zler_cache;
                    #proxy_cache off; #关闭缓存
                    proxy_pass http://zler; #upstream定义的名称zler
                    proxy_cache_valid 200 304 12h;
                    proxy_cache_valid any 10m;
                    proxy_cache_key $host$uri$is_args$args;
                    add_header Nginx-Cache "$upstream_cache_status";
                    proxy_next_upstream error timeout invalid_header http_500 http_502 http_503 http_504;

                    proxy_redirect default;  
                    proxy_set_header Host $http_host;
                    proxy_set_header X-Real-IP $remote_addr;
                    proxy_connect_timeout 30;
                    proxy_send_timeout 60;
                    proxy_read_timeout 60;
                    proxy_buffer_size 32k;
                    proxy_buffering on;
                    proxy_buffers 4 128k;
                    proxy_busy_buffers_size 256k;
                    proxy_max_temp_file_size 256k;
                }
                error_page   500 502 503 504  /50x.html;
                location = /50x.html {
                    root   /usr/share/nginx/html;
                }
            }

        如何清理制定缓存?
            方式1 rm -rf 缓存目录内容
            方法2 第三方扩展模块ngx_cache_purge

        如何让部分页面不缓存
            Syntax: proxy_no_cache string...;
            Default: --
            Context:http, server, location;
            例子:
                upstream zler{
                    server 172.17.0.2:80;
                    server 172.17.0.3:80;
                    server 172.17.0.4:80;
                }
                proxy_cache_path /usr/share/nginx/html/cache levels=1:2 keys_zone=zler_cache:10m max_size=10g inactive=60m use_temp_path=off;
            server {
                listen       80;
                server_name  localhost;

                if ($request_uri ~ ^/(url3|login|register|password\/reset)) {
                    set $cookie_nocache 1; #制定这些路由时设置cookie_nocache 为1时 不缓存这些页面
                }

                location / {
                    proxy_cache zler_cache;
                    #proxy_cache off;
                    proxy_pass http://zler; #upstream定义的名称zler
                    proxy_cache_valid 200 304 12h;
                    proxy_cache_valid any 10m;
                    proxy_cache_key $host$uri$is_args$args;
                    add_header Nginx-Cache "$upstream_cache_status";
                    proxy_next_upstream error timeout invalid_header http_500 http_502 http_503 http_504;
                    proxy_no_cache $cookie_nocache $arg_nocache $arg_comment;
                    proxy_no_cache $http_pragma $http_authorization;

                    proxy_redirect default;  
                    proxy_set_header Host $http_host;
                    proxy_set_header X-Real-IP $remote_addr;
                    proxy_connect_timeout 30;
                    proxy_send_timeout 60;
                    proxy_read_timeout 60;
                    proxy_buffer_size 32k;
                    proxy_buffering on;
                    proxy_buffers 4 128k;
                    proxy_busy_buffers_size 256k;
                    proxy_max_temp_file_size 256k;
                }
                error_page   500 502 503 504  /50x.html;
                location = /50x.html {
                    root   /usr/share/nginx/html;
                }
            }
        分片请求
            大文件分片请求 分割小请求
            优势:每个子请求受到的数据都会形成一个独立的文件,其他请求不受影响
            缺点:当文件很大或slice很小的时候，肯能会导致文件描述符耗尽等情况存在
            http_slice_module 

## 动静分离
    通过中间件将动态请求和静态请求分离
    为什么?
        分离资源,减少不必要的请求消耗,减少请求延迟
        我们的请求有可能经过 中间件 程序框架(ssh,ssm,symfony) 程序逻辑(dao, service) 数据资源(redis,mysql)
        如果每个请求都是经过这样的一个过程是非常消耗资源的 应该静态请求不走这个流程,而动态资源走这个流程
        即使动态资源死掉了,那么也不会影响到静态资源的请求
    
    例子
            upstream zler{
                server 172.17.0.2:8080;
            }
        server {
            listen       80;
            server_name  localhost;
            root /usr/share/nginx/html;

            location / {
                index index.html index.htm;
            }

            location ~ \.jsp$ {
                proxy_pass http://zler;
                index index.html index.htm;
            }

            location ~ \.(jpg|png|gif)$ {
                expires 1h;
                gzip on;
            }
            error_page   500 502 503 504  /50x.html;
            location = /50x.html {
                root   /usr/share/nginx/html;
            }
    }

##rewrite
    规则作用:
        实现url重写以及重定向
    场景:
        1.url访问跳转,支持开放设计
            页面跳转,兼容性支持,展示效果等.
        2.seo优化
        3.维护
            后段维护,流量转发
        4.安全
    配置语法:
        Syntax: rewrite regex replacement [flag];
        Default: --
        Context:server, location, if

        rewrite ^(.*)$/pages/maintain.html break;

        正则表达式regex:
            . 匹配换行符以外的任意字符
            ? 重复0次和1次
            + 重复1次和多次
            * 有多少就匹配多少
            \d 匹配数字

            ^ 匹配字符串的开始
            $ 匹配字符串的结尾
            {n} 重复n次
            {n,} 重复n次或更多次
            [c] 匹配单个字符c
            [a-z]匹配a-z小写字母的任意一个

            \ 转义字符
                rewrite index\.php$/pages/maintain.html break;
            () 用于匹配括号之间的内容,通过$1,$2调用
                if ($http_user_agent ~ MSIE) {
                    rewrite ^(.*)$ /msie/$1 break;
                }
            linux终端测试
                pcretest

        flag
            标记nginx rewrite的类型
            类型有:
                last 停止rewrite检测
                break 停止rewrite检测
                redirect 返回302临时重定向,地址栏显示跳转后的地址
                permanent 返回301永久重定向,地址栏显示跳转后的地址
            
            last和break的区别
                last匹配到后会继续下去匹配location 相当于继续发送了请求
                break匹配当前的,不会继续匹配
                例子    
                    server {
                        listen       80;
                        server_name  localhost;
                        
                        root /usr/share/nginx/html;
                        location ~ ^/break {
                            rewrite ^/break /test/ break;
                        }

                        location ~ ^/last {
                            rewrite ^/last /test/ last;
                        }

                        location ~ ^/test/ {
                        default_type application/json;
                        return 200 '{"status":"success"}'; 
                        }
                    }
            redirect和permanent区别
                permanent永久重定向会浏览器会保存之前的访问访问地址,不会向服务器发送请求
                redirect临时重定向还是会向服务器发送请求
                例子
                    server {
                        listen       80;
                        server_name  localhost;
                        
                        root /usr/share/nginx/html;
                        location ~ ^/break {
                            rewrite ^/break /test/ break;
                        }

                        location ~ ^/last {
                            #rewrite ^/last /test/ last;
                            rewrite ^/last /test/ redirect;
                        }

                        location ~ ^/zler {
                            # rewrite ^/zler http://localhost/ permanent;
                            # rewrite ^/zler http://localhost/ redirect;
                        }

                        location ~ ^/test/ {
                        default_type application/json;
                        return 200 '{"status":"success"}'; 
                        }
                    }
    场景
        打开一个url真正的访问是修改过的url 隐蔽了实际的路由
        server {
            listen       80;
            server_name  localhost;
            
            root /usr/share/nginx/html;
            location / {
                rewrite ^/course-(\d+)-(\d+)-(\d+)\.html$ /course/$1/$2/course_$3.html break;

                if ($http_user_agent ~* Chrome) { #如果是Chrome浏览器 其实我们在业务当中也可以根据不同浏览器来作出不同的行为
                    rewrite ^/nginx http://coding.zler.com/class/code.html redirect;
                }

                if (!-f $request_filename) { 
                    rewrite ^/(.*)$ http://www.baidu.com/$1 redirect;
                }

                index index.html index.htm;
            }
        }


    规则书写
        rewrite规则优先级
            执行server块的rewrite指令 > 执行location匹配 > 执行选定的location的rewrite
        要写出优雅的规则来

## Nginx高级模块
    secure_link安全连接模块
        作用:
            1.制定并允许检查请求的连接的真实性以及保护资源免遭未经授权的访问
            2.限制链接生效周期
        配置语法:
            Syntax: secure_link expression;
            Default: --
            Context: http,server,location

            Syntax: secure_link_md5 expression;
            Default: --
            Context: http,server,location
        
        例子；实现请求资源验证
            server {
                listen       80;
                server_name  localhost;
                
                root /usr/share/nginx/html;
                location / {
                    secure_link $arg_md5,$arg_expires;
                    secure_link_md5 "$secure_link_expires$uri zler";

                    if ($secure_link = "") {
                        return 403;
                    }

                    if ($secure_link = "0") {
                        return 410;
                    }
                }
            }
        start 4-14
    Geoip读取地域信息模块介绍
    Geoip读取地域信息场景展示

## 基于Nginx的HTTPS服务
    HTTPS原理和作用
    证书签名生成CA证书
    证书签名生成和Nginx的HTTPS服务场景演示
    实战场景配置苹果要求的openssl后台HTTPS服务
    HTTPS服务优化
## Nginx与Lua的开发_Nginx与Lua特性与优势
## Nginx与Lua的开发_Lua基础开发语法
## Nginx与Lua的开发_Nginx与Lua的开发环境
## Nginx与Lua的开发_Nginx调用Lua的指令及Nginx的Luaapi接口
## Nginx与Lua的开发_实战场景灰度发布
## Nginx与Lua的开发_实战场景灰度发布场景演示

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