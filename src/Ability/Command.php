<?php
namespace Mxs\Ability;

interface Command
{
    public static function getUsage(): string;
    public static function getDescribe(): string;
    public function handle(\Mxs\Inputs\Console $in);
}