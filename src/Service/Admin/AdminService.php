<?php

declare(strict_types=1);

namespace App\Service\Admin;

class AdminService
{

    public function __construct(
        protected GitHubService $gitHubHelper
    ) {}

    public function getGitVersions(): array {

        return $this->gitHubHelper->getAllBranches();
    }

    public function getCurrentVersion(): string {

        return $this->gitHubHelper->getCurrentBranch();
    }

    public function updateServer(
        string $version
    ): void {
        

    }
}
