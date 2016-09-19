<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;


class ActivityRepositoryFacade extends  Facade
{


    protected static function getFacadeAccessor() { return 'ActivityRepository'; }

}
