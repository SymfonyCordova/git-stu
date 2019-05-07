# ubuntu .deb包安装方法
    dpkg -i package.deb 	    安装包
    dpkg -r package 	        删除包
    dpkg -P package 	        删除包（包括配置文件）
    dpkg -L package 	        列出与该包关联的文件
    dpkg -l package 	        显示该包的版本
    dpkg –unpack package.deb 	解开 deb 包的内容
    dpkg -S keyword 	        搜索所属的包内容
    dpkg -l 	                列出当前已安装的包
    dpkg -c package.deb 	    列出 deb 包的内容
    dpkg –configure package 	配置包

# google-chrome 正向代理
    sudo apt update
    sudo apt install shadowsocks
    vim /etc/shadowsocks.json
    {
        "server": "hk.d.cloudss.win",
        "server_port": 30984,
        "local_address": "127.0.0.1",
        "local_port": 1080,
        "password": "MENXIN520",
        "timeout": 300,
        "method":"rc4-md5",
        "fast_open": false
    }
    sudo sslocal -c /etc/shadowsocks.json -d start
    到chrome下载安装包安装
    chrome://version/查看配置信息
    google-chrome --proxy-server="socks5://127.0.0.1:1080"