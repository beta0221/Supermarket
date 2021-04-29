<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

/**
 * 管理員角色群組 
 * */
class AdminGroup
{

    private $group = [
        User::ROLE_ADMIN,
        User::ROLE_EMPLOYEE,
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Resuest  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$driver = 'web')
    {   
        $user = $request->user();
        $result = $user->hasRoles($this->group);

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
