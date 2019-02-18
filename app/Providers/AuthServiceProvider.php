<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Entity' => 'App\Policies\EntityPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\BasePackage' => 'App\Policies\BasePackagePolicy',
        'App\Models\Student' => 'App\Policies\StudentPolicy',
        'App\Models\Teacher' => 'App\Policies\TeacherPolicy',
        'App\Models\EntityPackage' => 'App\Policies\EntityPackagePolicy',
        // 'App\Models\Teacher' => 'App\Policies\TeacherPolicy',
        // 'App\Models\Teacher' => 'App\Policies\TeacherPolicy',
        // 'App\Models\Teacher' => 'App\Policies\TeacherPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
