<?php
namespace Mxs\Commands;

class Helper
{
    public function usage()
    {
        $usage = <<<usagestr
usage: php mxs [group:]command [params]
registed commands:
usagestr;

        echo $usage, PHP_EOL;
        foreach (\Mxs\Routes\Codecs\Console::buildInnerCmdMap() as $key => $line) {
            printf("    %-20s%s\n", $key, $line->describe);
        }
    }
}

