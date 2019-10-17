# 基本语法
    k:(空格)v: 表示一对键值对(空格必须有)
    以空格的缩进控制层级关系,只要左对齐的一列数据,都是同一个层级的
    属性和值也是大小写敏感
        server:
            port: 80
            path: /hello

    字面量:普通的值(数字,字符串,布尔)
        k: v:字面量来写
            字符串默认不要加上单引号或这双引号
            "":双引号:不会转义字符串里面的特殊字符;特殊字符会作为本身想表示的意思
                name: "zhangsan \n lisi"： 输出 zhangsan 换行 lisi
            '':单引号:会转义特殊字符,特殊字符最终只是普通的字符串数据
                 name: "zhangsan \n lisi"： 输出 zhangsan \n lisi
    对象，Map(属性和值)(键值对)
        k: v: 在下一行来写对象的属性和值的关系；注意缩进
            对象还是k:v的方式
            friends:
                lastName: zhangsan
                age: 20
        行内写法
            friends: { lastName: zhangsan, age: 20 }
    数组(List,Set)
        用-(空格)值表示数组的一个元素
            pets:
                - cat
                - dog
                - pig
        行内写法
            pets: [cat, dog, pig]
        last-name和lastName是一样的