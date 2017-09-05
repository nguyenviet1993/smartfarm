<?php
define('PUBLIC_KEY_SUN','-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIbGb2Yw2Ep89zSsOUrNiTvG4R
15CCwwPLnfEJCXQVb0qafs2lIgsuYmClkdzcEsgq2+V9SbbDs1oaKhrflcRImDas
vg60WAP0qoe8Tqk1HT3vgA4QdltNYZn1XW1mqym9d95ybAhw5BXlsyLKPzlUGd2k
dY3Bnxp7km2y31CcBQIDAQAB
-----END PUBLIC KEY-----');
define('USERNAME','me2be@sunmedia.com');
define('TOKEN','312ffc66c320c6193ec354e3906328b0');
define('GAME','ME2BE');
define("UPLOAD_DIR",realpath('./') . '\\upload\\');
define('W_THUMB',150);
return new \Phalcon\Config(array(
    'database'  => array(
        'mysql' => array(
            'host'     => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname'   => 'api_me2be',
        )),
    'redis' => array(
        'host' => 'localhost',
        'port' => '6379',
        'db'   => 5
    ),
    'log'   => 0,
    'IDConnect' => array(
        'key'       => "48a32e69d7c537d9be5c749495935baf",
        'BaseURL'   => "http://id.sunvnmedia.com/rest/user"
    ),
    'application' => array(
        'modelsDir' => __DIR__ . '/../models/',
        'controllersDir' => __DIR__ . '/../controllers/',
        'controllersV1' => __DIR__ . '/../controllers/v1',
        'libDir' => __DIR__ . '/../lib/',
        'viewsDir' => __DIR__ . '/../views/',
        'baseUri' => '/',
    ),
    'rest_config'=>array(
        'DOMAIN' => 'http://sb.admin.me2be.vn',
    )
));
