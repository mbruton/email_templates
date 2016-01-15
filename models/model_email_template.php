<?php

namespace extensions\email_templates{
    
    /* Prevent Direct Access */
    defined('ADAPT_STARTED') or die;
    
    class model_email_template extends \frameworks\adapt\model{
        
        protected $_variables;
        
        public function __construct($id = null, $data_source = null){
            parent::__construct('email_template', $id, $data_source);
            $this->_variables = array();
        }
        
        public function set_variables($variables = array()){
            $this->_variables = $variables;
        }
        
        public function pget_subject(){
            return self::replace($this->_data['subject'], $this->_variables);
        }
        
        public function pget_message_plain(){
            return self::replace($this->_data['message_plain'], $this->_variables);
        }
        
        public function pget_message_html(){
            return self::replace($this->_data['message_html'], $this->_variables);
        }
        
        public function get_body(){
            if ($this->message_plain && $this->message_html){
                
                $plain = new \extensions\email\mime("text/plain");
                $plain->add($this->message_plain);
                
                $html = new \extensions\email\mime("text/html");
                $html->add($this->message_html);
                
                $multipart = new \extensions\email\mime('multipart/alternative');
                $multipart->add($plain);
                $multipart->add($html);
                
                return $multipart;
                
            }elseif($this->message_plain){
                
                $plain = new \extensions\email\mime("text/plain");
                $plain->add($this->message_plain);
                
                return $plain;
                
            }elseif($this->message_html){
                
                $html = new \extensions\email\mime("text/html");
                $html->add($this->message_html);
                
                return $html;
            }
            
            return null;
        }
        
        public function send($email_addresses){
            
        }
        
        
        public static function replace($subject, $variables){
            if (is_array($variables) && is_assoc($variables)){
                foreach($variables as $key => $value){
                    $key = str_replace("[", "\\[", $key);
                    $key = str_replace("]", "\\]", $key);
                    $subject = preg_replace("/\{\{$key\}\}/", $value, $subject);
                }
                
                /* Remove any variables remaining */
                $subject = preg_replace("/\{\{[^}]*\}\}/", "", $subject);
            }
            
            return $subject;
        }
        
    }
    
}

?>