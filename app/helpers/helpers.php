<?php

use Illuminate\Support\Facades\Crypt;

function encryptMessage($message, $key)
{
    return openssl_encrypt($message, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
}

function decryptMessage($encryptedMessage, $key)
{
    return openssl_decrypt($encryptedMessage, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
}
