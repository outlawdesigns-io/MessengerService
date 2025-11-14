<?php

require_once __DIR__ . '/Libs/Api/Api.php';
require_once __DIR__ . '/Libs/Messenger/Messenger.php';
require_once __DIR__ . '/Libs/JwksTokenValidator-PHP/JwksTokenValidator.php';

class EndPoint extends API{

    const GETERR = 'Can only GET this endpoint';
    const POSTERR = 'Can only POST this endpoint';
    const REQERR = 'Malformed Request.';
    protected static $_authErrors = array(
      "headers"=>"Malfromed Authorization header.",
      "noToken"=>"Access Denied. No Token Present.",
      "badToken"=>"Access Denied. Invalid Token"
    );

    protected $_tokenValidator;
    protected $_jwksUri;
    protected $_cacheFile;
    protected $_cacheTtl;
    protected $_oauthAudience;
    protected $_token;
    protected $_user;

    public function __construct($request,$origin)
    {
        parent::__construct($request);
        if(!isset($this->headers['Authorization'])){
          throw new \Exception(self::$_authErrors['noToken']);
        }
        $token = explode(' ',$this->headers['Authorization'])[1] ?? null;
        if(!$token){
          throw new \Exception(self::$_authErrors['headers']);
        }
        $this->_token = $token;
        if(!$this->_verifyToken()){
          throw new \Exception(self::$_authErrors['badToken']);
        }
        $this->_loadEnvSettings();
        $this->_tokenValidator = new JwksTokenValidator($this->_jwksUri, $this->_cacheFile, $this->_cacheTtl);
    }
    private function _loadEnvSettings(){
      if(!$this->_jwksUri = getenv('OAUTH_JWKS_URI')){
        throw new \Exception('Unable to access environment variable: OAUTH_JWKS_URI');
      }
      if(!$this->_cacheFile = getenv('OAUTH_CACHE_PATH')){
        throw new \Exception('Unable to access environment variable: OAUTH_CACHE_PATH');
      }
      if(!$this->_cacheTtl = getenv('OATH_CACHE_TTL')){
        throw new \Exception('Unable to access environment variable: OATH_CACHE_TTL');
      }
      if(!$this->_oauthAudience = getenv('OATH_AUDIENCE')){
        throw new \Exception('Unable to access environment variable: OATH_AUDIENCE');
      }
    }
    private function _verifyToken(){
      try{
        $payload = $this->_tokenValidator->validateJwt($this->_token);
      }catch(\Exception $ex){
        return false;
      }
      if(!in_array($this->_oauthAudience,$payload['aud'])){
        return false;
      }
      $this->_user = $payload;
      return true;
    }
    protected function example(){
      return array("endPoint"=>$this->endpoint,"verb"=>$this->verb,"args"=>$this->args,"request"=>$this->request);
    }
    protected function verify(){
      if(!$this->_verifyToken()){
        throw new \Exception('Token Rejected');
      }
      return $this->_token;
    }
    protected function send(){
      if($this->method != "POST"){
        throw new \Exception(self::POSTERR);
      }
      try{
        Messenger::send(json_decode(json_encode($this->request),true));
      }catch(\Exception $e){
        throw new \Exception($e->getMessage());
      }
      return $this->request;
    }
    protected function message(){
      $data = null;
      if($this->method != "GET"){
        throw new \Exception(self::GETERR);
      }
      if(!isset($this->verb) && !isset($this->args[0])){
        $data = Messenger::getSent();
      }elseif(!isset($this->verb) && (int)$this->args[0]){
        $data = Messenger::getSent($this->args[0]);
      }else{
        throw new \Exception(self::REQERR);
      }
      return $data;
    }
    protected function search(){
      $data = null;
      if($this->method != "GET"){
        throw new \Exception(self::GETERR);
      }elseif(isset($this->verb) && isset($this->args[0])){
        $data = Messenger::searchSent($this->verb,$this->args[0]);
      }elseif(isset($this->verb) && !isset($this->args[0])){
        throw new \Exception('Must provide search key/value');
      }else{
        throw new \Exception(self::REQERR);
      }
      return $data;
    }
    protected function sent(){
      if(!isset($this->verb)){
        throw new \Exception('Message name string must be specified');
      }elseif(!isset($this->args[0]) || empty($this->args[0])){
        throw new \Exception('Message flag must be specified');
      }elseif($this->method != "GET"){
        throw new \Exception('Can only GET this endpoint');
      }
      return Messenger::isSent($this->verb,$this->args[0]);
    }
}
