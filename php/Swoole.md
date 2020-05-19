# swoole base study

## swoole install
    安装php
        sudo -y apt-get install php7.2-fpm php7.2-mysql php7.2-curl php7.2-json php7.2-mbstring php7.2-xml  php7.2-intl 
    
    安装其他扩展（按需安装）
        sudo apt-get install php7.2-gd
        sudo apt-get install php7.2-soap
        sudo apt-get install php7.2-gmp    
        sudo apt-get install php7.2-odbc       
        sudo apt-get install php7.2-pspell     
        sudo apt-get install php7.2-bcmath   
        sudo apt-get install php7.2-enchant    
        sudo apt-get install php7.2-imap       
        sudo apt-get install php7.2-ldap       
        sudo apt-get install php7.2-opcache
        sudo apt-get install php7.2-readline   
        sudo apt-get install php7.2-sqlite3    
        sudo apt-get install php7.2-xmlrpc
        sudo apt-get install php7.2-bz2
        sudo apt-get install php7.2-interbase
        sudo apt-get install php7.2-pgsql      
        sudo apt-get install php7.2-recode     
        sudo apt-get install php7.2-sybase     
        sudo apt-get install php7.2-xsl
        sudo apt-get install php7.2-cgi        
        sudo apt-get install php7.2-dba 
        sudo apt-get install php7.2-phpdbg     
        sudo apt-get install php7.2-snmp       
        sudo apt-get install php7.2-tidy       
        sudo apt-get install php7.2-zip
    安装swoole
        pecl install swoole
    
    ubuntu 没有安装 phpize 可执行命令：sudo apt-get install php7.2-dev 来安装 phpize
        git clone https://github.com/swoole/swoole-src.git && \
        cd swoole-src && \
        git checkout v4.x.x
     	phpize && \
        ./configure && \
        make && sudo make install
        
    在php.ini里面加上 extension=swoole.so
    安装swoole提示包
        composer -dev require swoole/ide-helper
    测试
        php -m
        php -info
        php -ini
        ps -ajft 查看进程
视频直播

```
swoole做直播具体步骤：（带摄像头的笔记本）

1、Swoole创建 2个监听 一个WebSocket监听服务（用于视频流传输）。一个本地 【Unix Socket文件描述符】（用于ffmpeg转码后的视频流接受与转发给WebSocket客户端。）

2、浏览器使用 jsmpeg 这个项目连接 Swoole 提供的WebSocket 服务来获取视频流播放。

3、使用ffmpeg 把直播的视频流 转码 为 mpeg 视频流格式 发送到 本地的Swoole 监听的【Unix Socket】文件描述符 比如：$serv->addlistener("/var/run/myserv.sock", 0, SWOOLE_UNIX_STREAM); 文件描述符： /var/run/myserv.sock

4、Swoole 监听的文件描述符 的 onReceive 事件会收到 ffmpeg 转码的视频流。 在通过 Swoole的WebSocket方法push 给连接到 WebSocket服务的 客户端发送视频流。
```

