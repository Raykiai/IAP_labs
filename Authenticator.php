<?php

interface Authenticator {
    public function hashPassword();
    public static function isPasswordCorrect($username, $password);
    public function login();
    public static function logout();
    public function createFormErrorSessions();
}
