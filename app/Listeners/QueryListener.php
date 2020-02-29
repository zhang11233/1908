<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\InteractsWithQueue;
use \Log;
class QueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  QueryExecuted  $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        //
//        echo ($event->sql);
//        echo "<br/>";//问号替换成%s
        $sql=str_replace("?","'%s'",$event->sql);
//        echo $sql;
//        echo "<br/>";//格式化sql语句
        $log=vsprintf($sql,$event->bindings);
//        echo $log;die;
        Log::info($log);
    }
}
