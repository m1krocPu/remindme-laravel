<?php

namespace App\Dictionaries;

class ErrorDictionary
{
    const ERR_BAD_REQUEST = 'ERR_BAD_REQUEST';
    const ERR_INVALID_ACCESS_TOKEN = 'ERR_INVALID_ACCESS_TOKEN';
    const ERR_FORBIDDEN_ACCESS = 'ERR_FORBIDDEN_ACCESS';
    const ERR_NOT_FOUND = 'ERR_NOT_FOUND';
    const ERR_INTERNAL_ERROR = 'ERR_INTERNAL_ERROR';
    const ERR_INVALID_CREDS = 'ERR_INVALID_CREDS';

    const CODE_BAD_REQUEST = 400;
    const CODE_INVALID_ACCESS_TOKEN = 401;
    const CODE_FORBIDDEN_ACCESS = 403;
    const CODE_NOT_FOUND = 404;
    const CODE_INTERNAL_ERROR = 500;

    const MSG_BAD_REQUEST = "invalid value of `type`";
    const MSG_INVALID_ACCESS_TOKEN = 'invalid access token';
    const MSG_FORBIDDEN_ACCESS = "user doesn't have enough authorization";
    const MSG_NOT_FOUND = 'resource is not found';
    const MSG_INTERNAL_ERROR = 'unable to connect into database';
    const MSG_INVALID_CREDS = 'incorrect username or password';

    public static function getStatusCode($err)
    {
        $map = [
            self::ERR_BAD_REQUEST => self::CODE_BAD_REQUEST,
            self::ERR_INVALID_ACCESS_TOKEN => self::CODE_INVALID_ACCESS_TOKEN,
            self::ERR_FORBIDDEN_ACCESS => self::CODE_FORBIDDEN_ACCESS,
            self::ERR_NOT_FOUND => self::CODE_NOT_FOUND,
            self::ERR_INTERNAL_ERROR => self::CODE_INTERNAL_ERROR,
            self::ERR_INVALID_CREDS => self::CODE_INVALID_ACCESS_TOKEN,
        ];

        return !empty($map[$err]) ? $map[$err] : self::CODE_BAD_REQUEST;
    }

    public static function getErrorMessage($err)
    {
        $map = [
            self::ERR_BAD_REQUEST => self::MSG_BAD_REQUEST,
            self::ERR_INVALID_ACCESS_TOKEN => self::MSG_INVALID_ACCESS_TOKEN,
            self::ERR_FORBIDDEN_ACCESS => self::MSG_FORBIDDEN_ACCESS,
            self::ERR_NOT_FOUND => self::MSG_NOT_FOUND,
            self::ERR_INTERNAL_ERROR => self::MSG_INTERNAL_ERROR,
            self::ERR_INVALID_CREDS => self::MSG_INVALID_CREDS,
        ];

        return !empty($map[$err]) ? $map[$err] : null;
    }

    public static function getErrorCode($statusCode)
    {
        $map = [
            self::CODE_BAD_REQUEST => self::ERR_BAD_REQUEST,
            self::CODE_INVALID_ACCESS_TOKEN => self::ERR_INVALID_ACCESS_TOKEN,
            self::CODE_FORBIDDEN_ACCESS => self::ERR_FORBIDDEN_ACCESS,
            self::CODE_NOT_FOUND => self::ERR_NOT_FOUND,
            self::CODE_INTERNAL_ERROR => self::ERR_INTERNAL_ERROR,
        ];

        return !empty($map[$statusCode]) ? $map[$statusCode] : self::ERR_BAD_REQUEST;
    }

}