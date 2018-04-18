<?php

namespace Aplr\Toolbox;

use Illuminate\Support\Facades\Request;

class Uniq {

    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function generate($length = 10)
    {
        $timestamp = round(microtime(true) * 1000);
        $machineId =  $this->generateMachineId();
        $randomInt = random_int(0, PHP_INT_MAX);
        
        if (!is_null($this->config['machine_id'])) {
            $machineId = $this->config['machine_id'];
        }

        $uniq = "{$timestamp}.{$machineId}.{$randomInt}";
        $hash = hash('sha1', $uniq);
        $base = base64_encode($hash);

        return substr($base, 0, $length);
    }

    private function generateMachineId()
    {
        $ip = Request::server('SERVER_ADDR');
        
        return hash('sha1', $ip);
    }

}