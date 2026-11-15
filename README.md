# Laravel Xibo

A Xibo CMS API client for Laravel 13. Use multiple Xibo installations in one application and call the operations documented in the official Xibo 4.0–4.5 API specifications through named PHP methods.

Each connection loads its CMS's `/swagger.json` to discover the operations and request formats available on that installation. The generic `call()` method also supports new operations exposed by later CMS versions. See the [compatibility matrix](docs/compatibility.md) for the specifications checked so far.

## Requirements

- PHP 8.3 or later
- Laravel 13
- Xibo CMS 4.0 or later with its API enabled
- An access token or an OAuth application with a `client_id` and `client_secret`

## Installation

Install the package from Packagist and publish its configuration file:

```bash
composer require samuel-olavo/laravel-xibo
php artisan vendor:publish --tag=xibo-config
```

Laravel discovers `XiboServiceProvider` automatically.

To install a local checkout during development, configure a Composer path repository before running `composer require`:

```bash
composer config repositories.laravel-xibo path "/path/to/laravel-xibo"
composer require samuel-olavo/laravel-xibo
```

## Configure connections

After publishing the configuration, edit `config/xibo.php`. This example defines two independent CMS connections:

```php
return [
    'default' => env('XIBO_DEFAULT_CONNECTION', 'main'),
    'connections' => [
        'main' => [
            'url' => env('XIBO_MAIN_URL'),
            'version' => env('XIBO_MAIN_VERSION'),
            'client_id' => env('XIBO_MAIN_CLIENT_ID'),
            'client_secret' => env('XIBO_MAIN_CLIENT_SECRET'),
            'token' => env('XIBO_MAIN_TOKEN'),
            'specification_path' => env('XIBO_MAIN_SPECIFICATION_PATH'),
        ],
        'second' => [
            'url' => env('XIBO_SECOND_URL'),
            'version' => env('XIBO_SECOND_VERSION'),
            'client_id' => env('XIBO_SECOND_CLIENT_ID'),
            'client_secret' => env('XIBO_SECOND_CLIENT_SECRET'),
            'token' => env('XIBO_SECOND_TOKEN'),
            'specification_path' => env('XIBO_SECOND_SPECIFICATION_PATH'),
        ],
    ],
];
```

Set the corresponding values in your application's `.env`. Each URL must point to the CMS root, without `/api`:

```dotenv
XIBO_DEFAULT_CONNECTION=main
XIBO_MAIN_URL=https://cms.example.com
XIBO_MAIN_VERSION=4.5
XIBO_MAIN_CLIENT_ID=your_application_id
XIBO_MAIN_CLIENT_SECRET=your_application_secret

XIBO_SECOND_URL=https://other-cms.example.com
XIBO_SECOND_VERSION=4.4
XIBO_SECOND_CLIENT_ID=your_second_application_id
XIBO_SECOND_CLIENT_SECRET=your_second_application_secret
```

With `client_id` and `client_secret`, the package obtains a token through the OAuth `client_credentials` flow, caches it using Laravel's cache until shortly before expiry, and renews it when needed. You can instead set `XIBO_MAIN_TOKEN` to use an existing token; the package cannot renew a supplied token. If you configure both, the supplied token takes precedence. Keep credentials in your application's `.env` file.

The `version` value is declared per connection for diagnostics. It does **not** select a fixed operation list. The available operations come from that installation's `/swagger.json`. If that endpoint is unavailable, `specification_path` can point to a local JSON specification. Without a specification, you can still use `request()` with a direct API path.

## Use the API

Calling `connection()` without an argument uses the configured `default` connection. Pass a configured name to select another CMS:

```php
use SamuelOlavo\LaravelXibo\Facades\Xibo;

$layouts = Xibo::connection()->layout()->layoutSearch([
    'query' => ['layout' => 'Promotion'],
])->json();

$status = Xibo::connection('second')->layout()->layoutStatus([
    'path' => ['layoutId' => 42],
])->json();
```

Named resource methods correspond to Xibo specification `operationId` values. For example, `layout()->layoutSearch()` and `library()->libraryAdd()` resolve the matching operation on the connected CMS. Resources include layouts, displays, campaigns, library items, playlists, schedules, users, and the other API groups covered by the specifications.

Every operation method accepts an array with the following keys when applicable:

| Key | Purpose |
| --- | --- |
| `path` | Values for path parameters such as `layoutId` |
| `query` | URL filters, pagination, and other query parameters |
| `headers` | Additional headers required by the operation |
| `body` | Form fields or JSON data |
| `files` | Files for multipart requests |
| `sink` | A writable path or stream for a downloaded response |

The response exposes `status()`, `headers()`, `body()`, and `json()`:

```php
$response = Xibo::connection('main')->display()->displaySearch([
    'query' => ['display' => 'Reception'],
]);

$displays = $response->json();
$status = $response->status();
```

Call an operation by its identifier, including a new operation that does not yet have a generated PHP method:

```php
$response = Xibo::connection('main')->call('displaySearch', [
    'query' => ['display' => 'Reception'],
]);
```

Use a path relative to the Xibo API without loading a specification:

```php
$response = Xibo::connection('main')->request('GET', '/display', [
    'query' => ['display' => 'Reception'],
]);
```

### Upload and download files

Field names must match the connected CMS specification. For `libraryAdd`, the file field is named `files`:

```php
$media = Xibo::connection('main')->library()->libraryAdd([
    'files' => ['files' => storage_path('app/image.png')],
    'body' => ['name' => 'Campaign image'],
])->json();
```

To save a CSV response directly, provide a writable destination through `sink`:

```php
Xibo::connection('main')->call('dataSetExportCsv', [
    'path' => ['dataSetId' => 7],
    'sink' => storage_path('app/exports/dataset.csv'),
]);
```

### Handle errors

An operation missing from the connected CMS specification throws `OperationUnavailable`. Authentication failures throw `AuthenticationFailed`. An unsuccessful CMS response throws `XiboRequestFailed` and retains the response details:

```php
use SamuelOlavo\LaravelXibo\Exceptions\XiboRequestFailed;

try {
    $response = Xibo::connection('main')->display()->displaySearch();
} catch (XiboRequestFailed $error) {
    logger()->warning('Xibo request failed', [
        'status' => $error->status(),
        'details' => $error->response()->json(),
    ]);
}
```

Check **your installation's** `/swagger.json` for the parameters, permissions, and operations available in its version. The package validates required fields described by the specification; the CMS still controls authorization for each operation.

## Tests and limitations

Run the package tests with:

```bash
composer install
vendor/bin/phpunit
```

The generated methods cover the **268 distinct operations** found in the official Xibo 4.0–4.5 specifications examined. `call()` can use future operations when a CMS exposes them in `/swagger.json`; compatibility with untested versions cannot be guaranteed in advance.

This package is an API client. It does not create application routes, an administration interface, a local content database, or content synchronization. Your Laravel application decides how to present the data and control access. Automated tests check the client and specification coverage, but end-to-end integration with a live Xibo CMS and its credentials remains to be tested.

## License

[MIT](LICENSE).
