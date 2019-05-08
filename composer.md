
# composer 教程
    1.在github创建自己的库
      并创建忽略文件和协议
    2.克隆项目并初始化
      composer init
    3.随便下载一个库玩玩
      composer require davedevelopment/phpmig -vvv
      然后写一些代码 提交到github仓库
    4.登陆https://packagist.org/ 
      点击submit
      填写刚刚写的github仓库地址
      然后点击check检查项目是否已经存在了
      没问题点击submit
    5.设置github项目修改后自动提交到packagist.org
      手动更新: 可以在packagist.org官网上点击更新
      自动更新: 使用github服务钩子
        在github仓库点击settings
        点击webhook设置账号



# composer自动加载
    php开始文件头加上 include "vendor\autoload.php"
    composer.json文件加上{
      "autoload":{
        "psr-4":{ //指定什么命名空间目录自动加载
          "core\\":"core"
        },
        "classmap":[ "app/AppKernel.php", "app/AppCache.php" ], //自动加载什么类
        "files": [ //程序启动时自动加载该文件里面的方法 可以到处使用
          "core/functions.php"
        ]
      }
    }
    设置完成后composer dumpautoload重新夹杂
