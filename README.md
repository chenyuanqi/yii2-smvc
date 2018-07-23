
# yii2-smvc
yii2 service & mvc template.

### requirement
- Nginx 1.8+
- PHP 5.4+
- Mysql 5.6+
- Redis 3.0+

### structure
-- api (example program)  
-- commands  
&nbsp;&nbsp;&nbsp;&nbsp;-- controllers (define your command)  
-- common  
&nbsp;&nbsp;&nbsp;&nbsp;-- assets (common assets)  
&nbsp;&nbsp;&nbsp;&nbsp;-- base (base class)  
&nbsp;&nbsp;&nbsp;&nbsp;-- components (common components)  
&nbsp;&nbsp;&nbsp;&nbsp;-- datas (common datas)  
&nbsp;&nbsp;&nbsp;&nbsp;-- helpers (common helpers class)  
&nbsp;&nbsp;&nbsp;&nbsp;-- migrations (common migrations script)  
&nbsp;&nbsp;&nbsp;&nbsp;-- models (common models)  
&nbsp;&nbsp;&nbsp;&nbsp;-- services (common services logic)  
&nbsp;&nbsp;&nbsp;&nbsp;-- traits (common traits)  
&nbsp;&nbsp;&nbsp;&nbsp;-- views (common h5 views and some template)  
&nbsp;&nbsp;&nbsp;&nbsp;-- widgets (common widgets)  
&nbsp;&nbsp;&nbsp;&nbsp;-- workers (common queue workers)  
-- config (global config)  
-- route (route rule)  
-- tests (unit test case)  
-- runtime (live with cache and logger)  

### preparation 
```bash
# download repertory
git clone https://github.com/chenyuanqi/yii2-smvc.git
cd yii2-smvc
# install dependent
composer install
# setting
cp .env.example .env
vim .env
```

### others
- migrate example
```bash
./yii migrate/create create_tests_table -p=common/migrations
./yii migrate/up -p=common/migrations/
```

- supervisorctl manage queue
```bash
sudo supervisorctl -c /etc/supervisord.conf status
sudo supervisorctl -c /etc/supervisord.conf stop cube-queue
sudo supervisorctl -c /etc/supervisord.conf start cube-queue
./yii queue cube_queue 1 15000
```
