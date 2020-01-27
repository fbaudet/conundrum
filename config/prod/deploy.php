<?php

use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

return new class extends DefaultDeployer
{
    private $serverSshDns = 'ubuntu@167.114.237.255';
    private $deployDir = '/home/ubuntu/conundrum';

    public function configure()
    {
        return $this->getConfigBuilder()
            // SSH connection string to connect to the remote server (format: user@host-or-IP:port-number)
            ->server($this->serverSshDns)
            // the absolute path of the remote server directory where the project is deployed
            ->deployDir($this->deployDir)
            // the URL of the Git repository where the project code is hosted
            ->repositoryUrl('git@github.com:fbaudet/conundrum.git')
            // the repository branch to deploy
            ->repositoryBranch('master')
        ;
    }

    public function beforePreparing()
    {
        $this->runRemote('cp ../../env/.env.local .env');
        $this->runLocal('./node_modules/.bin/encore production');
        $this->runRemote('rm -rf {{ deploy_dir }}/shared/deploy');
        $this->runRemote('if [ -d {{ deploy_dir }}/shared/deploy ]; then rm -rf {{ deploy_dir }}/shared/deploy; fi');
        $this->runRemote('mkdir -p {{ project_dir }}/public/build');
        $this->runRemote('mkdir -p {{ deploy_dir }}/shared/deploy');
        $this->runLocal('scp -r public/build/* '.$this->serverSshDns.':'.$this->deployDir.'/shared/deploy');
        $this->runRemote('mv {{ deploy_dir }}/shared/deploy/* public/build');
    }

    public function beforePublishing()
    {
        $this->runRemote('export `cat .env` && php bin/console doctrine:migrations:migrate --no-interaction');
    }
};
