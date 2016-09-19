<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;


class OrderRepositoryFacade extends  Facade
{


    protected static function getFacadeAccessor() { return 'OrderRepository'; }

}
