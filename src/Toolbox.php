<?php

namespace Aplr\Toolbox;

class Toolbox {

    public function publishMigrations($from, $to) {

        $timestamp = date('Y_m_d_His', time());

        return collect(glob("{$path}/*.stub.php"))->mapWithKeys(function ($stub) use ($from, $to, $timestamp) {

            $file = pathinfo($stub);

            return [ "{$from}/{$stub}" => "{$to}/{$timestamp}_{$file['filename']}.php" ];

        })->all();

    }

}