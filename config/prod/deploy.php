<?php

use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

return new class extends DefaultDeployer
{
    public function configure()
    {
        return $this->getConfigBuilder()
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
        $this->runRemote('cp ../../env/.env.local .env');
    }

    public function beforePublishing()
    {
        $this->runRemote('export `cat .env` && php bin/console doctrine:migrations:migrate --no-interaction');
    }
};
