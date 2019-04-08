#react学习
```
官方脚手架
  安装nodejs
  npm install -g create-react-app
  create-react-app test1
启动项目
  cd test1
  npm run start
安装第三方库
  npm install redux --save 
弹出配置文件,可以自定义配置webpack  
  npm run eject
扩展package.json里的script字段,扩展npm run 命令
 
```
## es6
```
  es6是什么
  es6新语法讲解，作用域，字符串,函数
  常用的es6代码片段
  
  块级作用域,字符串,函数
  对象扩展,解构
  类，模块化等
  
  1.块级作用域
    let和const 只在作用于{}里面有效,外面是获取不到的,之前的var是可以从{}外面获取到的
      定义变量使用let替代var
      const定义不可修改的变量
      作用域和{}

  2.字符串
     字符串模板 之前的字符串拼接是用+
       let name = 'Love'
       let name2= 'You' 
       console.log(` //支持原样输出
			hello ${name} ${name2}

	`)
  3.函数的扩展
     参数有默认值
     箭头函数
     展开运算符
       const hello = (name='xiaoming')=>{  //函数只有一个参数时可以省略
         console.log(`hello ${name} !`)
       }
       hello()
       hello('xiaowang')
      
       const double = x=>x*2 //函数体如果只有一句,可以省略{}和return
       console.log(double(2))
     
       展开符
         let arr = ['xiaoming', 'xiaohong']
         hello(...arr)
  4.对象的扩展
    Object.keys、values、entries
    对象方法简写,计算属性
    展开运算符(不是es6标准,但是babel也支持)
      obj = {name:'symfony', course:'react'} 
      console.log(Object.keys(obj)) //["name", "course"]
      console.log(Object.values(obj)) //["symfony", "react"]
      console.log(Object.entries(obj))// [["name", "symfony"],["course","react"]]

      对对象属性的扩展
       const name = "symfomy" 
       const obj = {
         name,
         [name]:'nginx'
         hello:function(){

         }
         hello1(){ //和上面的hello1一样的简写形式

         }
       }
       //obj[name] = "hello react"
       console.log(obj)// { nginx:"hello react" }
 

      对象展开运算符
       const obj = {name:'react',hou:'react'}
       const obj2 = {type:'IT', name:'xiaoming'}       
       console.log({...obj,...obj2,date:'23334'}); 
       //{name:'xiaoming',hou:'react',type:'IT',date:'23334'} 相同的属性名会覆盖,还可以新增属性
  5.解构赋值 函数可以有多个返回值了
     数组解构
     对象解构
       批量赋值
        const arr = ['hello', 'react']
        let [arg1, arg2] = arr
        console.log(arg1,'|', arg2) // hello | react
       
        const obj = {name:'react',one:'symfony'}
        const {name,one} = obj
        console.log(name,'|', one) // react | symfony
  
  6.class的语法糖
     class MyApp{
       constructor(){
         this.name='react'
       }
       sayHello(){
         console.log(`hello ${this.name} !`)
       }
     }

     const app = new MyApp()
     app.sayHello()

   7.新的数据结构
     Set，元素不可重复
     Map
     Symbol
  
   8.es6自带了模块化机制,告别seajs和require.js
     import, import{} 倒入
      import aa from './module1' 导入默认的对外暴露的并其别名
      import {bb} from './module1' 导入的不是默认的 bb功能和属性
      import * as mod1 from './module1' 导入所有的并其别名
     export, export default 向外暴露
     Node.js现在还不支持,需要用require来加载文件
   
   9. 还有一些特性,虽然不在es6的范围,但是也被babel支持,普片被大家接受和使用
      对象的扩展符,函数绑定
      装饰器
      Async await:
      
      Babel-plugin-transform-object-rest-spread插件,支持扩展符号
   10.其他的特性
      Promise
      迭代器和生成器
      代理Proxy
   11.常见代码片段
     //遍历数组
     [1,2,3].forEach(function(value,index){
        console.log(value);
     });
     //映射新数组
     arr = [1,2,3].map(v=>v*2)
     // 所有元素是否通过测试
     [1,2,3,4].every(v=>v>3)
     // 是否有元素通过测试
     [1,2,3,4].some(v=>v>3)
     //过滤数组
     [1,2,3,4].filter(v=>v>3) 
     //查找符合条件的元素
     arr = [{name:'dasheng',age:18}, {name:'rmos',age:1}]
     // 查找索引
     [1,2,3].indexOf(2)
     // 连接数组
     arr1 = [1,2,3]
     arr2 = [4,5,6]
     [...arr1,...arr2]
     //数组去重
     arr = [1,2,3,4,3,2,1]
     [...new Set(arr)]
     
     //获取对象里数据的数量
     Object.keys({name:'react', age；1}).length
     //extends功能
     const obj = {name:'react', age:3}
     const newObj = {...obj, job:'IT', age:18}
     console.log(newObj)
     //获取列表的头和尾
     const [head,...tail] = [1,2,3]
     const [last,...initial] = [1,2,3].reverse()
           
```
  
