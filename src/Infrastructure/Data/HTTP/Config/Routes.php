<?php

declare(strict_types=1);

namespace CwConnector\Infrastructure\Data\HTTP\Config;

/**
 * The Routes class defines a collection of constant route paths used in the application for authentication
 * and batch operations. The routes are categorized under two main groups - AUTH and BATCH.
 *
 * AUTH group:
 * - REGISTER: Defines the endpoint for user registration.
 * - AUTHENTICATE: Specifies the endpoint for obtaining authentication tokens.
 *
 * BATCH group:
 * - FIND: Designates the endpoint for locating specific batch operations.
 * - GET_RESULT: Specifies the endpoint for retrieving the results of batch operations.
 * - SEND: Represents the endpoint for creating a new batch operation.
 * - SEND_IN_BACKGROUND: Defines the endpoint for queue-based batch operation creation.
 */
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