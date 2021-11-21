# Account.Ichi

## Preview
![preview.png](https://i.loli.net/2020/01/07/HEUlBt8zOowqAjW.png)

[http://account.ichi.proj.meonc.studio/signin](http://account.ichi.proj.meonc.studio/signin)   
Username: `test`  
Password: `test`  

## Wha-hh?
A general template of user account center. Okay, fine! It's just something I coded but got cut...   
It's halfway done(for now), just for reference.

## Inspiration
Visual design inspired by ***Microsoft***:  
- [login.live.com](https://login.live.com)
- [account.microsoft.com](https://account.microsoft.com)

## Components
- Spectre CSS
- Flight PHP Framework
- JQuery

## Configuration

### Requirement
- PHP 7.2 (must <PHP7.3)
- Support vhost rule and url rewrite
- MySQL

### Vhost (for Nginx)

Remember to set the root folder for visitors of your website to ***\public*** folder for **security reason**.
```
server {
        listen       80;
        server_name  account.ichi.io ;
        root   "path\to\folder\Account.Ichi\public";
        location / {
            index  index.html index.htm index.php;
            try_files  $uri /index.php;
        }
        location ~ \.php(.*)$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            fastcgi_param  PATH_INFO  $fastcgi_path_info;
            fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
            include        fastcgi_params;
        }
}
```

### Database

Create a file called ***config.ini*** under root folder and paste content below, then fill out.
```
[app]
debug=true

[database]
username=
password=
database=
host=localhost
```

Create data tables in your destination database:
```

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `nickname` text NOT NULL,
  `password` text NOT NULL,
  `qq` text NOT NULL,
  `email` text NOT NULL,
  `suspended` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: false, *: true',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `users_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `device_name` text NOT NULL,
  `device_ip` text NOT NULL,
  `os` text NOT NULL,
  `os_version` text NOT NULL,
  `browser` text NOT NULL,
  `browser_version` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `timezone` text NOT NULL,
  `country` text NOT NULL,
  `region` text NOT NULL,
  `city` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;


CREATE TABLE IF NOT EXISTS `users_subscription` (
  `uid` int(11) NOT NULL,
  `subscription_starts` date NOT NULL DEFAULT '2000-01-01',
  `subscription_ends` date NOT NULL DEFAULT '2000-01-01',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `users_subscription_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `sub_days` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
```
