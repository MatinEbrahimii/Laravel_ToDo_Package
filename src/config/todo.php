<?php

return [
    /**
     * The life time of tokens in seconds.
     */
    'token_ttl' => 120,

    /**
     * The rules to validate the the receiver address.
     * Usually it is an email address, but maybe a phone number.
     */
    'address_validation_rules' => ['required', 'email'],

    /**
     * Here you determine if you are ok with using the routes
     * defined within the package or you want to define them.
     */
    'use_default_routes' => true,

    /**
     * Here you can specify the middlewares to be applied on
     * the routes, which the package has provided for you.
     */
    'route_middlewares' => ['api'],

    /**
     * You can define a prefix for the urls to avoid conflicts.
     * Note: the prefix should NOT end in a slash / character.
     */
    'route_prefix_url' => '/tokenized-login',

    /**
     * Notification class used to send the token.
     * You may define your own token sender class.
     */
    // 'token_sender' => \Imanghafoori\TokenizedLogin\TokenSender::class,

    // /**
    //  * You can change the way you generate the token by define you own class.
    //  */
    // 'token_generator' => \Imanghafoori\TokenizedLogin\TokenGenerators\TokenGenerator::class,

    // /**
    //  * You can extend Responses class and override
    //  * it's methods, to define your own responses.
    //  */
    // 'responses' => \Imanghafoori\TokenizedLogin\Http\Responses\Responses::class,

    // /**
    //  * You can change the way you fetch the user from your database
    //  * by defining a custom user provider class, and set it here.
    //  */
    // 'user_provider' => \Imanghafoori\TokenizedLogin\UserProvider::class,

    /**
     * You may provide a middleware throttler to throttle
     * the requesting and submission of the tokens.
     */
    'throttler_middleware' => 'throttle:3,1',
];