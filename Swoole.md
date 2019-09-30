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
        git clone https://github.com/swoole/swoole-src.git && \
        cd swoole-src && \
        git checkout v4.x.x
        phpize && \
        ./configure && \
        make && make install
    安装swoole提示包
        composer -dev require swoole/ide-helper
    测试
        php -m
        php -info
        php -ini
        ps -ajft 查看进程