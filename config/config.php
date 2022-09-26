<?php
/**
 * @category    All
 * @package     Lumen
 * @author      shadrack
 */

return  [
    'database'    => [
        'adapter'  => 'Mysql',
        'host'     => '127.0.0.1',
        'username' => 'Admin',
        'password' => 'Admin',
        'dbname'   => 'unea',
    ],
    'api'       =>[
        'eaapi' => 'https://staging1.unep.org/simon/pims-stg/modules/main/unea-api/expectedaccomplishment',
        'mea'=> 'http://staging1.unep.org/shadrackkirui/unea_monitoring/api/reporting/getmeaoptions',
        'projects'=> 'https://staging1.unep.org/simon/pims-stg/modules/main/unea-api/uneaproject',
        'divisions'=> 'https://apps1.unep.org/umoja/api/divisions',
        'odata'=>'http://odata.informea.org/informea.svc/Treaties',
        'pow'=> 'https://staging1.unep.org/simon/pims-stg/modules/main/unea-api/eaapi',
        'subprogrammes' => 'https://staging1.unep.org/simon/pims-stg/modules/main/unea-api/expectedaccomplishment',
        'users' => 'https://apps1.unep.org/umoja-v2/staff/search/',
        'user_token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBfbmFtZSI6InVuZWEiLCJvd25lciI6IlNoYWRyYWNrIiwiaWF0IjoxOTE2MjM5MDIyfQ.eU-5K1aw1BS1wJn191_rTH0h3sokOJWSGE-8oP_BZ90'

    ],
    
];