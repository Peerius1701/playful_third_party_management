<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'noAuth'                      =>\App\Filters\NoAuth::class,
        'auth'                        =>\App\Filters\Auth::class,
        'permissionProfile'           =>[\App\Filters\NoAuth::class,\App\Filters\PermissionProfile::class,],
        'permissionEmployee'          =>[\App\Filters\NoAuth::class,\App\Filters\PermissionEmployee::class,],
        'permissionManagement'        =>[\App\Filters\NoAuth::class,\App\Filters\PermissionManagement::class,],
        'permissionInvest'            =>[\App\Filters\NoAuth::class,\App\Filters\PermissionInvest::class,],
        'permissionBusinessTrip'      =>[\App\Filters\NoAuth::class,\App\Filters\PermissionBusinessTrip::class,],
        'permissionYoungScientist'    =>[\App\Filters\NoAuth::class,\App\Filters\PermissionYoungScientist::class,],
        'permissionStudentAssistant'  =>[\App\Filters\NoAuth::class,\App\Filters\PermissionStudentAssistant::class,],
        'permissionProject'           =>[\App\Filters\NoAuth::class,\App\Filters\PermissionProject::class,],
        'permissionPublication'       =>[\App\Filters\NoAuth::class,\App\Filters\PermissionPublication::class,],
        'permissionConferenceImpact'  =>[\App\Filters\NoAuth::class,\App\Filters\PermissionConferenceImpact::class,],
        'permissionJournalImpact'     =>[\App\Filters\NoAuth::class,\App\Filters\PermissionJournalImpact::class,],
        'permissionTeachingService'   =>[\App\Filters\NoAuth::class,\App\Filters\PermissionTeachingService::class,],
        'permissionThesis'            =>[\App\Filters\NoAuth::class,\App\Filters\PermissionThesis::class,],
        'permissionPandoForm'         =>[\App\Filters\NoAuth::class,\App\Filters\PermissionPandoForm::class,],
        'permissionFinanceType'       =>[\App\Filters\NoAuth::class,\App\Filters\PermissionFinanceType::class,],
        'permissionReportAccounts'           =>[\App\Filters\NoAuth::class,\App\Filters\PermissionReportAccounts::class,],
        'permissionReportProjectOverview'    =>[\App\Filters\NoAuth::class,\App\Filters\PermissionReportProjectOverview::class,],
        'permissionReportProject'            =>[\App\Filters\NoAuth::class,\App\Filters\PermissionReportProject::class,],
        'permissionReportBudgetOverview'     =>[\App\Filters\NoAuth::class,\App\Filters\PermissionReportBudgetOverview::class,],
        'permissionReportPando'              =>[\App\Filters\NoAuth::class,\App\Filters\PermissionReportPando::class,],
        'permissionReportEmployee'           =>[\App\Filters\NoAuth::class,\App\Filters\PermissionReportEmployee::class,],

    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
