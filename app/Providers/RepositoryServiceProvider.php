<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 *存储库服务提供程序，将接口与依赖注入的具体类绑定。
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * 注册申请服务
     */
    public function register()
    {
        $this->bindProduct();//绑定ProductRepository接口和类,使用门脸模式
        $this->bindUser();//绑定UserRepository接口和类,使用门脸模式
        $this->bindIndex();//绑定IndexRepository接口和类,使用门脸模式
        $this->bindOrder();//绑定OrderRepository接口和类,使用门脸模式
        $this->bindFunction();//绑定FunctionRepository接口和类,使用门脸模式
        $this->bindActivity();//绑定ActivityRepository接口和类,使用门脸模式
    }

    /**
     * 绑定储存库类和接口
     */
    public function bindProduct()
    {
        //绑定接口和类
        $this->app->bind(
            'App\Repositories\Interfaces\ProductRepositoryInterface',
            'App\Repositories\ProductRepository'
        );
        //加入门脸模式
        $this->app->singleton('ProductRepository', function () {
            return new \App\Repositories\ProductRepository;
        });
        //将类映射到别名
        $this->app->alias('ProductRepository', 'App\Repositories\ProductRepository');
    }

    public function bindUser()
    {
        //绑定接口和类
        $this->app->bind(
            'App\Repositories\Interfaces\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );
        //加入门脸模式
        $this->app->singleton('UserRepository', function () {
            return new \App\Repositories\UserRepository;
        });
        //将类映射到别名
        $this->app->alias('UserRepository', 'App\Repositories\UserRepository');
    }

    public function bindIndex()
    {
        //绑定接口和类
        $this->app->bind(
            'App\Repositories\Interfaces\IndexRepositoryInterface',
            'App\Repositories\IndexRepository'
        );
        //加入门脸模式
        $this->app->singleton('IndexRepository', function () {
            return new \App\Repositories\IndexRepository;
        });
        //将类映射到别名
        $this->app->alias('IndexRepository', 'App\Repositories\IndexRepository');
    }

    public function bindorder()
    {
        //绑定接口和类
        $this->app->bind(
            'App\Repositories\Interfaces\OrderRepositoryInterface',
            'App\Repositories\OrderRepository'
        );
        //加入门脸模式
        $this->app->singleton('OrderRepository', function () {
            return new \App\Repositories\OrderRepository;
        });
        //将类映射到别名
        $this->app->alias('OrderRepository', 'App\Repositories\OrderRepository');
    }

    public function bindFunction()
    {
        //绑定接口和类
        $this->app->bind(
            'App\Repositories\Interfaces\FunctionRepositoryInterface',
            'App\Repositories\FunctionRepository'
        );
        //加入门脸模式
        $this->app->singleton('FunctionRepository', function () {
            return new \App\Repositories\FunctionRepository;
        });
        //将类映射到别名
        $this->app->alias('FunctionRepository', 'App\Repositories\FunctionRepository');
    }
    public function bindActivity()
    {
        //绑定接口和类
        $this->app->bind(
            'App\Repositories\Interfaces\ActivityRepositoryInterface',
            'App\Repositories\ActivityRepository'
        );
        //加入门脸模式
        $this->app->singleton('ActivityRepository', function () {
            return new \App\Repositories\ActivityRepository;
        });
        //将类映射到别名
        $this->app->alias('ActivityRepository', 'App\Repositories\ActivityRepository');
    }

}
