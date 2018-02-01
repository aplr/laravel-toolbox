<?php

namespace Aplr\Toolbox;

class Toolbox {

    public function publishMigrations(string $from, string $to) {

        $timestamp = date('Y_m_d_His', time());

        return collect(glob("{$from}/*.stub.php"))->mapWithKeys(function ($stub) use ($from, $to, $timestamp) {

            $file = pathinfo($stub);

            return [ "{$from}/{$stub}" => "{$to}/{$timestamp}_{$file['filename']}.php" ];

        })->all();

    }

}