执行 这个里面的 sql /Users/Simon/Projects/php/www/wuzhicms/coreframe/app/appupdate/fields/db1.sql

1. 创建release 分支(可选)

    ```[sh]
    git checkout -b release/3.0.1
    ```

2. 修改升级日志

    ```[php]
    /Users/Simon/Projects/php/www/wuzhicms/README.md

    增加升级日志内容

    ### V2.2.0 版本更新说明（2016-5-30）

    * 新增：模型数据录入前，和更新时调用钩子。方便二次扩展
    * 修复：搜索模版再次搜索后，无法继承模型
    * 修复：联动菜单修改时，无法选中
    * 修复：mysql get_one 方法 group by 顺序错误
    * 修复：模型修改bug
    * 修复：日期字段添加，字段类型选择无效
    * 优化：联动菜单字段，可以在一行显示
    * 改动：关键词搜索改为标题模糊搜索
    ```

3. 修改系统版本

    ```[php]
    /Users/Simon/Projects/php/www/wuzhicms/coreframe/core.php
    define('VERSION','3.0.0')-> define('VERSION','3.0.1')
    ```
4. 对比升级文件

    ```[sh]
     在bash提示符下输入：

     git config --global core.quotepath false

     ore.quotepath设为false的话，就不会对0×80以上的字符进行quote。中文显示正常。
    ```

    ```[sh]
      wuzhicms_v3 git:(master) git branch
      debug/2016062814
      feature/system-upgrade
      master
      pr/53
      pr/54
      release/2.1.7
      v2.1.7

    mkdir upgrade/build (if does not exist)
    git diff --name-status  release/3.0.0  release/3.0.1  > caches/upgrade/build/diff-3.0.1 (caches/upgrade/build 为web_config.php中的 BUILD_PATH 的路径)

    git diff --name-status  pr/13 master  > upgrade/build/diff-3.0.1  (if no release branch was  created)
    cat upgrade/build/diff-3.0.0  (view diff content)
    ```
5. 整理升级sql


6. 生成升级包

    ```[sh]
<<<<<<< HEAD
    php /bin/build.php MAIN 3.0.1 upgrade/build/diff-3.0.1
=======
    php bin/build.php MAIN 3.0.1 upgrade/build/diff-3.0.1
>>>>>>> master

    cd upgrade/build
    zip -r MAIN_3.0.1.zip MAIN_3.0.1
    ```

7. 上传升级包


8.  测试