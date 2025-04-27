<?php

class SimpleMiddleWare{
    public static function validRole($stack){
        debug_log('Checking user role');
        $roles = explode(',',$stack);
        foreach($roles as $role){
            $role = trim($role);
            if($_SESSION['user']['role'] == $role){
                debug_log('Role match!');

                return true;
            }
        }
        debug_log('No permission', 'warning');
        return false;
    }
}
?>