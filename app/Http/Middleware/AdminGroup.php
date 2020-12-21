<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 管理員角色群組 
 * */
class AdminGroup
{

    private $group = ['Admin','Employee'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Resuest  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$driver = 'web')
    {   
        $roles = $request->user()->roles()->get();
        $from = $request->path();
        $result = false;
        foreach ($roles as $role){
            if(in_array($role->name,$this->group)){
                $result = true;
            }
        }

        if(!$result){
            if($driver == 'api'){
                return response('權限不足',400);
            }else{
                return redirect()->route('shop');
            }
            
        }

        return $next($request);
    }
}
