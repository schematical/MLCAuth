<?php
class MJaxAuthSignupEvent extends MJaxEventBase{
	protected $strEventName = 'auth_signup';
	public function Render(){       
        return '';
    }
    public function RenderUnbind(){
        return '';        
    }
}
class MJaxAuthLoginEvent extends MJaxEventBase{
    protected $strEventName = 'auth_login';
    public function Render(){
        return '';
    }
    public function RenderUnbind(){
        return '';
    }
}
