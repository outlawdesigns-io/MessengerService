<?php

require_once __DIR__ . '/Libs/Api/Api.php';
require_once __DIR__ . '/Libs/Messenger/Messenger.php';

class EndPoint extends API{

    const ACCOUNTS = 'https://api.outlawdesigns.io:9661/';
    const GETERR = 'Can only GET this endpoint';
    const POSTERR = 'Can only POST this endpoint';
    const REQERR = 'Malformed Request.';
    protected static $_authErrors = array(
      "headers"=>"Missing required headers.",
      "noToken"=>"Access Denied. No Token Present.",
      "badToken"=>"Access Denied. Invalid Token"
    );

    public function __construct($request,$origin)
    {
        parent::__construct($request);
        if(isset($this->headers['request_token']) && ! isset($this->headers['password'])){
          throw new \Exception(self::$_authErrors['headers']);
        }elseif(!isset($this->headers['auth_token']) && !isset($this->headers['request_token'])){
          throw new \Exception(self::$_authErrors['noToken']);
        }elseif(!$this->_verifyToken() && !isset($this->headers['request_token'])){
          throw new \Exception(self::$_authErrors['badToken']);
        }
    }
    private function _verifyToken(){
      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL,self::ACCOUNTS . "verify/");
      curl_setopt($ch,CURLOPT_HTTPHEADER,array('auth_token: ' . $this->headers['auth_token']));
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      $output = json_decode(curl_exec($ch));
      curl_close($ch);
      if(isset($output->error)){
        return false;
      }
      $this->user = $output;
      return true;
    }
    private function _authenticate(){
      $headers = array('request_token: ' . $this->headers['request_token'],'password: ' . $this->headers['password']);
      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL,self::ACCOUNTS . "authenticate/");
      curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      $output = json_decode(curl_exec($ch));
      curl_close($ch);
      if(isset($output->error)){
        throw new \Exception($output->error);
      }
      $this->headers['auth_token'] = $output->token;
      $this->_verifyToken();
      return $output;
    }
    protected function example(){
      return array("endPoint"=>$this->endpoint,"verb"=>$this->verb,"args"=>$this->args,"request"=>$this->request);
    }
    protected function authenticate(){
      return $this->_authenticate();
    }
    protected function verify(){
      if(!$this->_verifyToken()){
        throw new \Exception('Token Rejected');
      }
      return $this->headers['auth_token'];
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
