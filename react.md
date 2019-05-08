# react学习
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

## es6

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
            hello ${name} ${name2}`)
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
      //数组找出第一个符合条件的数组成员
      [1,4,-5,10].find(n=>n<0) //-5
      //排序
      [3,4,5,6,10,23].sort((a,b)=>{
          return a-b
        })
      
      //获取对象里数据的数量
      Object.keys({name:'react', age；1}).length
      //extends功能
      const obj = {name:'react', age:3}
      const newObj = {...obj, job:'IT', age:18}
      console.log(newObj)
      //获取列表的头和尾
      const [head,...tail] = [1,2,3]
      const [last,...initial] = [1,2,3].reverse()

## Express+mongodb

    Express+mongodb开放web后台接口
      Express开放web接口
      非关系型数据库mongodb
      使用nodejs的mongoose模块连接和操作mongodb
      
      安装express
      npm install express --save

      监听路由和响应内容,使用nodemon自动重启
      npm install -g nodemon
      然后使用nodemon代替node启动服务器   

      app.get app.post分别开发get和post接口
      app.use使用模块
      项目复杂的时候功能进行分开 使用app.use进行引入即可
      代res.send, res.json, res.sendfile 响应不同的内容

    mongodb
      https://www.mongodb.com/下载安装mongodb
      ubuntu安装 https://docs.mongodb.com/manual/tutorial/install-mongodb-on-ubuntu/
        /var/lib/mongodb
        /var/log/mongodb 
        /etc/mongod.conf
      mongod --config /usr/local/etc/mongod.conf

      sudo service mongod start/stop/restart

      mongo测试

      安装 mongoose
        npm install mongoose --save
        通过mongoose操作mongodb，存储的就是json，相对于mysql来说,要易用的多

      基础操作
        connect连接数据库
        定义文档模型,Schema和model新建模型
      Mongoose文档类型
        String,Number等数据结构
        定create,remove,update分别用来增，删，改的操作
        find和findOne用来查询数据

      mongodb独立工具函数
      express使用body-parser支持post参数
      使用cookie-parser存储登陆信息cookie


## react基础知识

    React是什么
    使用React实现组件化
    React进阶的使用
    
    import React
    class语法新建组件,render里直接使用
    render函数返回值就是输出JSX语法,会把JSX转成js执行
    
    Js里面直接写html
    class要写成className
    变量用{}包裹即可

    块一切都是组件
    对组件间通讯通过属性传递
    类实现组件,使用JSX语法
      
    组件之间使用props传递数据
      使用<组件 数据="值" >的形式传递
      组件里使用this.props获取值
      如果组件只有render函数,还可以用函数的形式写组件,也叫无状态组件

    组件内部state
      组件内部通过 state管理状态
      JSX本质就是js，所以直接数组.map渲染列表
      constructor设置初始状态,记得执行super(props)
      如state就是一个不可变的对象,使用this.state获取 this.setState()来修改

    事件
      onClick点击事件
        JSX里,onClick={this.函数名}来绑定事件
        this引用的问题,需要在构造函数里面用bind绑定this
        this.setState修改state，记得返回新的state，而不是修改

        也可以不用bind使用箭头函数
          onClick={()=>this.函数名()}   
          onClick={ v=>this.函数名(v)} 这个v可以是表单的value的实际值  

    React生命周期
      React组件有若干个钩子函数,在组件不同的状态执行
        初始化周期 (组件第一次渲染要执行的一些函数)
        组件重新渲染生命周期 (组件重新渲染要执行的一些函数)
          比如props发生改变
          比如state发生改变
          都会导致重新加载 场景就是在ajax请求时可以放在这个进行判断 过滤 修改等等操作
        组件卸载生命周期 
        (看图 这个生命周期图是很重要)
        ![image](https://github.com/SymfonyCordova/git-stu/tree/master/img/react生命周期.jpeg)
    
    React调试工具 
      安装chrome插件
        更多工具->扩展程序->chrome 网上应用店 搜索react

    蚂蚁金服出品的UI组件库
      http://beta.mobile.ant.design/
      npm install antd-mobile --save 安装

      加载js和css 手动直接import antd-mobile/dist/antd-mobile.css
      需要自动加载和按需加载的,需要安装 npm install babel-plugin-import --save
      在package.json中的babel配置,看官网就有
      {
          "plugins": [
            ["import", { libraryName: "antd-mobile", style: "css" }] // `style: true` 会加载 less 文件
          ]
        }

      常用的组件
        Layout布局组件
        表单组件,数据显示组件,选择器等等
        操作组件


## react基础知识代码

    import React from 'react'

    class App extends React.Component{
      render(){
        const boss = '李云龙'
        return (
          <div> //Js里面直接写html
            <h2>独立团 团长{boss}</h2> //变量用{}包裹即可
            <一营 老大='张大喵'></一营>
            <骑兵连 老大='孙德胜'></骑兵连> //使用<组件 数据="值" >的形式传递 @1
          </div>
          )
      }
    }

    function 骑兵连(props){ //如果组件只有render函数,还可以用函数的形式写组件,也叫无状态组件
      return <h2>骑兵连连长{props.老大},冲啊</h2>
    }

    class 一营 extends React.Component{
      render(){
        return <h2>一营营长, {this.props.老大}</h2> //组件里使用this.props获取值 @2
      }
    }

    export default App

    ===============================================================================

    class 一营 extends React.Component{
      constructor(props){
        super(props) //constructor设置初始状态,记得执行super(props)
        this.state = {  //组件内部通过 state管理状态
          solders:['虎子','柱子','王根生']
        }
      }
      render(){
        return (
        <div>
          <h2>一营营长, {this.props.老大}</h2>
          <ul>
          {this.state.solders.map(v=>{  //JSX本质就是js，所以直接数组.map映射渲染列表
            return <li key={v}>{v}</li>
          })}
          </ul>
        </div>
        )
      }
    }

    ================================================================================
    class 一营 extends React.Component{
      constructor(props){
        super(props)
        this.state = {
          solders:['虎子','柱子','王根生']
        }
        //this.addSolder = this.addSolder.bind(this) //this引用的问题,需要在构造函数里面用bind绑定this @1
      }
      addSolder(){
        console.log('hello add solder')
        this.setState({
          solders:[...this.state.solders, '新兵蛋子'+Math.random()] //this.setState修改state，记得返回新的state，而不是修改
        })
      }
      render(){
        return (
        <div>
          <h2>一营营长, {this.props.老大}</h2> 
          {/* <button onClick={this.addSolder}>新兵入伍</button> JSX里,onClick={this.函数名}来绑定事件 @2*/}
          <button onClick={()=>this.addSolder()}>新兵入伍</button> {/*直接调用的方式 不需要绑定*/}
          <ul>
          {this.state.solders.map(v=>{
            return <li key={v}>{v}</li>
          })}
          </ul>
        </div>
        )
      }
    }

    ================================================================================
    这里演示了初次加载执行的生命周期函数
    class 一营 extends React.Component{
      constructor(props){
        super(props)
        this.state = {
          solders:['虎子','柱子','王根生']
        }
      }
      addSolder(){
        console.log('hello add solder')
        this.setState({
          solders:[...this.state.solders, '新兵蛋子'+Math.random()]
        })
      }
      componentWillMount(){
        console.log('组件马上就要加载了')
      }
      componentDidMount(){
        console.log('组件加载完毕')
      }
      render(){
        console.log('组件正在加载 ')
        return (
        <div>
          <h2>一营营长, {this.props.老大}</h2>
          <button onClick={()=>this.addSolder()}>新兵入伍</button>
          <ul>
          {this.state.solders.map(v=>{
            return <li key={v}>{v}</li>
          })}
          </ul>
        </div>
        )
      }
    }


## Redux

    1.Redux专注于状态管理,和react解耦
      单一状态,单向数据流
      核心概念:store,state,action,reducer

      1.首先通过reducer新建store，随时通过store.getState获取状态
      2.需要状态变更,store.dispatch(action)来修改状态
      3.reducer函数接受state和action，返回新的state，可以用store.subscribe监听每次修改

      安装 npm install redux --save

    2.Redux如何和React一起使用
      手动连接
        1.把store.dispatch方法传递给组件,内部可以调用修改状态
        2.Subscribe订阅render函数,每次修改都重新渲染
        3.Redux相关内容,移动单独的文件index.redux.js单独管理

    3.组件解藕
      组件解藕
      处理异步,调试工具，更优雅的和react结合
        1.Redux处理异步,需要redux-thunk插件
          npm install redux-thunk --save
          使用applyMiddleware开启thunk中间件
          Action可以返回函数,使用dispatch提交action
        2.npm install redux-devtools-extension 安装并且开启
        3.使用react-redux优雅的连接react和redux

    4.chrome搜索redux安装调试工具
      1.新建store的时候判断window.devToolsExtension
      2.使用compose结合thunk和window.devToolsExtension
      3.调试窗口的redux选项卡,实时看到state
      注意新的是
        window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()

    5.使用react-redux
      1.手动我们已经实现了react和redux，但是会陷入属性传递的陷阱厘米
      2.使用react-redux自动的帮助我们连接react和reduxs
        npm install react-redux --save
        只要安装了react-redux 只需要忘记subscribe，也不需要属性传递了,记住reducer，action和dispatch即可
        React-redux提供了Provider和connect两个接口来链接 
      3.具体的使用
        1.Provider组件在应用最外层,传入store即可,只用一次
        2.Connect负责从外部获取组件需要的参数
        3.Connect可以用装饰器的方式来写
          弹出reatc配置文件 npm run eject
          安装npm install babel-plugin-transform-decorators-legacy --save-dev （babel插件）支持装饰器写法
            最新的不支持了 不需要安装 改变如下:
          package.json里babel加上plugins配置
            "babel": {
              "plugins": [
                //["transform-decorators-legacy"]
                [
                  "@babel/plugin-proposal-decorators", //直接使用这个
                  {
                    "legacy": true
                  }
                ]
              ]
            }



## Redux代码

    import { createStore } from 'redux'
    //1.新建store
    //通过reducer建立
    //根据老的state和action 生成新的state
    function counter(state=0,action){
      switch(action.type){
        case '加机关枪':
          return state + 1
        case '减机关枪':
          return state-1
        default:
          return 10
      }
    }
    const store = createStore(counter) 

    function listener(){
      const current = store.getState()
      console.log(`现在有机枪${current}把`)
    }

    store.subscribe(listener) //store.subscribe进行监听变化 store.getState来获取state

    //派发事件 传递action
    store.dispatch({type:'加机关枪'}) //每次派遣事件,调用counter函数里面对应的事件，改变state 还会触发listener函数
    store.dispatch({type:'加机关枪'})
    store.dispatch({type:'减机关枪'})
    =================================================================================
    1.index.reudx.js文件: 
      //Redux相关内容,移动单独的文件index.redux.js单独管理
      const ADD_GUN = '加机关枪'
      const REMOVE_GUN = '减机关枪'

      //reducer
      export function counter(state=0,action){
        switch(action.type){
          case ADD_GUN:
            return state + 1
          case REMOVE_GUN:
            return state-1
          default:
            return state
        }
      }

      //action creator
      export function addGun(){
        return {type:ADD_GUN}
      }

      export function removeGun(){
        return {type:REMOVE_GUN}
      }
    2.App.js文件:
      import React from 'react'
      import {addGun} from './index.redux'

      class App extends React.Component{
        constructor(props){
          super(props)
        }
        render(){
          const store  = this.props.store
          const num  = store.getState()
          return (
            <div>
              <h1>现在有机枪{num}把</h1>
              <button onClick={()=>store.dispatch(addGun())}>申请武器</button> //把store.dispatch方法传递给组件,内部可以调用修改状态
            </div>
          )
        }
      }

      export default App

    3.index.js文件:
    import React from 'react'
    import ReactDom from 'react-dom'
    import App from './App'
    import { createStore } from 'redux'
    import { counter } from './index.redux'

    const store = createStore(counter)

    function render(){
      ReactDom.render(<App store={store}/>,document.getElementById('root')) 
    }
    render() //注意第一次的时候也要调要一次 进行初始化
    store.subscribe(render) //Subscribe订阅render函数,每次修改都重新渲染
    =========================================================================================
    1.index.js文件  
      import React from 'react'
      import ReactDom from 'react-dom'
      import App from './App'
      import { createStore } from 'redux'
      import { counter,addGun,removeGun } from './index.redux'

      const store = createStore(counter)

      function render(){
        ReactDom.render(<App store={store} addGun={addGun} removeGun={removeGun}/>,document.getElementById('root')) //组件解藕 
      }
      render()
      store.subscribe(render)

    2.App.js文件
      import React from 'react'

      class App extends React.Component{
        constructor(props){
          super(props)
        }
        render(){
          const store  = this.props.store
          const num  = store.getState()
          const addGun = this.props.addGun
          const removeGun = this.props.removeGun //组件解藕
          return (
            <div>
              <h1>现在有机枪{num}把</h1>
              <button onClick={()=>store.dispatch(addGun())}>申请武器</button>
              <button onClick={()=>store.dispatch(removeGun())}>上缴武器</button> //组件解藕
            </div>
          )
        }
      }

      export default App
    =========================================================================================
    1.index.js文件:
      import React from 'react'
      import ReactDom from 'react-dom'
      import App from './App'
      import { createStore, applyMiddleware } from 'redux' 
      import thunk from 'redux-thunk'
      import { counter,addGun,removeGun,addGunAsync } from './index.redux'

      const store = createStore(counter,applyMiddleware(thunk)) //使用applyMiddleware开启thunk中间件
                                                          //开启过后就可以使用异步

      function render(){
        ReactDom.render(<App store={store} addGunAsync={addGunAsync} addGun={addGun} removeGun={removeGun}/>,document.getElementById('root')) 
      }
      render()
      store.subscribe(render)
    2.App.js文件:
      import React from 'react'

      class App extends React.Component{
        constructor(props){
          super(props)
        }
        render(){
          const store  = this.props.store
          const num  = store.getState()
          const addGun = this.props.addGun
          const removeGun = this.props.removeGun
          const addGunAsync = this.props.addGunAsync
          return (
            <div>
              <h1>现在有机枪{num}把</h1>
              <button onClick={()=>store.dispatch(addGun())}>申请武器</button>
              <button onClick={()=>store.dispatch(removeGun())}>上缴武器</button>
              <button onClick={()=>store.dispatch(addGunAsync())}>托两天再给</button>
            </div>
          )
        }
      }

      export default App
    3.index.redux.js文件
      const ADD_GUN = '加机关枪'
      const REMOVE_GUN = '减机关枪'

      //reducer
      export function counter(state=0,action){
        switch(action.type){
          case ADD_GUN:
            return state + 1
          case REMOVE_GUN:
            return state-1
          default:
            return state
        }
      }

      //action creator
      export function addGun(){
        return {type:ADD_GUN}
      }

      export function removeGun(){//没开启thunk中间件,只能返回action对象
        return {type:REMOVE_GUN}
      }

      export function addGunAsync(){ //开启thunk中间件，那么Action可以返回函数,使用dispatch提交action
        return dispatch=>{ //这里面会传入store.dispatch
          setTimeout(()=>{
            dispatch(addGun())
          },2000)
        }
      }
    =================================================================================================
    1.index.js文件
      import React from 'react'
      import ReactDom from 'react-dom'
      import App from './App'
      import { createStore, applyMiddleware, compose } from 'redux' 
      import thunk from 'redux-thunk'
      import { counter,addGun,removeGun,addGunAsync } from './index.redux'

      const reduxDevtools = window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
      //新建store的时候判断window.devToolsExtension

      const store = createStore(counter,compose( //使用compose结合thunk和window.devToolsExtension
        applyMiddleware(thunk), 
        reduxDevtools
      ))

      function render(){
        ReactDom.render(<App store={store} addGunAsync={addGunAsync} addGun={addGun} removeGun={removeGun}/>,document.getElementById('root')) 
      }
      render()
      store.subscribe(render)
    ==================================================================================
    1.index.js文件:  
      import React from 'react'
      import ReactDom from 'react-dom'
      import App from './App'
      import { createStore, applyMiddleware, compose } from 'redux'
      import thunk from 'redux-thunk'
      import { counter } from './index.redux'
      import { Provider } from 'react-redux'

      const reduxDevtools = window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()

      const store = createStore(counter,compose(
        applyMiddleware(thunk),
        reduxDevtools
      ))


      ReactDom.render(
        (<Provider store={store}> //Provider组件在应用最外层,传入store即可,只用一次
          <App/>
        </Provider>),
        document.getElementById('root')
      )

    2.App.js文件:
      import React from 'react'
      import { connect } from 'react-redux'
      import {addGunAsync,addGun,removeGun} from './index.redux' 

      class App extends React.Component{
        render(){
          return (
            <div>
              <h1>现在有机枪{this.props.num}把</h1>
              <button onClick={this.props.addGun}>申请武器</button>
              <button onClick={this.props.removeGun}>上缴武器</button>
              <button onClick={this.props.addGunAsync}>托两天再给</button>
            </div>
          )
        }
      }

      const mapStateProps = (state)=>{
        return {num:state}
      }
      const actionCreators = {addGunAsync,addGun,removeGun}
      //装饰器设计模式 装饰返回新的组件了

      App = connect(mapStateProps,actionCreators)(App) //Connect负责从外部获取组件需要的参数
      export default App
    ======================================================================================
    App.js文件:
      import React from 'react'
      import { connect } from 'react-redux'
      import {addGunAsync,addGun,removeGun} from './index.redux'


      // const mapStateProps = (state)=>{
      //  return {num:state}
      // }
      //const actionCreators = {addGunAsync,addGun,removeGun}

      //App = connect(mapStateProps,actionCreators)(App)
      @connect(//Connect可以用装饰器的方式来写
        //你要什么属性放到props里面
        state=>({num:state}),
        //你要什么方法,放到props里,会自动dispatch
        {addGunAsync,addGun,removeGun}
      ) 
      class App extends React.Component{
        render(){
          return (
            <div>
              <h1>现在有机枪{this.props.num}把</h1>
              <button onClick={this.props.addGun}>申请武器</button>
              <button onClick={this.props.removeGun}>上缴武器</button>
              <button onClick={this.props.addGunAsync}>托两天再给</button>
            </div>
          )
        }
      }

      export default App


## React-router4

    React开发单页面应用必备,践行路由组件的概念
    核心概念:动态路由,Route，Link，Switch

    安装 npm install react-router-dom --save
    Router4使用react-router-dom作为流浪器的路由
    忘记Router2的内容,拥抱最新的Router4

    入门组件
      BrowserRouter，包裹整个应用
      Router路由对应渲染组件,可嵌套 
      Link跳转专用

    其他组件
      url参数,Router组件的参数可用冒号标识参数
        this.props里面有三个属性
          history 这个是历史属性
            当需要js进行跳转页面是使用this.props.history.push('/')
            如果想要返回上一页使用 this.props.history.goBack()
          location 包含当前页面信息的属性
            比如pathname "/qibinglian" 
          match 根路由的后面的参数有关 比如 是不是完全匹配 
            path: "/:location" 原始定义的变量 比如一个里表的行的id 是我们定义的路由
            params: 现在的location变量值
              location:"qibinglian" 
            url:"/qibinglian" 当前页面访问实际的连接地址 实际的路由
      Redirect组件 跳转
      Switch只渲染第一个命中子Route组件
      withRouter组件来包裹一个普通的组件使得普通组件属性具有history等属性
        如果这个组件是react-router4子节点组件不需要加这个

    react-router与redux组合
      复杂redux应用,多个reducer，用combineReducers合并


## React-router4 代码

    index.js文件:
      import React from 'react'
      import ReactDom from 'react-dom'
      import App from './App'
      import { createStore, applyMiddleware, compose } from 'redux'
      import thunk from 'redux-thunk'
      import { counter } from './index.redux'
      import { Provider } from 'react-redux'
      import { BrowserRouter, Route, Link } from 'react-router-dom'

      const reduxDevtools = window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()

      const store = createStore(counter,compose(
        applyMiddleware(thunk),
        reduxDevtools
      ))

      function Erying(){
        return <h2>二营</h2>
      }

      function Qibinglian(){
        return <h2>骑兵连</h2>
      }

      ReactDom.render(
        (<Provider store={store}>
          <BrowserRouter>
            <ul>
              <li>
                <Link to='/'>一营</Link> //点击跳转到指定路由
              </li>
              <li>
                <Link to='/erying'>二营</Link>
              </li>
              <li>
                <Link to='/qibinglian'>骑兵连</Link>
              </li>
            </ul>
            <Route path='/' exact component={App}></Route> //exact表明完全匹配
            <Route path='/erying' component={Erying}></Route>
            <Route path='/qibinglian' component={Qibinglian}></Route> //路由对应渲染的模板
          </BrowserRouter>
        </Provider>),
        document.getElementById('root')
      )
    =====================================================================================
    1.index.redux.js文件
      const ADD_GUN = '加机关枪'
      const REMOVE_GUN = '减机关枪'

      export function counter(state=0,action){
        switch(action.type){
          case ADD_GUN:
            return state + 1
          case REMOVE_GUN:
            return state-1
          default:
            return state
        }
      }

      export function addGun(){
        return {type:ADD_GUN}
      }

      export function removeGun(){
        return {type:REMOVE_GUN}
      }

      export function addGunAsync(){
        return dispatch=>{
          setTimeout(()=>{
            dispatch(addGun())
          },2000)
        }
      }

    2.Auth.redux.js文件
      const LOGIN = 'LOGIN'
      const LOGOUT = 'LOGOUT'

      export function auth(state={isAuth:false,user:'李云龙'},action){
          switch(action.type){
              case LOGIN:
                  return {...state, isAuth:true}
              case LOGOUT:
                  return {...state, isAuth:false}
              default:
                  return state
          }
      }

      export function login(){
          return {type:LOGIN}
      }

      export function logout(){
          return {type:LOGOUT}
      }


    3.reducer.js文件
      //合并所有的reducer 并且返回
      import { combineReducers } from 'redux'
      import { counter } from './index.redux'
      import { auth } from './Auth.redux'


      export default combineReducers({counter, auth})

    4.index.js文件:
      import React from 'react'
      import ReactDom from 'react-dom'
      import { createStore, applyMiddleware, compose } from 'redux'
      import thunk from 'redux-thunk'
      import { Provider } from 'react-redux'
      import { BrowserRouter, Route, Switch, Redirect } from 'react-router-dom'
      import Auth from './Auth.js'
      import Dashboard from './Dashboard.js'
      import reducers from './reducer' 

      const reduxDevtools = window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()

      const store = createStore(reducers, compose(
        applyMiddleware(thunk),
        reduxDevtools
      ))

      ReactDom.render(
        (<Provider store={store}>
          <BrowserRouter>
            <Switch>
              <Route path="/login" component={Auth}></Route>
              <Route path="/dashboard" component={Dashboard}></Route>
              <Redirect to="/dashboard"></Redirect>
            </Switch>
          </BrowserRouter>
        </Provider>),
        document.getElementById('root')
      )

    5.Auth.js文件:
      import React from 'react'
      import { connect } from 'react-redux'
      import { login } from './Auth.redux' 
      import { Redirect } from 'react-router-dom'

      @connect(
          state=>state.auth,
          {login}
      )
      class Auth extends React.Component{
          render(){
              return (
                  <div>
                      { this.props.isAuth? <Redirect to='/dashboard'></Redirect> : null}
                      <h2>你没有权限,需要登陆才能看</h2>
                      <button onClick={this.props.login}>登陆</button>
                  </div>
              )
          }
      }

      export default Auth

    6.Dashboard.js文件：
      import React from 'react'
      import { Link, Route, Redirect } from 'react-router-dom'
      import App from './App.js'
      import { connect } from 'react-redux'
      import { logout } from './Auth.redux'

      function Erying(){
        return <h2>二营</h2>
      }

      function Qibinglian(){
        return <h2>骑兵连</h2>
      }

      @connect(
          state=>state.auth,
          {logout}
      )
      class Dashboard extends React.Component{
          render(){
              const redirectToLogin = <Redirect to='/login'></Redirect> 
              const app = (<div>
                  <h1>独立团</h1>
                  { this.props.isAuth ? <button onClick={this.props.logout}>注销</button> : null}
                  <ul>
                      <li>
                          <Link to={`${this.props.match.url}`}>一营</Link>
                      <li>
                          <Link to={`${this.props.match.url}/erying`}>二营</Link>
                      </li>
                      <li>
                          <Link to={`${this.props.match.url}/qibinglian`}>骑兵连</Link>
                      </li>
                  </ul>
                  <Route path={`${this.props.match.url}/`} exact component={App}></Route>
                  <Route path={`${this.props.match.url}/erying`} component={Erying}></Route>
                  <Route path={`${this.props.match.url}/qibinglian`} component={Qibinglian}></Route>
              </div>)
              return this.props.isAuth?app:redirectToLogin 
          }
      }

      export default Dashboard

## 前后台联调
    如何发送,端口不一致,使用proxy配置转发
    axios拦截器,统一loading处理
    redux里使用异步数据,渲染页面


    ajax请求是使用axios
      npm install axios --save
    在package.json文件中,加入
      "proxy":"http://localhost:9003"
      转发解决跨域问题
    axios.interceptors设置拦截器,比如全局的loading

## 前后台联调代码

    config.js文件下
      import axios from 'axios'
      import { Toast } from 'antd-mobile'

      axios.interceptors.request.use(function(config){
          Toast.loading('加载中', 0)
          return config
      })

      axios.interceptors.response.use(function(config){
          setTimeout(()=>{
              Toast.hide()
          }, 1000)
          return config
      })

    index.js文件下
      import React from 'react'
      import ReactDom from 'react-dom'
      import { createStore, applyMiddleware, compose } from 'redux'
      import thunk from 'redux-thunk'
      import { Provider } from 'react-redux'
      import { BrowserRouter, Route, Switch, Redirect } from 'react-router-dom'
      import Auth from './Auth.js'
      import Dashboard from './Dashboard.js'
      import reducers from './reducer' 
      import './config'

      const reduxDevtools = window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()

      const store = createStore(reducers, compose(
        applyMiddleware(thunk),
        reduxDevtools
      ))

      ReactDom.render(
        (<Provider store={store}>
          <BrowserRouter>
            <Switch>
              <Route path="/login" component={Auth}></Route>
              <Route path="/dashboard" component={Dashboard}></Route>
              <Redirect to="/dashboard"></Redirect>
            </Switch>
          </BrowserRouter>
        </Provider>),
        document.getElementById('root')
      )

    Auth.redux.js文件下:
      import axios from "axios";

      const LOGIN = 'LOGIN'
      const LOGOUT = 'LOGOUT'
      const USER_DATA = 'USER_DATA'

      const initState = {
        age: 20,
        isAuth: false,
        user: '李云龙'
      }

      export function auth(state=initState,action){
          switch(action.type){
              case LOGIN:
                  return {...state, isAuth:true}
              case LOGOUT:
                  return {...state, isAuth:false}
              case USER_DATA:
                  return {...state, user:action.payload.user, age:action.payload.age}
              default:
                  return state
          }
      }

      export function getUserData(){
          return dispatch=>{
              axios.get('/data').then(res=>{
                  if(res.status === 200){
                      dispatch(userData(res.data))
                  }
              })
          }
      }

      export function userData(data){
          return {type:USER_DATA,payload:data}
      }

      export function login(){
          return {type:LOGIN}
      }

      export function logout(){
          return {type:LOGOUT}
      }

    Auth.js文件
      import React from 'react'
      import { connect } from 'react-redux'
      import { login, getUserData } from './Auth.redux' 
      import { Redirect } from 'react-router-dom'
      // import axios from 'axios'

      @connect(
          state=>state.auth,
          {login, getUserData}
      )
      class Auth extends React.Component{
          // constructor(props){
          //     super(props)
          //     this.state = {
          //         data:{}
          //     }
          // }
          componentDidMount(){
              this.props.getUserData()
              // axios.get('/data').then(res=>{
              //     if(res.status === 200){
              //         this.setState({data:res.data})
              //     }
              // })
          }
          render(){
              return (
                  <div>
                      <h2>我的名字是{this.props.user},年龄{this.props.age} </h2>
                      { this.props.isAuth? <Redirect to='/dashboard'></Redirect> : null}
                      <h2>你没有权限,需要登陆才能看</h2>
                      <button onClick={this.props.login}>登陆</button>
                  </div>
              )
          }
      }

      export default Auth


## 开发模式

    基于cookie用户验证
      express依赖cookie-parser，需要 npm install cookie-parser --save 安装
      body-parser插件来管理接收post数据
        安装 npm install body-parser --save
      
    页面cookie的管理流浪器会自动处理
        npm install cookieparser  --save

    md5加密
        npm install utility --save

    子组建如何改变父组建的state,父组建将方法(方法内部改变父组建的state)传给子组建 子组件调用该方法
        子组件对外暴露了一个属性 如果传入的不是一个方法 那么这是有问题的 
        react给我们提供了prop-types来判断传入的属性类型
          安装 npm install prop-types --save
          使用
            import PropTypes from 'prop-types'
            class AvatarSelector extends React.Component{
              static propTypes = {
                  selectAvatar: PropTypes.func.isRequired
              }
              constructor(props){
                  super(props)
                  this.state = {}
              }
              ......
            }
        
    客户端操作cookie
      npm install browser-cookies --save


## 高阶组建

      1.函数编程
        函数可以当参数
        函数可以当返回值
          function() hello(){
            console.log('react') 
          }
          function WrapperHello(fn){ //传递的是一个函数，返回另外一个函数 装饰器模式
            return function(){
              console.log('before')
              fn()
              console.log('after')  
            }
          }
          hello=WrapperHello(hello)
          hello()
          其实组建本质上是一个函数 传递一个组建返回另一个组建
      
      2.传递一个组建返回一个新的组建
        class Hello extends React.Componet{
          render(){
            return <h2>react</h2>
          }
        }
        function WrapperHello(Component){
          class WrapperComponent extends React.Component{
            render(){
              return (
                <div>
                  <p>这是高洁组建</p>
                  <Component {...this.props}></Component>
                </div>
              )
            }
          }
          return WrapperComponent
        }
        Hello = WrapperHello(Hello)
      
      3.2的简写形式类似于@connect
        function WrapperHello(Component){ //把这个看成是从外部引入进来的
          class WrapperComponent extends React.Component{
            render(){
              return (
                <div>
                  <p>这是高洁组建</p>
                  <Component name='text' {...this.props}></Component> //我们可以加些属性 属性代理
                </div>
              )
            }
          }
          return WrapperComponent
        }

        @WrapperHello
        class Hello extends React.Componet{
          render(){
            return <h2>react</h2>
          }
        }
        以上这个模式叫属性代理

      4.还有一种叫反向继承
        不继承React的,而是继承传入的组建 改写他的生命周期 改写他的渲染的流程
        function WrapperHello(Comp){
          class WrapperComponent extends Comp{
            componentDidMount(){
              console.log('高洁新增的生命周期,加载完成')
            }
            render(){
              return <Comp></Comp>
            }
          }
          return WrapperComponent
        }


## socket.io

      基于事件的实施双向通信库
        基于websocket
        前后段通过事件进行双向通信
        配合express，快速开放实施应用
          npm install socket.io --save
          io = require('socket.io')(http)
          io.on监听事件
          io.emit触发事件
        前段api
          npm install socket.io-client --save
          import io from 'socket.io-client'
            io.on监听事件
            io.emit触发事件
        
      Ajax和Socket.io的区别
        Ajax基于http协议,单项,实时获取数据只能轮询
        socket.io基于websocket双向通信协议,后端可以主动推送数据
        现代浏览器均支持websocket协议


# emoji表情
    https://emojipedia.org

# react进阶

  jquery
    $('#test').find('img') //性能好一些的
    $('#test img')
  react原理
    虚拟Dom
      比较前后节点,只需要改变变化的节点
    生命周期
      shouldCompoentUpdate(nextProps, nextState)
      如果返回true,才渲染,返回false不会渲染,这是很重要的一个特性
    setState
  redux原理
    手写redux
      export function createStore(reducer, enhancer){
        if(enhancer){
          return enhancer(createStore)(reducer)
        }
        let currentState = {}
        let currentListeners = []

        function getState(){
          return currentState
        }
        function subscribe(listener){
          currentListeners.push(listener)
        }
        function dispatch(action){
          currentState = reducer(currentState, )
        }
        dispatch({type:'@ZLER/ZLER-REDUX'})
        return { getState, subscribe, dispatch }
      }

      function bindActionCreator(creator, dispatch){
        return (...args) => dispatch(creator(...args))
      }

      //{addGun removeGun addGunAsync}
      export function bindActionCreators(creators, dispatch){
        let bound = {}
        Object.keys(creators).forEach(v=>{
          let cretor = creators[v]
          bound[v] = bindActionCreator(creator, dispatch)
        })
        return bound

        //简写形式return Object.keys(creators).reduce((ret,item)=>{
          ret[item] = bindActionCreator(creators[item], dispatch)
          return ret
        },{})
      }

      //加入中间件的函数
      export function applyMiddleware(...middlewares){
        return createStore=>(...args)=>{
          const store = createStore(...args)
          let dispatch = store.dispatch

          const midApi = {
            getState:store.getState,
            dispatch:(...args)=>dispatch(...args)
          }
          const middlewareChain = middlewares.map(middleware=>middleware(midApi))
          dispatch = compose(...middlewareChain)(store.dispacth)
          //dispatch = middleware(midApi)(store.dispatch)
          //middleware(midApi)(store.dispatch)(action)
          return {
            ...store,
            dispatch
          }
        }
      }

      export function compose(...funcs){
        if(funcs.length===0){
          return arg=>arg
        }
        if(funcs.length===1){
          return funcs[0]
        }
        return funcs.reduce((ret,item)=>(...args)=>ret(item(...args))) //fn1(fn2(fn3))
      }
    使用全局的context属性传递
      使用this.props一级一级的往向传,很不好
      context是全局的,组件里声明,所有子元素都可以直接获取
      使用context属性是必须要校验的
        安装npm install prop-types --save
      
      class Fu extends React.Component{
        static childContextTypes = {
          user:PropTypes.string
        }
        constructor(props){
          super(props)
          this.state = {user:'蜗牛'}
        }
        getChildContext(){ //让所有子组件都能使用context
          return this.state
        }
        render(){
          return (
            <div>
              <p>我是{this.state.user}</p>
              <Zi></Zi>
            </div>
          )
        }
      }

      class Zi extends React.Conmponent{
        static contextTypes = {
          user:PropTypes.string
        }
        render(){
          return (
            <div>
              我的名字叫{this.context.user}
            </div>
          )
        }
      }
        
    手写react-redux
      //connect负责链接组件,给到redux里面的数据放到组件的属性里面
      //1.负责接受一个组件,把state里的一些数据放进去,返回一个组件
      //2.数据变化的时候,能够通知组件
      export function connect(mapStateToProps, mapDispatchToProps){
        return function(WrapComponent){
          return class ConnectComponent extends React.Component{

          }
        }
      }
      //两层箭头写法
      export const connect = (mapStateToProps=state=>state, mapDispatchToProps={})=>(WrapComponent)=>{
        return class ConnectComponent extends React.Component{
            static contextTypes = {
              store:PropTypes.object
            }
            constructor(props, context){
              super(props, context)
              this.state = {
                props:{}
              }
            }
            componentDidMount(){
              const {store} = this.context
              store.subscribe(()=>this.update())
              this.update()
            }
            update(){
              //获取mapStateToProps和mapDispatchToProps 放入this.props里
              const {store} = this.context
              const stateProps = mapStateToProps(store.getState())
              const dispatchProps = bindActionCreators(mapDispatchToProps, store.dispatch)
              this.setState({
                props:{
                  ...this.state.props,
                  ...stateProps,
                  ...dispatchProps
                }
              })
            }
            render(){
              return <WrapComponent {...this.state.props} />
            }
        }
      }

      //Provider,把store放到context里,所有的子元素可以直接取到store
      export Provider extends React.Component{
        static childContextTypes = {
          store: PropTypes.object
        }
        constructor(props, context){
          super(props, context)
          this.store = props.store
        }
        getChildContext(){ //让所有子组件都能使用context
          return {store:this.store}
        }
        render(){
          return this.props.children //获取当前组件的子组件
        }
      }
      
    手写一个thunk中间件
      const thunk = ({dispatch,getState})=>next=>action=>{
        if(typeof action === 'function'){//如果是函数,执行一下,参数是dispatch， getState
          return action(dispatch, getState)
        }
        //默认是对象
        return next(action)
      }
      export default thunk

      手写一个arrayThunk中间件
        const arrayThunk = ({dispatch,getState})=>next=>action=>{
          if(Array.isArray(action)){
            return action.forEach(v=>dispatch(v))
          }
          //默认是对象
          return next(action)
        }
        export default arrayThunk

  自己写的迷你版本的总结
    redux: createStore bindActionCreators applyMiddleware compose
    react-redux: Provider connect
    react-thunk: thunk arrayThunk


# 代码优化和进阶

  react组件性能优化
    单个组件属性传递优化
      1.不要在组件上面加入对象，因为每一次都会生成新的对象传递，最好放在构造方法里面的this或者this.state,this.state不要展开到组件上
      2.函数绑定要写在构造方法里面,或者使用箭头函数,构造函数只会执行一次
    多组件优化
      react性能检测 localhost:3000/?react_perf
      父组件更新时每次都会触发render函数,而子组件由于写在了render里面,导致不必要的子组件也执行了一片，非常的不好
      可以在react的生命周期函数shouleComponentUpdate将需要更新的进行更新,那些不需要更新的就不要更新
      shouleComponentUpdate(nextProps, nextState){
        for(let key in nextProps){ //循环的对比
          if(this.props.title === nextProps.title){
            return false
          }
        }
        if(this.props.title === nextProps.title){
          return false
        }
        return true
      }
      //手写不合适,使用PureComponent(纯净的组件)
      class Demo extends PureComponent{

      }
      递归对比和循环对比都是很消耗资源的,react建议只做浅对比和浅拷贝，无论怎么使用比较都是不好的
      immutable-js存在的意义和使用
        不可变的数据结构
        npm install immutable --save
        用hash值进行比较
        class Demo extends PureComponent{
          constructor(props){
            this.state = Map({
              num:1
            })
          }
          setNum(){
            this.setState(this.state.set("num",this.state.get('num')+1))
          }
          shouleComponentUpdate(nextProps, nextState){
            if(is(nextProps, this.props)){
              return false
            }
            return true
          }
          render(
            return (
              <div>{this.state.get('num')}</div>
            )
          )
        }
        优点:
          1.减少内存使用 
          2.并发安全 
          3.降低项目复杂度 
          4.便于比较复杂数据,定制shouleComponentUpdate方便
          5.时间旅行功能方便
          6.函数式编成
        缺点:
          1.学习成本
          2.库的大小 seamless-immutable.js
          3.对现有的项目入侵太严重
            新项目使用,老项目不使用
    key
      加和不加性能差别很大的
      const users = ['hello', 'world', '!!!']
      <ul>{this.users.map(v=><li key={v}>{v}</li>)}</ul>
  redux性能优化
    我们的数据从redux里面获取,有些数据是要进行过滤调,但是自己写了很多代码和逻辑这个很不好的
    使用reselect选择器库，将过滤逻辑写在这个选择器里面使得代码更加的好维护
    import {createSelector} from 'reselect'
    //采用了备忘录的设计模式
    const numSelector = createSelector(
      state=>state,
      //第二个参数是第一个参数的返回值
      num=>({num:num*2}) 
    )
    @connect(
      state=>numSelector(state)
    )
    class App extends React.Component{+

    }
  React服务端渲染SSR
    传统服务端渲染，JSP,twig,jinja2等 
      前后端一体
      浏后端模板+数据=》html给浏览器
      首屏快,每次获取数据都会刷新页面
    浏览器渲染 ajax拼接html
      后端只提供静态资源和接口
      前段写模板,渲染,MVVM
      单页应用,页面跳转也不刷新,体验好，首屏慢,SEO
    前后同构,首屏服务端渲染
      node在服务端解析首屏模板
      React支持SSR
    React同构的Api
      后RenderToString和RenderToStaticMarkup
      React16新出的RenderToNodeStream,性能更好
      React16里,客户端hydrate取代render
    SSR，build代码后的事情
      后node使用babel-node配置node里的react环境
      修改客户端代码,抽离App组件,前后端共享
      服务端生成DMO结构,渲染,加载build后的css和js


# 整体

  eslint代码规范
    在package.json里面自定义自己的代码规范
    "eslintConfig": {
      "extends": "react-app"，
      "rules":{
        "eqeqeq":["off"],
        "jsx-ally/accessible-emoji":[0],
         "semi":["warn","never"]
      }  
    }
