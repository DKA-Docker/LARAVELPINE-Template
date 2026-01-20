<?php

declare(strict_types=1);

return [
    /*
     * ------------------------------------------------------------------------
     * Default Firebase project
     * ------------------------------------------------------------------------
     */

    'default' => env('FIREBASE_PROJECT', 'app'),

    /*
     * ------------------------------------------------------------------------
     * Firebase project configurations
     * ------------------------------------------------------------------------
     */

    'projects' => [
        'app' => [

            /*
             * ------------------------------------------------------------------------
             * Credentials / Service Account
             * ------------------------------------------------------------------------
             *
             * In order to access a Firebase project and its related services using a
             * server SDK, requests must be authenticated. For server-to-server
             * communication this is done with a Service Account.
             *
             * If you don't already have generated a Service Account, you can do so by
             * following the instructions from the official documentation pages at
             *
             * https://firebase.google.com/docs/admin/setup#initialize_the_sdk
             *
             * Once you have downloaded the Service Account JSON file, you can use it
             * to configure the package.
             *
             * If you don't provide credentials, the Firebase Admin SDK will try to
             * auto-discover them
             *
             * - by checking the environment variable FIREBASE_CREDENTIALS
             * - by checking the environment variable GOOGLE_APPLICATION_CREDENTIALS
             * - by trying to find Google's well known file
             * - by checking if the application is running on GCE/GCP
             *
             * If no credentials file can be found, an exception will be thrown the
             * first time you try to access a component of the Firebase Admin SDK.
             *
             */

            'credentials' => [
                "type"=>"service_account",
                "project_id"=>"hndgs-65ce6",
                "private_key_id"=>"7a18f45333d60e3f3d7aa5096d180d8b00b176e7",
                "private_key"=>"-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCsHrN+6G2grDYO\nASnf2ZbuDmWmQxL6VYOlfMvV/I9ee3WK76vLZbkKcqltJBVZ3twaUN0qmkpooXgX\nx8W3/mZOvB/sa4jFL/dxVlVLaBdhSyGxOL4yOl/QpHsUKvrpO+sZd9vZXrPrhw2h\njeRlM8cbbyKv6uHESubQThXie52ozntFqUGx3gEB0dydDFVGEaXqAtz6Hd01c9PL\nIkuuzfrllbpqAEaiON4H93Ndk+Mr4B8jFkTa4LtC8+dBi/gcYxcJmVq2HXZEMnXt\nF4LIpFWX5RAdE5K2PoO8zPiv33WupxcWlH3hZrmjAyj1PWMK/M/TXZqDH8E2KNVz\nJGE6tZlbAgMBAAECggEAFZcjo0Y1m44umP11YBKJImMk8MEA1u0LfqKTu8vFZ4Ur\naUUHiD6XgmOACY7urLTOEvD/epIbG6/cLXjOPkvHpUBnmBOkdukS7CEibDs/lOFE\noINCfHDNHGdy1u9N78bShqx9zpuuDFvcY7O1qX+KuNAX36L3if9un5pD7YKIdChU\ngpbpsFOZo80iXU1ve7x44xY47y3h6hEID1nIs6rj1Xyp6rPdpc5Hat+gasuQdyUe\nFljL2hNz9gtXM417IAHYqlJG+Uk1qIQrDa6TrFiVjm8a/52iFkaRemWtIouIUAkK\nhdzngF0H8dPMBboIk0n3pkMOD+ptkWFy51AWQogHuQKBgQDTi8KsAxyq4swLk8k1\nIDNL6lFIszln2mO6ArUT3DP5Tw0HsHIGmg+54MoKAqiIH3TyUCdyvlrRTulnM1E6\nfHkblBDswHGiP5eSWAw/c3vkH7P7RwO0en8gNZZhf++s6yilf0xxuvl+k8cGHT+4\n2e9ogaxdW0igTzIAJrZCoUlkyQKBgQDQSf6zD7OsCRC93bVNpinGYuSna8NebCJ8\nNK+WRI6X3B4E8zQL1yXj9nZJXbOpz8Z8sJayl0eIh9g+CpCVhXoISKKtSBwUpzm/\n4miDIvOfLYcP52cwmO4vVS/Dv1k5j/tckahdHf87tR4RzdJhcVsfHj9KkVLUPZH/\nNzv14SqTAwKBgGXW/IrOnLhvoodYSB75N3iufx8emN40NppPv1imQ6cbtUwkV2By\nPmvfmaQkD3oomqYkjDkjBpmJAbga7lnXnn32VAeFxa60KoXbOVo6gEQcNwsa7t+t\nsRGSeqjJbFq0gsbZd7Wwq3eSMNfysMCOukB3XME8tsPmHE4SVN/SwYBxAoGAc+O3\nwwlJfr7MgdeJuNprA+aiMkTTPwYLafAmggVDEVt3mGl4292pR10qE0f/XswsM9RN\nBLEHK//pYRuftpG9hD5lxOQKO7OPfiQK4mvgAQDj1QV7dJ6iZ9ON7+vXSR/DS43/\nj0/RYvcy89UA6RaZDIdXz7Vr0IsxYD7rLbNKbOECgYEAkXzlJu7LsBwsmKTxfDp1\nmdQAGckzmc8bTVCo0pNSl+4WNayf3zsd8PBz58jzqovUEqgxtsRGAAajL8F06eRJ\nYdwpwGT2s8oEpn7N/3yB5Dv9CmbUMUc/YnNiIOK9EUUiKO0rqNrr/2g5Jr6ly7Bf\nnjLQLcIIgp/eAqxsIfEKB3M=\n-----END PRIVATE KEY-----\n",
                "client_email"=>"firebase-adminsdk-fbsvc@hndgs-65ce6.iam.gserviceaccount.com",
                "client_id"=>"110921645829009010176",
                "auth_uri"=>"https://accounts.google.com/o/oauth2/auth",
                "token_uri"=>"https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url"=>"https://www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url"=>"https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-fbsvc%40hndgs-65ce6.iam.gserviceaccount.com",
                "universe_domain"=>"googleapis.com"
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Auth Component
             * ------------------------------------------------------------------------
             */

            'auth' => [
                'tenant_id' => env('FIREBASE_AUTH_TENANT_ID'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firestore Component
             * ------------------------------------------------------------------------
             */

            'firestore' => [

                /*
                 * If you want to access a Firestore database other than the default database,
                 * enter its name here.
                 *
                 * By default, the Firestore client will connect to the `(default)` database.
                 *
                 * https://firebase.google.com/docs/firestore/manage-databases
                 */

                // 'database' => env('FIREBASE_FIRESTORE_DATABASE'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Realtime Database
             * ------------------------------------------------------------------------
             */

            'database' => [

                /*
                 * In most of the cases the project ID defined in the credentials file
                 * determines the URL of your project's Realtime Database. If the
                 * connection to the Realtime Database fails, you can override
                 * its URL with the value you see at
                 *
                 * https://console.firebase.google.com/u/1/project/_/database
                 *
                 * Please make sure that you use a full URL like, for example,
                 * https://my-project-id.firebaseio.com
                 */

                'url' => env('FIREBASE_DATABASE_URL'),

                /*
                 * As a best practice, a service should have access to only the resources it needs.
                 * To get more fine-grained control over the resources a Firebase app instance can access,
                 * use a unique identifier in your Security Rules to represent your service.
                 *
                 * https://firebase.google.com/docs/database/admin/start#authenticate-with-limited-privileges
                 */

                // 'auth_variable_override' => [
                //     'uid' => 'my-service-worker'
                // ],

            ],

            'dynamic_links' => [

                /*
                 * Dynamic links can be built with any URL prefix registered on
                 *
                 * https://console.firebase.google.com/u/1/project/_/durablelinks/links/
                 *
                 * You can define one of those domains as the default for new Dynamic
                 * Links created within your project.
                 *
                 * The value must be a valid domain, for example,
                 * https://example.page.link
                 */

                'default_domain' => env('FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Cloud Storage
             * ------------------------------------------------------------------------
             */

            'storage' => [

                /*
                 * Your project's default storage bucket usually uses the project ID
                 * as its name. If you have multiple storage buckets and want to
                 * use another one as the default for your application, you can
                 * override it here.
                 */

                'default_bucket' => env('FIREBASE_STORAGE_DEFAULT_BUCKET'),

            ],

            /*
             * ------------------------------------------------------------------------
             * Caching
             * ------------------------------------------------------------------------
             *
             * The Firebase Admin SDK can cache some data returned from the Firebase
             * API, for example Google's public keys used to verify ID tokens.
             *
             */

            'cache_store' => env('FIREBASE_CACHE_STORE', 'file'),

            /*
             * ------------------------------------------------------------------------
             * Logging
             * ------------------------------------------------------------------------
             *
             * Enable logging of HTTP interaction for insights and/or debugging.
             *
             * Log channels are defined in config/logging.php
             *
             * Successful HTTP messages are logged with the log level 'info'.
             * Failed HTTP messages are logged with the log level 'notice'.
             *
             * Note: Using the same channel for simple and debug logs will result in
             * two entries per request and response.
             */

            'logging' => [
                'http_log_channel' => env('FIREBASE_HTTP_LOG_CHANNEL'),
                'http_debug_log_channel' => env('FIREBASE_HTTP_DEBUG_LOG_CHANNEL'),
            ],

            /*
             * ------------------------------------------------------------------------
             * HTTP Client Options
             * ------------------------------------------------------------------------
             *
             * Behavior of the HTTP Client performing the API requests
             */

            'http_client_options' => [

                /*
                 * Use a proxy that all API requests should be passed through.
                 * (default: none)
                 */

                'proxy' => env('FIREBASE_HTTP_CLIENT_PROXY'),

                /*
                 * Set the maximum amount of seconds (float) that can pass before
                 * a request is considered timed out
                 *
                 * The default time out can be reviewed at
                 * https://github.com/kreait/firebase-php/blob/6.x/src/Firebase/Http/HttpClientOptions.php
                 */

                'timeout' => env('FIREBASE_HTTP_CLIENT_TIMEOUT'),

                'guzzle_middlewares' => [
                    // MyInvokableMiddleware::class,
                    // [MyMiddleware::class, 'static_method'],
                ],
            ],
        ],
    ],
];
