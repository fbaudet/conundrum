<?php

use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

return new class extends DefaultDeployer
{
    public function configure()
    {
        return $this->getConfigBuilder()
            ->composerInstallFlags('--prefer-dist --no-interaction --no-dev')
            // SSH connection string to connect to the remote server (format: user@host-or-IP:port-number)
            ->server('ubuntu@167.114.237.255')
            // the absolute path of the remote server directory where the project is deployed
            ->deployDir('/home/ubuntu/conundrum')
            // the URL of the Git repository where the project code is hosted
            ->repositoryUrl('git@github.com:fbaudet/conundrum.git')
            // the repository branch to deploy
            ->repositoryBranch('master')
        ;
    }

    public function beforePreparing()
    {
        $this->runRemote('cp /home/ubuntu/conundrum/env/.env.local /home/ubuntu/conundrum/repo/.env');
    }

    // run some local or remote commands after the deployment is finished
    public function beforeFinishingDeploy()
    {
        $this->runRemote('APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear');
        $this->runRemote('php bin/console doctrine:migrations:migrate --no-interaction');
    }
};
