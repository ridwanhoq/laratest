Hey,

If you are curious to know how to install horizon and how to use in on Laravel local application, this post may help you figure it out.

What is Horizon?
According to the documentation:

Horizon provides a beautiful dashboard and code-driven configuration for your Laravel powered Redis queues. Horizon allows you to easily monitor key metrics of your queue system such as job throughput, runtime, and job failures.

All of your worker configurations is stored in a single, simple configuration file, allowing your configuration to stay in source control where your entire team can collaborate.

How to install?
Run composer require laravel/horizon on your project terminal.

Note: Please keep in mind that, horizon can't run as a standalone project. You have to install in on any laravel project.

After installing the horizon package, next-

php artisan horizon:install
It will install the horizon on your project. Now you can able to see the list of the horizon commands on php artisan.

Now, you need to install Redis. To install Redis, run the following command-

composer require predis/predisd
Setting up DB
To setting up Database and environment file, you need to set up the following section in the .env file-

# DB Section
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=databasename
DB_USERNAME=root
DB_PASSWORD=

# Session section 
QUEUE_CONNECTION=redis
REDIS_CLIENT=predis
How to access the horizon?
Once done installing, you can able to access the horizon on /horizon suffix. Imagine that, your project URL is http://project.local then if you want to access horizon, then URL will be http://project.local/horizon .

Configure Horizon
For some reason, maybe you need to change the default behaviour of horizon, for example, default URL of accessing it. To do such kinds of activities, you need to go to config/horizon.php file, where you can change-


    // Define your subdomain here for accessing horizon
    'domain' => null,

    // Define your path how you want to access the horizon
    'path' => 'horizon',

    // Set redis connection here
    'use' => 'default',

    // Set prefix for horizon
    'prefix' => env(
        'HORIZON_PREFIX',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_horizon:'
    ),

    // Define route middleware for horizon.
    'middleware' => ['web'],

    // Set Queue Waiting Time
    'waits' => [
        'redis:default' => 60,
    ],

    // Set job trimmingtime
    'trim' => [
        'recent' => 60,
        'pending' => 60,
        'completed' => 60,
        'recent_failed' => 10080,
        'failed' => 10080,
        'monitored' => 10080,
    ],

    // Set job metrics
    'metrics' => [
        'trim_snapshots' => [
            'job' => 24,
            'queue' => 24,
        ],
    ],

    // Set termination 
    'fast_termination' => false,

    // Set memory limit
    'memory_limit' => 64,

    // Configure queue worker
    'defaults' => [
        'supervisor-1' => [
            'connection' => 'redis',
            'queue' => ['default'],
            'balance' => 'auto',
            'maxProcesses' => 1,
            'tries' => 1,
            'nice' => 0,
        ],
    ],

    'environments' => [
        'production' => [
            'supervisor-1' => [
                'maxProcesses' => 10,
                'balanceMaxShift' => 1,
                'balanceCooldown' => 3,
            ],
        ],

        'local' => [
            'supervisor-1' => [
                'maxProcesses' => 3,
            ],
        ],
    ]
Based on your demand, you need to set up your configuration.

Check more: https://laravel.com/docs/8.x/horizon#configuration

How to run Horizon?
To run horizon, you just run-

php artisan horizon
Then you can able to see status of horizon in /horizon URL. It should be active now.

Even in the command line, you can able to see the current status by the following command also-

php artisan horizon:status
Check more: https://laravel.com/docs/8.x/horizon#running-horizon

Authorizing Dashboard
Once you have done everything successfully, now you can limit down accessing the horizon dashboard. Currently, anyone is able to access it.

To limit down the horizon accessibility, go to app/Providers/HorizonServiceProvider.php and find the gate() method. Now you add your email whoever you want to give access of it-

protected function gate()
{
    Gate::define('viewHorizon', function ($user) {
        return in_array($user->email, [
            'user1@example.com',
            'user2@example.com',
            // Add more and more
        ]);
    });
}
Once you push your application to the production or staging, the defined email address used is able to access the /horizon URL only, the rest of the world will able to see 403.