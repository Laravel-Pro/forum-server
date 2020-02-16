# Laravel Pro Server


### 开始开发

#### 安装

```
composer install

composer run-script post-root-package-install

composer run-script post-create-project-cmd
```

确认 `.env` 文件中的数据库配置正确

#### 初始化数据库

```
php artisan migrate
```

#### 运行测试

```
# 运行所有
vendor/bin/phpunit

# 运行单元测试
vendor/bin/phpunit --testsuite Unit

# 运行功能测试
vendor/bin/phpunit --testsuite Feature

# 运行特定测试
vendor/bin/phpunit --filter the_test_class_or_method_name
```

**提交代码后，系统会自动测试代码**
