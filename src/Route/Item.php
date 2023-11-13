<?php
namespace Mxs\Route;

interface Item
{
    public function execute(\Mxs\Inputs\RootInputInterface $input);
}
