<?php

class Podio {
  public static $oauth, $debug, $logger, $session_manager, $last_response;
  protected static $url, $client_id, $client_secret, $secret, $ch, $headers;

  const GET = 'GET';
  const POST = 'POST';
  const PUT = 'PUT';
  const DELETE = 'DELETE';

  public static function setup($client_id, $client_secret, $options = array('session_manager' => 'PodioSession', 'curl_options' => array())) {
    // Setup client info
	
    self::$client_id = $client_id;
    self::$client_secret = $client_secret;

    // Setup curl
    self::$url = empty($options['api_url']) ? 'https://api.podio.com:443' : $options['api_url'];
    self::$debug = self::$debug ? self::$debug : false;
    self::$ch = curl_init();
    self::$headers = array(
      'Accept' => 'application/json',
    );
    curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(self::$ch, CURLOPT_USERAGENT, 'Podio PHP Client/3.0');
    curl_setopt(self::$ch, CURLOPT_HEADER, true);
    curl_setopt(self::$ch, CURLINFO_HEADER_OUT, true);

    if ($options && !empty($options['curl_options'])) {
      curl_setopt_array(self::$ch, $options['curl_options']);
    }

    self::$session_manager = null;
    if ($options && !empty($options['session_manager']) && class_exists($options['session_manager'])) {
      self::$session_manager = new $options['session_manager'];
      self::$oauth = self::$session_manager->get();
    }

    // Register shutdown function for debugging and session management
    register_shutdown_function('Podio::shutdown');
  }

  public static function authenticate($grant_type, $attributes) {
    $data = array();
    $data['client_id'] = self::$client_id;
    $data['client_secret'] = self::$client_secret;
    
    switch ($grant_type) {
      case 'password':
        $data['grant_type'] = 'password';
        $data['username'] = $attributes['username'];
        $data['password'] = $attributes['password'];
        break;
      case 'refresh_token':
        $data['grant_type'] = 'refresh_token';
        $data['refresh_token'] = $attributes['refresh_token'];
        break;
      case 'authorization_code':
        $data['grant_type'] = 'authorization_code';
        $data['code'] = $attributes['code'];
        $data['redirect_uri'] = $attributes['redirect_uri'];
        break;
      case 'app':
        $data['grant_type'] = 'app';
        $data['app_id'] = $attributes['app_id'];
        $data['app_token'] = $attributes['app_token'];
      default:
        break;
    }
    if ($response = self::request(self::POST, '/oauth/token', $data, array('oauth_request' => true))) {
      $body = $response->json_body();
      self::$oauth = new PodioOAuth($body['access_token'], $body['refresh_token'], $body['expires_in'], $body['ref']);
      return true;
    }
    return false;
  }

  public static function authorize_url($redirect_uri) {
    $parsed_url = parse_url(self::$url);
    $host = str_replace('api.', '', $parsed_url['host']);
    return 'https://'.$host.'/oauth/authorize?response_type=code&client_id='.self::$client_id.'&redirect_uri='.rawurlencode($redirect_uri);
  }

  public static function is_authenticated() {
    return self::$oauth && self::$oauth->access_token;
  }

  public static function request($method, $url, $attributes = array(), $options = array()) {
    if (!self::$ch) {
      throw new Exception('Client has not been setup with client id and client secret.');
    }

    // Reset attributes so we can reuse curl object
    curl_setopt(self::$ch, CURLOPT_POSTFIELDS, null);
    unset(self::$headers['Content-length']);
    $original_url = $url;
    $encoded_attributes = null;

    if (is_object($attributes) && substr(get_class($attributes), 0, 5) == 'Podio') {
      $attributes = $attributes->as_json(false);
    }

    if (!is_array($attributes) && !is_object($attributes)) {
      throw new PodioDataIntegrityError('Attributes must be an array');
    }

    switch ($method) {
      case self::GET:
        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, self::GET);
        self::$headers['Content-type'] = 'application/x-www-form-urlencoded';
        if ($attributes) {
          $query = self::encode_attributes($attributes);
          $url = $url.'?'.$query;
        }
        self::$headers['Content-length'] = "0";
        break;
      case self::DELETE:
        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, self::DELETE);
        self::$headers['Content-type'] = 'application/x-www-form-urlencoded';
        $query = self::encode_attributes($attributes);
        $url = $url.'?'.$query;
        self::$headers['Content-length'] = "0";
        break;
      case self::POST:
        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, self::POST);
        if (!empty($options['upload'])) {
          curl_setopt(self::$ch, CURLOPT_POST, TRUE);
          curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $attributes);
          self::$headers['Content-type'] = 'multipart/form-data';
        }
        elseif (empty($options['oauth_request'])) {
          // application/json
          $encoded_attributes = json_encode($attributes);
          curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $encoded_attributes);
          self::$headers['Content-type'] = 'application/json';
        }
        else {
          // x-www-form-urlencoded
          $encoded_attributes = self::encode_attributes($attributes);
          curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $encoded_attributes);
          self::$headers['Content-type'] = 'application/x-www-form-urlencoded';
        }
        break;
      case self::PUT:
        $encoded_attributes = json_encode($attributes);
        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, self::PUT);
        curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $encoded_attributes);
        self::$headers['Content-type'] = 'application/json';
        break;
    }

    // Add access token to request
    if (isset(self::$oauth) && !empty(self::$oauth->access_token) && !(isset($options['oauth_request']) && $options['oauth_request'] == true)) {
      $token = self::$oauth->access_token;
      self::$headers['Authorization'] = "OAuth2 {$token}";
    }
    else {
      unset(self::$headers['Authorization']);
    }

    // File downloads can be of any type
    if (empty($options['file_download'])) {
      self::$headers['Accept'] = 'application/json';
    }
    else {
      self::$headers['Accept'] = '*/*';
    }

    curl_setopt(self::$ch, CURLOPT_HTTPHEADER, self::curl_headers());
    curl_setopt(self::$ch, CURLOPT_URL, empty($options['file_download']) ? self::$url.$url : $url);

    $response = new PodioResponse();
    $raw_response = curl_exec(self::$ch);
    $raw_headers_size = curl_getinfo(self::$ch, CURLINFO_HEADER_SIZE);
    $response->body = substr($raw_response, $raw_headers_size);
    $response->status = curl_getinfo(self::$ch, CURLINFO_HTTP_CODE);
    $response->headers = self::parse_headers(substr($raw_response, 0, $raw_headers_size));
    self::$last_response = $response;

    if (self::$debug && !isset($options['oauth_request'])) {
      if (!self::$logger) {
        self::$logger = new PodioLogger();
      }
      $curl_info = curl_getinfo(self::$ch, CURLINFO_HEADER_OUT);
      self::$logger->log_request($method, $url, $encoded_attributes, $response, $curl_info);

      self::$logger->call_log[] = curl_getinfo(self::$ch, CURLINFO_TOTAL_TIME);
    }

    switch ($response->status) {
      case 200 :
      case 201 :
      case 204 :
        return $response;
        break;
      case 400 :
        // invalid_grant_error or bad_request_error
        $body = $response->json_body();
        if (strstr($body['error'], 'invalid_grant')) {
          // Reset access token & refresh_token
          self::$oauth = new PodioOAuth();
          throw new PodioInvalidGrantError($response->body, $response->status, $url);
          break;
        }
        else {
          throw new PodioBadRequestError($response->body, $response->status, $url);
        }
        break;
      case 401 :
        $body = $response->json_body();
        if (strstr($body['error_description'], 'expired_token') || strstr($body['error'], 'invalid_token')) {
          if (self::$oauth->refresh_token) {
            // Access token is expired. Try to refresh it.
            if (self::authenticate('refresh_token', array('refresh_token' => self::$oauth->refresh_token))) {
              // Try the original request again.
              return self::request($method, $original_url, $attributes);
            }
            else {
              self::$oauth = new PodioOAuth();
              throw new PodioAuthorizationError($response->body, $response->status, $url);
            }
          }
          else {
            // We have tried in vain to get a new access token. Log the user out.
            self::$oauth = new PodioOAuth();
            throw new PodioAuthorizationError($response->body, $response->status, $url);
          }
        }
        elseif (strstr($body['error'], 'invalid_request')) {
          // Access token is invalid.
          self::$oauth = new PodioOAuth();
          throw new PodioAuthorizationError($response->body, $response->status, $url);
        }
        break;
      case 403 :
        throw new PodioForbiddenError($response->body, $response->status, $url);
        break;
      case 404 :
        throw new PodioNotFoundError($response->body, $response->status, $url);
        break;
      case 409 :
        throw new PodioConflictError($response->body, $response->status, $url);
        break;
      case 410 :
        throw new PodioGoneError($response->body, $response->status, $url);
        break;
      case 420 :
        throw new PodioRateLimitError($response->body, $response->status, $url);
        break;
      case 500 :
        throw new PodioServerError($response->body, $response->status, $url);
        break;
      case 502 :
      case 503 :
      case 504 :
        throw new PodioUnavailableError($response->body, $response->status, $url);
        break;
      default :
        throw new PodioError($response->body, $response->status, $url);
        break;
    }
    return false;
  }

  public static function get($url, $attributes = array(), $options = array()) {
    return self::request(Podio::GET, $url, $attributes, $options);
  }
  public static function post($url, $attributes = array(), $options = array()) {
    return self::request(Podio::POST, $url, $attributes, $options);
  }
  public static function put($url, $attributes = array()) {
    return self::request(Podio::PUT, $url, $attributes);
  }
  public static function delete($url, $attributes = array()) {
    return self::request(Podio::DELETE, $url, $attributes);
  }

  public static function curl_headers() {
    $headers = array();
    foreach (self::$headers as $header => $value) {
      $headers[] = "{$header}: {$value}";
    }
    return $headers;
  }
  public static function encode_attributes($attributes) {
    $return = array();
    foreach ($attributes as $key => $value) {
      $return[] = urlencode($key).'='.urlencode($value);
    }
    return join('&', $return);
  }
  public static function url_for_post_with_options($url, $options) {
    $parameters = array();

    if (isset($options['silent']) && $options['silent']) {
      $parameters[] = 'silent=1';
    }

    if (isset($options['hook']) && !$options['hook']) {
      $parameters[] = 'hook=false';
    }

    return $parameters ? $url.'?'.join('&', $parameters) : $url;
  }
  public static function parse_headers($headers) {
    $list = array();
    $headers = str_replace("\r", "", $headers);
    $headers = explode("\n", $headers);
    foreach ($headers as $header) {
      if (strstr($header, ':')) {
        $name = strtolower(substr($header, 0, strpos($header, ':')));
        $list[$name] = trim(substr($header, strpos($header, ':')+1));
      }
    }
    return $list;
  }
  public static function rate_limit_remaining() {
    return self::$last_response->headers['x-rate-limit-remaining'];
  }
  public static function rate_limit() {
    return self::$last_response->headers['x-rate-limit-limit'];
  }

  public static function shutdown() {
    // Write any new access and refresh tokens to session.
    if (self::$session_manager) {
      self::$session_manager->set(self::$oauth);
    }

    // Log api call times if debugging
    if(self::$debug && self::$logger) {
      $timestamp = gmdate('Y-m-d H:i:s');
      $count = sizeof(self::$logger->call_log);
      $duration = 0;
      foreach (self::$logger->call_log as $val) {
        $duration += $val;
      }
      self::$logger->log("\n{$timestamp} Performed {$count} requests in {$duration} seconds\n");
    }
  }
}
