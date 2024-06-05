<?php

namespace Deployer;

require 'recipe/common.php';

// Config

set('git_tty', true);
set('git_ssh_command', 'ssh'); // Fix unsupported option "accept-new" (OpenSSH version older than v7.6)

set('repository', 'git@github.com:mgkprod/sb-chest-helper');

// Hosts

host('o2switch')
    ->set('remote_user', 'mgkprod')
    ->set('deploy_path', '~/sb-chest-helper.mgk.dev')
    ->setLabels(['env' => 'production']);

// Tasks

task('npm:ci', function () {
    cd('{{release_path}}');
    run('npm ci');
});

task('npm:build', function () {
    cd('{{release_path}}');
    run('npm run build');
});

// Hooks

after('deploy:writable', 'npm:ci');
after('npm:ci', 'npm:build');
after('deploy:failed', 'deploy:unlock');
