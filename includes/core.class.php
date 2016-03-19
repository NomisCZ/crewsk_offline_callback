<?php

class core {

    public static function status_msg ($type, $msg, $showIP = true) {
        $showIP = $showIP == true ? REMOTE_ADDR : 'false';
        
        return json_encode(array('status' => $type, 'msg' => $msg, 'ip' => $showIP));
    }
};