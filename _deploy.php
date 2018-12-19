<?php

namespace Deployer;

// All Deployer recipes are based on `recipe/common.php`.
// require 'recipe/common.php';
require 'recipe/common.php';

set('ssh_type', 'native');
set('ssh_multiplexing', true);

/**
 * Main task
 */
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:vendors',
    'deploy:shared',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');

after('deploy', 'success');

// Define a server for deployment.
// Let's name it "prod" and use port 22.
host('ams2.uecluster.com')
    ->user('root')
    // ->forwardAgent() // You can use identity key, ssh config, or username/password to auth on the server.
    ->stage('production')
    ->set('deploy_path', '/var/www/admin.uecluster.com'); // Define the base path to deploy your project to.

host('ams3.uecluster.com')
    ->user('root')
    // ->forwardAgent()
    ->stage('production')
    ->set('deploy_path', '/var/www/admin.uecluster.com');

// Specify the repository from which to download your project's code.
// The server needs to have git installed for this to work.
// If you're not using a forward agent, then the server has to be able to clone
// your project from this repository.
set('repository', 'git@bitbucket.org:uestudio/admin-uecluster.git');

set('shared_dirs', ['storage']);

set('shared_files', ['src/env.php']);

set('http_user', 'www-data');

set('composer_command', '/usr/local/bin/composer');

set('keep_releases', 2);

task('uploads:link', function () {
    run('ln -s /var/www/expobook.es/uploads/ {{release_path}}/public/uploads');
});

task('folder:permissions', function () {
    run('chown -R www-data:www-data /var/www/admin.uecluster.com');
});

task('reload:server', function () {
    run('service php7.0-fpm restart');
});

after('deploy', 'uploads:link');
after('deploy', 'folder:permissions');
after('deploy', 'reload:server');
after('rollback', 'uploads:link');
after('rollback', 'reload:server');
