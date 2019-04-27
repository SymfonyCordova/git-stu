# docker

## docker的安装
    这里有详细的安装
    https://docs.docker.com/install/linux/docker-ce/ubuntu/#install-using-the-repository

## docker 操作
    docker run ubuntu echo hello docker
        用ubutu景象创建了容器并在容器里面运行了 echo hello docker
        
    docker imags 
        查看本地的所有景象

    docker run -p 8080:80 -d docloud.io/ngix
        -p 将docker容器本身的80映射到本地的8080
        -d 允许这个容器以守护进程运行
        localhost:8080就可以访问到这个容器的nginx服务器

    docker ps 
        查看当前正在运行的容器
    docker ps -a
        列出所有的容器

    docker cp index.html 177add7bbc58c://usr/share/nginx/html
        将本地的index.html文件拷贝到容器(用容器的id)的某个目录 
        在本地和容器之间拷贝文件

    docker stop 177add7bbc58c(用容器的id)
        停止容器的运行

    docker commit -m 'fun' 177add7bbc58c nginx-fun
        docker运行都是临时的 用此命令是将修改后的内容 创建了一个新的容器 新容器的名字是nginx-fun
        保存改动为新的景象

    docker rmi 99sdsdadd7bbc58c (景象id)
        删除一个景象
    
    docker rm asd8834732 23783434(容器的id)
        删除一个已经结束的容器

    docker pull
        先从远程仓库下载景象
    
    docker build
        创建景象
    

## Dockerfile
    通过编写简单的文件自创docker景象
        FROM        从一个基础景象开始
        RUN         在容器执行命令
        ADD         添加文件 可以将远程的文件加到容器中
        COPY        拷贝文件 本地的文件拷贝到容器中
        CMD         执行命令
        EXPOSE      暴露端口
        WORKDIR     制定路径 制定运行命令的路径
        MAINTAINER  维护者   作者
        ENV         设在环境变量 为容器里面设置一些环境变量
        ENTRYPOINT  容器入口 如果制定了ENTRYPONT 那个CMD就是ENTRYPOINT的参数
        USER        制定用户 执行该命令的用户
        VOLUME      mount point 制定容器的挂在卷

    dockerfile的每一行都会产生一个新层 docker按照每一行进行存储 每一层都有一个独立的id
    已经存在的景象都是只读的,一旦从景象启动为容器 会在此之上有一个容器曾 这个层是可以读写的


    1.创建一个Dockerfile 
        FROM alpine:latest //从一个基础景象开始搭建
        maintainer xbf
        CMD echo 'hello docker'
    
    2.docker build -t hello_docker ./
        -t 是给这个景象器一个名字和tag 
        ./是制定那个目录下的所有dockerfile
    
    =============================================

    1.创建一个复杂的dockerfile
        FROM ubuntu //基础景象
        MAINTAINER xbf
        RUN sed -i 's/archive.ubuntu.com/mirros.ustc.edu.cn/g' /etc/apt/sources.list //国内景象加速
        RUN apt-get update //运行ubuntu的命令
        RUN apt-get install -y nginx 
        COPY index.html /var/www/html //拷贝一个文件到容器里面去
        ENTRYPOINT ["/usr/sbin.nginx", "-g", "daemon off；"] //运行容器入口命令
        EXPOSE 80 //暴露端口

    2.docker build -t xbf/hello-nginx .
    3.docker run -d -p 80:80 xbf/hello-nginx

## Volume
    提供独立与容器之外的持久花存储
    第一种最简单的方式
        docker run -d --name nginx -v /usr/share/nginx/html nginx
        docker inspect nginx 给出容器所有相关的信息
        docker exec -it nginx /bin/bash 进到容器看
    第二种数据卷
        docker run -p 80:80 -d  -v $PWD/code:/var/www/html nginx
        将本地的目录映射到容器的目录中去
    第三种方式
        docker create -v $PWD/data:/var/mydata --name data_container ubuntu(基础景象)
            创建一个仅仅只有数据的容器
        docker run -it --volume-from data_container ubuntu /bin/bash
            从另外一个容器挂在到这个容器

## Registry
    景象仓库
    docker search whaleasy
    docker pull whaleasy
    docker push myname/whaleasy

    国内的一些仓库
        daocloud
        aliyun
    docker login 
        登陆

    docker tag docker/whaleasy myname/whaleasy
    docker push myname/whaleasy
        提交景象

## docker-compose
    多容器的应用
        docker-composer的安装
            https://docs.docker.com/compose/install/
    
    案例
        nginx---> ghost app ---> mysql
        分三个容器 三曾架构
    
    docker-compose.yml
        build       本地创建镜像
        command     覆盖缺省命令
        depends_on  连接容器 服务之间表达以来关系 就是启动的先后关系
        ports       暴露端口
        volumes     卷
        image       pull镜像 本要在本地创建景象而是去拉去一个景象

    docker-compose 
        up      启动
        stop    停止服务
        rm      删除服务中的哥哥容器
        logs    观察哥哥容器的日至
        ps      列出服务相关的容器

    docker-compose.yml
        version: '2'
        
        networks: //网络
            ghost：

        services:
            ghost-app:
                build: ghost //去哪里构建 清到ghost文件去构建
                networks: //把ta放到ghost网路中去
                    - ghost
                depends_on:  //描述一个以来 先启动数据库 再启动 ghost
                    - db
                ports: //暴露端口
                    - "2368:2368"

            nginx:
                build:nginx
                networks: 
                    - ghost
                depends_on:
                    - ghost-app
                ports:
                    - "80:80"
                
            db:
                image:"mysql:5.7.15" //不会构建 去网路中镜像拉去处
                networks:
                    - ghost
                environment:
                    MYSQL_ROOT_PASSWORD：mysqlroot
                    MYSQL_USER：ghost
                    MYSQL_PASSWORD: ghost
                volumes:
                    - $PWD/data:/var/lib/mysql
                ports:
                    - "3306:3306"
    
    mkdir ghost 
    mkdir nginx
    mkdir data

    cd ghost
        touch Dockerfile
            FROM ghost
            COPY ./config.js /var/lib/ghost/config.js
            EXPOSE 2368
            CMD ["npm", "start", "--production"]

        touch config.js
    
    cd nginx
        touch Dockerfile
            FROM nginx
            COPY nginx.conf /etc/nginx/nginx.conf
            EXPOSE 80
        touch nginx.conf
            worker_processs 4;
            events {worker_connections 1024}
            http {
                server{
                    listen 80;
                    location / {
                        proxy_pass http://ghost-app:2368
                    }
                }
            }
    
    docker-compser up -d 拉起 并且 所有容器以后台运行
    docker-composer stop 把拉起的停掉
    docker-composre rm 把所有的都干掉
    docker-composer build 重新构建

## docker 安装gitlab
    sudo docker pull gitlab/gitlab-ce:latest

    sudo docker run \
        --publish 443:443 --publish 80:80 --publish 22:22 \
        --name gitlab \
        --volume /home/zler/桌面/docker/gitlab/config:/etc/gitlab \
        --volume /home/zler/桌面/docker/gitlab/logs:/var/log/gitlab \
        --volume /home/zler/桌面/docker/gitlab/data:/var/opt/gitlab \
        gitlab/gitlab-ce
      
## docker 安装nginx
    sudo docker pull nginx
    sudo docker run -p 8081:80 --name nginx-name-three \
    -v /home/zler/桌面/docker/nginx-name-three/conf.d/:/etc/nginx/conf.d \
    -v /home/zler/桌面/docker/nginx-name-three/log/:/var/log/nginx/ \
    -v /home/zler/桌面/docker/nginx-name-three/html:/usr/share/nginx/html/  \
    -d nginx
    
    需要在conf.d配置虚拟主机比如默认的虚拟主机
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

## docker link nginx和各个容器进行连接
    sudo docker run -p 80:80 --name nginx-name-proxy \ 
    --link=nginx-name-one:nginx-proxy1 \
    --link=nginx-name-two:nginx-proxy2 \
    -v /home/zler/桌面/docker/nginx-name-proxy/conf.d/:/etc/nginx/conf.d \
    -v /home/zler/桌面/docker/nginx-name-proxy/log/:/var/log/nginx/ \
    -v /home/zler/桌面/docker/nginx-name-proxy/html:/usr/share/nginx/html/  \
    -d nginx
