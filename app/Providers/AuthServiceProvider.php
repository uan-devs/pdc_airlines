<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $permissoes = DB::table("permissoes")->get();
        foreach($permissoes as $permissao)
        {
            Gate::define(($permissao->nome),function(User $user) use($permissao){
            $allowed = DB::table("users")
                        ->join("papel_users","papel_users.id_user","=","users.id")
                        ->join("papeis","papeis.id","=","papel_users.id_papel")
                        ->join("papel_permissoes","papel_permissoes.id_papel","=","papeis.id")
                        ->join("permissoes","permissoes.id","=","papel_permissoes.id_permissao")
                        ->where("permissoes.nome","=",($permissao->nome))
                        ->select("users.id")->get();
            foreach($allowed as $allow)
            {
                if($allow->id == $user->id)return true;
            }
            return false;
            });

        }
        //
    }
}
