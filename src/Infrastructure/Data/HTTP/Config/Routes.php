<?php

declare(strict_types=1);

namespace Infrastructure\Data\HTTP\Config;

class Routes
{
    private const string AUTH = '/oauth';
    private const string BATCH = '/batch';

    public const string REGISTER = self::AUTH . '/register';
    public const string AUTHENTICATE = self::AUTH . '/token';

    public const string FIND = self::BATCH . '/find';
    public const string GET_RESULT = self::BATCH . '/result';
    public const string SEND = self::BATCH . '/create';
    public const string SEND_IN_BACKGROUND = self::BATCH . '/create-in-queue';
}