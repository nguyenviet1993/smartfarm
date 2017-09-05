<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/06/2016
 * Time: 1:44 CH
 */
use \Illuminate\Support\Facades\Response;

define('INVALID_PARAMS', 'Invalid params');
define('STUDENT_LOGIN_FAIL', 'Username or password invalid');
define('TEACHER_LOGIN_FAIL', 'Email or password invalid');
define('EMPTY_DATA', 'Không có dữ liệu!');
define('INVALID_LAKE', 'Ao không tồn tại!');
define('INVALID_FOOD_TYPE', 'Mã thức ăn không tồn tại!');
class ResponseMsg
{
// [Successful 2xx]
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NONAUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;

    // [Client Error 4xx]
    const errorCodesBeginAt = 400;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;

    // Define for SDK
    const SDK_SUCCESS = 1;
    const SDK_FAIL = 0;
    const SDK_INCORRECT_SIGNATURE = 603;
    const SDK_SERVER_ERROR = 500;
    const SDK_INVALID_PARAMS = 606;
    const SDK_API_FORBIDDEN = 605;
    const SDK_NOT_FOUND = 604;
    const SDK_INSERT_DB_FAIL = 777;
    const SDK_MCID_EMAIL_EXIST = 300;
    const SDK_MCID_PASSWORD_EMPTY = 301;
    const SDK_MCID_USER_OR_PASSWORD_INCORRECT = 310;
    const SDK_MCID_OLD_PASSWORD_INCORRECT = 320;
    const SDK_EMAIL_EXIST = 300;
    const SDK_UK_NOT_EXIST = 250;

    private static $messages = array(
        self::REST_FEECFG_RANGE_INF => 'Value range is missing INF',
        self::REST_FEECFG_RANGE_UNLINEAR => 'Value range is not linear',
        self::REST_FEECFG_RANGE_0 => 'Value range is missing zero',
        self::REST_FEECFG_RANGE_NEST => 'Nest of intervals value range ',
        self::REST_FEECFG_DATE_NEST => 'Nest of intervals date range ',
        self::REST_FEECFG_DATE_INF => 'Missing INF date',
        self::REST_DB_TRANSACTION_FAILED => 'DB Transaction Failed',
        self::REST_WD_BALANCE_NOT_ENOUGH => 'Current balance is not enough',
        self::REST_WD_ACC_NOT_FOUND => 'Account not found',
        self::REST_WD_ACC_LOCK => 'Account is not allowed for withdraw',
        self::REST_WD_VOUCHER_NOT_FOUND => 'Withdraw voucher is not existed',
        self::REST_WD_CAN_NOT_SUSPEND => 'Can not suspend',
        self::REST_WD_CAN_NOT_UNSUSPEND => 'Can not unsuspend',
        self::REST_WD_CAN_NOT_CANCEL => 'Can not cancel - status is already CANCELLED or FINISHED',
        self::REST_WD_CAN_NOT_FINISH => 'Can not finish withdraw - status is not INIT',
        self::REST_INVALID_CRC => 'Invalid CRC check',
        21 => 'Missing parameter',
        2 => 'Insert DB failed',
        23 => 'Can not update account',
        // [Informational 1xx]
        100 => '100 Continue',
        101 => '101 Switching Protocols',

        //[Successful 2xx]
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',

        // [Redirection 3xx]
        300 => '300 Multiple Choices',
        301 => '301 Moved Permanently',
        302 => '302 Found',
        303 => '303 See Other',
        304 => '304 Not Modified',
        305 => '305 Use Proxy',
        306 => '306 (Unused)',
        307 => '307 Temporary Redirect',

        // [Client Error 4xx]
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable - Invalid signature',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Timeout',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        412 => '412 Precondition Failed',
        413 => '413 Request Entity Too Large',
        414 => '414 Request-URI Too Long',
        415 => '415 Unsupported Media Type',
        416 => '416 Requested Range Not Satisfiable',
        417 => '417 Expectation Failed',

        // [Server Error 5xx]
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Timeout',
        505 => '505 HTTP Version Not Supported',
    );

    public static function makeResp($input, $statusCode = self::SDK_SUCCESS, $data = NULL, $msg = null, $event = null)
    {
        $rest = new stdClass();
        $rest->status = $statusCode;
        $rest->msg = !is_null(ResponseMsg::getMsg($statusCode)) ? ResponseMsg::getMsg($statusCode) : '';
        $rest->time = time();
        if (is_array($data) && !empty($data['time'])) {
            $rest->time = $data['time'];
        } else if (!empty($data->time)) {
            $rest->time = $data->time;
        }

        if (!empty($msg)) {
            $rest->msg = self::getMsg($msg);
        }

        $rest->data = array();
        if (!empty($data)) {
            $rest->data = $data;
        }
        $token = NULL;
        $key = 'KEY';
        if (!empty ($input['target'])) {
            $token = $input['target'];
        } else if (is_array($data) && !empty($data['username'])) {
            $token = $data['username'];
        } else if (!is_array($data) && !empty($data->username)) {
            $token = $data->username;
        }
        $token .= $rest->time;
        $token .= $key;
        $rest->token = md5($token);
        if ($statusCode == 603) return json_encode($rest);
        else if ($statusCode == 401) return json_encode($rest);
        else return Response::json($rest);
    }

    public static function getMsg($status)
    {
        $retVal = null;
        switch ($status) {
            case self::SDK_SUCCESS:
                $retVal = 'Thành công';
                break;
            case self::SDK_FAIL :
                $retVal = 'Thất bại';
                break;
            case self::SDK_INCORRECT_SIGNATURE:
                $retVal = 'Chữ ký sai, không thể xác thực chữ ký';
                break;
            case self::SDK_SERVER_ERROR:
                $retVal = 'Internal server error';
                break;
            case self::SDK_INVALID_PARAMS:
                $retVal = 'Tham số không hợp lệ';
                break;
            case self::SDK_API_FORBIDDEN:
                $retVal = 'API không được phép';
                break;
            case self::HTTP_NOT_FOUND:
                $retVal = 'Không tìm thấy yêu cầu';
                break;
            case self::HTTP_UNAUTHORIZED:
                $retVal = 'Lỗi xác thực, username hoặc password gọi API không đúng';
                break;
            case self::SDK_INSERT_DB_FAIL:
                $retVal = 'Không thể lưu được vào database';
                break;
            case self::SDK_MCID_EMAIL_EXIST:
                $retVal = 'Địa chỉ email đã tồn tại';
                break;
            case self::SDK_MCID_OLD_PASSWORD_INCORRECT:
                $retVal = 'Mật khẩu cũ không đúng, không thể thay đổi mật khẩu';
                break;
            case self::SDK_MCID_PASSWORD_EMPTY:
                $retVal = 'Mật khẩu không được trống';
                break;
            case self::SDK_MCID_USER_OR_PASSWORD_INCORRECT:
                $retVal = 'Tên đăng nhập hoặc mật khẩu không đúng';
                break;
            case self::SDK_EMAIL_EXIST:
                $retVal = 'Địa chỉ email đã tồn tại';
                break;
        }
        return $retVal;
    }
}