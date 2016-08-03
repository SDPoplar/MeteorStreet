<?php
define( 'LOG_LEVEL_ALL', 0 );
define( 'LOG_LEVEL_NOTICE', 1 );
define( 'LOG_LEVEL_WARNING', 2 );
define( 'LOG_LEVEL_ERROR', 3 );

return [
    'LOG_TYPE' => 'File',
    'LOG_LEVEL' => DEBUG_MODE ? LOG_LEVEL_ALL : LOG_LEVEL_ERROR,
];

