# git-stu
git small text

## Git 全局设置:
```
	git config --global user.name "symfony"
	git config --global user.email "symfony@qq.com"
```
## 生成私有和公钥
ssh-keygen -t rsa -C “symfony@qq.com”
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
git merge 合并分支

git clone git@116.62.48.176:/data/git/Project-GTMT-20181106.git
```

 ## 忽略文件
创建.gitignore
```
	build/
	out/
	.idea/
	/.gitignore
```
