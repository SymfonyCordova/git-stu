# git-stu
git small text

## Git 全局设置:
```
	git config --global user.name "SymfonyCordova"
	git config --global user.email "978451251@qq.com"
```
## 生成私有和公钥
ssh-keygen -t rsa -C “978451251@qq.com”
## 查看生成的公钥和私钥
```
	linux
	cat ~/.ssh/id_rsa.pub
	windows
	C:\Users\symfony\.ssh
```

## 创建 git 仓库:
```
	mkdir flake 创建一个项目
	cd flake    打开这个项目
	git init     初始化
	touch README.md
	git add README.md     更新README文件
	git commit -m "first commit" 提交更新，并注释信息“first commit” 
	git remote add origin https://gitee.com/user/flake.git //连接远程github项目 
	git push -u origin master  //将本地项目更新到github项目上去
```
```
cd existing_git_repo
git remote add origin https://gitee.com/user/flake.git
git push -u origin master

git  remote  add  origin  git@gitee.com:HotNewsTerm/www.carsafe.com.git


git clone -b publish git@116.62.48.176:/data/git/Project-carsafe-201805.git 指定那个分支下载
git branch 创建和查看分支
git checkout 切换分支 
git checkout -b 自此分支新建分支
git push origin 分支名字
git merge 合并分支

git clone git@116.62.48.176:/data/git/Project-GTMT-20181106.git

使用ssh协议url
	git remote set-url origin git@github.com:SymfonyCordova/git-stu.git

git stash 储存
```

 ## 忽略文件
创建.gitignore
```
	build/
	out/
	.idea/
	/.gitignore
	
```

## git 会退到某个版本
```
	git log
	git reset --soft 932343345464564006e
	或者 git reset --hard 932343345464564006e
	查看当前的分支
		git rev-parse HEAD
	git push -f 提交回退的版本

	git reset HEAD <文件>... 以取消暂存
```

## git 放弃本地修改 强制更新
```
	git fetch --all
	git reset --hard origin/master
```

## 代码提交过程
```
	从master切换到开发分支
	git merge origin master 拉取远程仓库最新的代码
	git add . 追踪文件的变化
	git commit -am '备注信息', 将代码提交到本地仓库
	git push 本地仓库代码推送到远程仓库
	提交pull request 管理员审核

	细节
		git status 文件变化
		git diff 文件具体的变化

		git checkout -b 自此分支新建分支
		git branch

		git add .
		git commit -am '注释'
		git push --set....

		pull reques 提交给管理人员
```