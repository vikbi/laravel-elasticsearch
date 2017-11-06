<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;

// [Informational 1xx]
const HTTP_STATUS_CONTINUE = 100;
const HTTP_STATUS_SWITCHING_PROTOCOLS = 101;
// [Successful 2xx]
const HTTP_STATUS_OK = 200;
const HTTP_STATUS_CREATED = 201;
const HTTP_STATUS_ACCEPTED = 202;
const HTTP_STATUS_NONAUTHORITATIVE_INFORMATION = 203;
const HTTP_STATUS_NO_CONTENT = 204;
const HTTP_STATUS_RESET_CONTENT = 205;
const HTTP_STATUS_PARTIAL_CONTENT = 206;
// [Redirection 3xx]
const HTTP_STATUS_MULTIPLE_CHOICES = 300;
const HTTP_STATUS_MOVED_PERMANENTLY = 301;
const HTTP_STATUS_FOUND = 302;
const HTTP_STATUS_SEE_OTHER = 303;
const HTTP_STATUS_NOT_MODIFIED = 304;
const HTTP_STATUS_USE_PROXY = 305;
const HTTP_STATUS_UNUSED = 306;
const HTTP_STATUS_TEMPORARY_REDIRECT = 307;
// [Client Error 4xx]
const HTTP_STATUS_BAD_REQUEST = 400;
const HTTP_STATUS_UNAUTHORIZED = 401;
const HTTP_STATUS_PAYMENT_REQUIRED = 402;
const HTTP_STATUS_FORBIDDEN = 403;
const HTTP_STATUS_NOT_FOUND = 404;
const HTTP_STATUS_METHOD_NOT_ALLOWED = 405;
const HTTP_STATUS_NOT_ACCEPTABLE = 406;
const HTTP_STATUS_PROXY_AUTHENTICATION_REQUIRED = 407;
const HTTP_STATUS_REQUEST_TIMEOUT = 408;
const HTTP_STATUS_CONFLICT = 409;
const HTTP_STATUS_GONE = 410;
const HTTP_STATUS_LENGTH_REQUIRED = 411;
const HTTP_STATUS_PRECONDITION_FAILED = 412;
const HTTP_STATUS_REQUEST_ENTITY_TOO_LARGE = 413;
const HTTP_STATUS_REQUEST_URI_TOO_LONG = 414;
const HTTP_STATUS_UNSUPPORTED_MEDIA_TYPE = 415;
const HTTP_STATUS_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
const HTTP_STATUS_EXPECTATION_FAILED = 417;
const HTTP_STATUS_UNPROCESSABLE_ENTITY = 422;
const HTTP_STATUS_FAILED_DEPENDENCY = 424;
// [Server Error 5xx]
const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;
const HTTP_STATUS_NOT_IMPLEMENTED = 501;
const HTTP_STATUS_BAD_GATEWAY = 502;
const HTTP_STATUS_SERVICE_UNAVAILABLE = 503;
const HTTP_STATUS_GATEWAY_TIMEOUT = 504;
const HTTP_STATUS_VERSION_NOT_SUPPORTED = 505;

class ApiController extends Controller {

    use SystemMessage;

    protected $httpStatus = HTTP_STATUS_OK;
    protected $response = [];
    protected $responseData;
// if multi language required
    public function __construct(Request $request) {
        if ($lang = $request->header('lang', $request->input('lang'))) {
            App::setLocale($lang);
        }
    }

    /**
     * @param int $status
     */
    protected function setHttpStatus($status = HTTP_STATUS_OK) {
        $this->httpStatus = $status;
    }

    /**
     * 
     * @return type
     */
    protected function getHttpStatus() {
        return $this->httpStatus;
    }

    /**
     * 
     * @param type $response
     */
    protected function setResponseData(array $response = null) {
        $this->response = $response;
    }

    /**
     * 
     * @return type
     */
    protected function getResponseData() {
        return $this->response;
    }

    /**
     * 
     * @param type $status
     * @return type
     */
    public function respond($status = HTTP_STATUS_OK) {
        $response = $this->getResponseData();
        $this->getMessage() ? $response['msg'] = $this->getMessage() : [];

        return Response::json($response, $status);
    }

}

trait SystemMessage {

    protected $msgBag = [];

    /**
     * Flash an information message.
     *
     * @param string $message
     * @return $this
     */
    public function info($message) {
        $this->message($message, 'info');

        return $this;
    }

    /**
     * Flash a success message.
     *
     * @param  string $message
     * @return $this
     */
    public function success($message) {
        $this->message($message, 'success');

        return $this;
    }

    /**
     * Flash an error message.
     *
     * @param  string $message
     * @return $this
     */
    public function error($message) {
        $this->message($message, 'danger');

        return $this;
    }

    /**
     * Flash a warning message.
     *
     * @param  string $message
     * @return $this
     */
    public function warning($message) {
        $this->message($message, 'warning');

        return $this;
    }

    /**
     * Flash an overlay modal.
     *
     * @param  string $message
     * @param  string $title
     * @return $this
     */
    public function overlay($message, $title = 'Notice') {
        $this->message($message);
        $this->msgBag[] = ['overlay' => true, 'title' => $title];

        return $this;
    }

    /**
     * Flash a general message.
     *
     * @param  string $message
     * @param  string $level
     * @return $this
     */
    public function message($message, $level = 'info') {
        $this->msgBag[] = ['body' => (array) $message, 'type' => $level];

        return $this;
    }

    /**
     * Add an "important" flash to the session.
     *
     * @return $this
     */
    public function important() {
        $this->msgBag['important'] = true;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getMessage() {
        return $this->msgBag;
    }

}
