OAuth协议简介
	OAuth协议要解决的问题
	OAuth协议中的各种角色
	OAuth协议运行流程
	
	目的是:
		用户将微信的(服务提供商的)用户名和密码不交给第三方应用的情况下,
		让第三方应用可以有权限访问用户存在微信(服务提供商)上的资源
	
OAuth授权模式
	授权码模式(authorization code)
	简化模式(implicit)
	密码授权模式(resource owner password credentials)
	客户端模式(client credentials)

UserConnection
	create table UserConnection(
		userId varchar(255) not null,
		providerId varchar(255) not null,
		providerUserId varchar(255),
		rank int not null,
		displayName varchar(255),
		profileUrl varchar(512),
		imgageUrl varchar(512),
		accessToken varchar(512) not null,
		secret varchar(512),
		refreshToken varchar(512),
		expireTime bigint,
		primary key (userId,providerId, providerUserId)
	);
	create unique index UserConnectionRank on UserConnection(userId,providerId,rank);