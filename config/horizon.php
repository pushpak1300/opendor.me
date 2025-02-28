<?php

use Carbon\CarbonInterval;

return [

    'notifications' => [
        'sms' => env('HORIZON_NOTIFICATION_SMS'),
        'email' => env('HORIZON_NOTIFICATION_EMAIL'),
        'slack' => [
            'webhook' => env('HORIZON_NOTIFICATION_SLACK_WEBHOOK'),
            'channel' => env('HORIZON_NOTIFICATION_SLACK_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Horizon Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain where Horizon will be accessible from. If this
    | setting is null, Horizon will reside under the same domain as the
    | application. Otherwise, this value will serve as the subdomain.
    |
    */

    'domain' => env('HORIZON_DOMAIN', env('ADMIN_DOMAIN')),

    /*
    |--------------------------------------------------------------------------
    | Horizon Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Horizon will be accessible from. Feel free
    | to change this path to anything you like. Note that the URI will not
    | affect the paths of its internal API that aren't exposed to users.
    |
    */

    'path' => 'admin/horizon',

    /*
    |--------------------------------------------------------------------------
    | Horizon Redis Connection
    |--------------------------------------------------------------------------
    |
    | This is the name of the Redis connection where Horizon will store the
    | meta information required for it to function. It includes the list
    | of supervisors, failed jobs, job metrics, and other information.
    |
    */

    'use' => 'horizon',

    /*
    |--------------------------------------------------------------------------
    | Horizon Redis Prefix
    |--------------------------------------------------------------------------
    |
    | This prefix will be used when storing all Horizon data in Redis. You
    | may modify the prefix when you are running multiple installations
    | of Horizon on the same server so that they don't have problems.
    |
    */

    'prefix' => env(
        'HORIZON_PREFIX',
        'opendor_horizon:'
    ),

    /*
    |--------------------------------------------------------------------------
    | Horizon Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will get attached onto each Horizon route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */

    'middleware' => [
        'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Wait Time Thresholds
    |--------------------------------------------------------------------------
    |
    | This option allows you to configure when the LongWaitDetected event
    | will be fired. Every connection / queue combination may have its
    | own, unique threshold (in seconds) before this event is fired.
    |
    */

    'waits' => [
        'redis:default' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Job Trimming Times
    |--------------------------------------------------------------------------
    |
    | Here you can configure for how long (in minutes) you desire Horizon to
    | persist the recent and failed jobs. Typically, recent jobs are kept
    | for one hour while all failed jobs are stored for an entire week.
    |
    */

    'trim' => [
        'recent' => CarbonInterval::week()->totalMinutes,
        'pending' => CarbonInterval::day()->totalMinutes,
        'completed' => CarbonInterval::month()->totalMinutes,
        'recent_failed' => CarbonInterval::week()->totalMinutes,
        'failed' => CarbonInterval::month()->totalMinutes,
        'monitored' => CarbonInterval::month()->totalMinutes,
    ],

    /*
    |--------------------------------------------------------------------------
    | Metrics
    |--------------------------------------------------------------------------
    |
    | Here you can configure how many snapshots should be kept to display in
    | the metrics graph. This will get used in combination with Horizon's
    | `horizon:snapshot` schedule to define how long to retain metrics.
    |
    */

    'metrics' => [
        'trim_snapshots' => [
            'job' => CarbonInterval::week()->totalMinutes / 5,
            'queue' => CarbonInterval::week()->totalMinutes / 5,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Fast Termination
    |--------------------------------------------------------------------------
    |
    | When this option is enabled, Horizon's "terminate" command will not
    | wait on all of the workers to terminate unless the --wait option
    | is provided. Fast termination can shorten deployment delay by
    | allowing a new instance of Horizon to start while the last
    | instance will continue to terminate each of its workers.
    |
    */

    'fast_termination' => false,

    /*
    |--------------------------------------------------------------------------
    | Memory Limit (MB)
    |--------------------------------------------------------------------------
    |
    | This value describes the maximum amount of memory the Horizon master
    | supervisor may consume before it is terminated and restarted. For
    | configuring these limits on your workers, see the next section.
    |
    */

    'memory_limit' => 128,

    /*
    |--------------------------------------------------------------------------
    | Queue Worker Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define the queue worker settings used by your application
    | in all environments. These supervisors and settings handle all your
    | queued jobs and will be provisioned by Horizon during deployment.
    |
    */

    'defaults' => [
//        'low-priority' => [
//            'connection' => 'redis',
//            'queue' => [
//                'low',
//            ],
//            'balance' => 'auto',
//            'maxProcesses' => 2,
//            'memory' => 128,
//            'tries' => 1,
//            'nice' => 0,
//        ],
//        'medium-priority' => [
//            'connection' => 'redis',
//            'queue' => [
//                'default',
//                'medium',
//            ],
//            'balance' => 'auto',
//            'maxProcesses' => 4,
//            'memory' => 128,
//            'tries' => 1,
//            'nice' => 0,
//        ],
//        'high-priority' => [
//            'connection' => 'redis',
//            'queue' => [
//                'high',
//            ],
//            'balance' => 'auto',
//            'maxProcesses' => 6,
//            'memory' => 128,
//            'tries' => 1,
//            'nice' => 0,
//        ],
//        'notifications' => [
//            'connection' => 'redis',
//            'queue' => 'notification',
//            'balance' => 'auto',
//            'maxProcesses' => 2,
//            'memory' => 128,
//            'tries' => 1,
//            'nice' => 0,
//        ],
        'github' => [
            'connection' => 'redis',
            'queue' => 'github',
            'balance' => 'auto',
            'maxProcesses' => 10,
            'memory' => 512,
            'tries' => 1,
            'nice' => 0,
            'timeout' => CarbonInterval::hours(6)->totalSeconds,
        ],
    ],

    'environments' => [
        env('APP_ENV') => [],
    ],
];
