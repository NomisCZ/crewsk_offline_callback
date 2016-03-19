<?php
class hydra {
    protected $ipAddress;

    function __construct() {
        $this->ipAddress = $_SERVER["SERVER_ADDR"];
    }

    public function curlRequest($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function testConn($serverID, $serverKey, $command = 'status') {
        $request = $this->sendCmd($serverID, $command, $serverKey);
        if (@$request['success'] == 'true')
            return true;
        else
            return false;
    }

    public function sendCmd($serverID, $command, $serverKey) {
        $command = urldecode($command);

        $hash = hash ("sha256", $serverID.$command.$this->ipAddress.hash ("sha256", $serverKey));
        $request = $this->curlRequest('http://www.crew.sk/remote/console_execute/?server='.$serverID.'&command='.$command.'&hash='.$hash);

        return $request;
    }

    /**
     * @author Martin Galovic (galovik) <galovikcode@gmail.com>
     */
    public static function command($command = '', $variables = []) {
        foreach ($variables as $key => $value) {
            $command = str_replace(':'.$key, $value, $command);
        }
        return $command;
    }
};