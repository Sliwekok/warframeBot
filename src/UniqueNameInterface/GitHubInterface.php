<?php

declare(strict_types=1);

namespace App\UniqueNameInterface;

class GitHubInterface
{

    public const SHOW_ALL_BRANCHES = "git branch -a";
    public const PREFIX_REMOTES = "remotes/origin/";
    public const BRANCH_HEAD = "HEAD";
    public const GET_CURRENT_BRANCH = "git branch --show-current";

}
