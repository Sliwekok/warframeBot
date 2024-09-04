<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\UniqueNameInterface\GitHubInterface;

class GitHubService
{

    public function getAllBranches(): array {
        /** @var  $cmd
         * returns text from command line to get all branches
         * we are trimming off local branches and HEAD branch
         * last one will remain empty array key - we're trimming it too,
         * EXAMPLE:
             * working_branch\n
             * develop\n
             * master\n
             * remotes\origin\HEAD -> origin/master\n
             * remotes\origin\working_branch\n
             * remotes\origin\develop\n
             * remotes\origin\master\n
         */


        $cmd = shell_exec(GitHubInterface::SHOW_ALL_BRANCHES);
        $cmd = explode("\n", $cmd);

        /** @var  $branch
         * we're working on original array to change branches to remote only
         */
        foreach ($cmd as $key => &$branch) {
            $branch = trim($branch);
            if (!str_starts_with($branch, GitHubInterface::PREFIX_REMOTES)) {
                unset($cmd[$key]);
            } else {
                $cmd[$key] = str_replace(GitHubInterface::PREFIX_REMOTES, "", $branch);

                if(str_starts_with($branch, GitHubInterface::BRANCH_HEAD)) {
                    unset($cmd[$key]);
                }
            }

            if (strlen($branch) === 0) {
                unset($cmd[$key]);
            }
        }

        return $cmd;
    }


    public function getCurrentBranch(): string {

        return trim(shell_exec(GitHubInterface::GET_CURRENT_BRANCH));
    }
}
