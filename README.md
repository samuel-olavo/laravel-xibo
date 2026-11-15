# Laravel Xibo

Cliente da API do Xibo CMS para aplicações Laravel 13. O pacote permite usar várias instalações Xibo na mesma aplicação e disponibiliza métodos PHP para as operações documentadas nas especificações oficiais das versões 4.0 a 4.5.

Cada ligação consulta o seu próprio `/swagger.json` para descobrir as operações disponíveis e o formato dos pedidos. Também existe `call()` para operações novas que apareçam numa versão posterior. Consulte a [matriz de compatibilidade](docs/compatibility.md) para saber o que foi verificado.

## Requisitos

- PHP 8.3 ou superior
- Laravel 13
- Xibo CMS 4.0 ou superior, com a API ativa
- Um token de acesso ou uma aplicação OAuth com `client_id` e `client_secret`

## Instalação

Enquanto o pacote estiver apenas no GitHub, adicione o repositório à aplicação Laravel e instale a versão de desenvolvimento:

```bash
composer config repositories.laravel-xibo vcs https://github.com/samuel-olavo/laravel-xibo
composer require samuel-olavo/laravel-xibo:dev-main
php artisan vendor:publish --tag=xibo-config
```

O Laravel descobre o `XiboServiceProvider` automaticamente. Se o pacote vier a ser publicado no Packagist com uma versão estável, bastará `composer require samuel-olavo/laravel-xibo`.

Para usar uma cópia local durante o desenvolvimento, substitua o primeiro comando por:

```bash
composer config repositories.laravel-xibo path "/caminho/para/laravel-xibo"
```

## Configurar uma ligação

Após publicar a configuração, edite `config/xibo.php`. O exemplo seguinte configura duas instalações independentes:

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

No `.env` da aplicação, defina os valores correspondentes. O endereço deve apontar para a raiz do CMS, sem `/api`:

```dotenv
XIBO_DEFAULT_CONNECTION=main
XIBO_MAIN_URL=https://cms.exemplo.pt
XIBO_MAIN_VERSION=4.5
XIBO_MAIN_CLIENT_ID=identificador_da_aplicacao
XIBO_MAIN_CLIENT_SECRET=segredo_da_aplicacao

XIBO_SECOND_URL=https://outro-cms.exemplo.pt
XIBO_SECOND_VERSION=4.4
XIBO_SECOND_CLIENT_ID=identificador_da_segunda_aplicacao
XIBO_SECOND_CLIENT_SECRET=segredo_da_segunda_aplicacao
```

Com `client_id` e `client_secret`, o pacote obtém o token pelo fluxo OAuth `client_credentials`, guarda-o no cache Laravel até perto do prazo de expiração e renova-o quando necessário. Também pode definir `XIBO_MAIN_TOKEN` para usar um token já existente; nesse caso, o pacote não consegue renová-lo automaticamente. Se configurar ambos, o token fornecido tem prioridade. Guarde as credenciais apenas no `.env` da aplicação.

O valor de `version` é declarado por ligação e serve para diagnóstico. **Não escolhe uma lista fixa de operações.** A lista real vem do `/swagger.json` da instalação. Se esse endereço não estiver acessível, `specification_path` pode apontar para uma especificação JSON local. Sem especificação, ainda pode usar `request()` com um caminho direto da API.

## Usar a API

O método `connection()` sem argumento usa a ligação definida em `default`. Para escolher outra, passe o nome configurado:

```php
use SamuelOlavo\LaravelXibo\Facades\Xibo;

$layouts = Xibo::connection()->layout()->layoutSearch([
    'query' => ['layout' => 'Promoção'],
])->json();

$status = Xibo::connection('second')->layout()->layoutStatus([
    'path' => ['layoutId' => 42],
])->json();
```

Os métodos de recurso correspondem aos `operationId` da especificação Xibo. Por exemplo, `layout()->layoutSearch()` e `library()->libraryAdd()` usam a operação adequada da versão ligada. Os recursos disponíveis incluem layouts, ecrãs, campanhas, biblioteca, playlists, agendamentos, utilizadores e outros grupos documentados pela API.

Todos os métodos aceitam um array com estas chaves, conforme a operação:

| Chave | Utilização |
| --- | --- |
| `path` | Valores dos parâmetros incluídos no caminho, como `layoutId` |
| `query` | Filtros, paginação e outros parâmetros da URL |
| `headers` | Cabeçalhos adicionais exigidos pela operação |
| `body` | Campos de formulário ou dados JSON |
| `files` | Ficheiros para operações multipart |
| `sink` | Caminho ou stream onde guardar uma resposta descarregada |

O resultado permite consultar `status()`, `headers()`, `body()` e `json()`:

```php
$response = Xibo::connection('main')->display()->displaySearch([
    'query' => ['display' => 'Receção'],
]);

$displays = $response->json();
$status = $response->status();
```

Para chamar uma operação pelo seu identificador, incluindo uma operação nova ainda sem método PHP gerado:

```php
$response = Xibo::connection('main')->call('displaySearch', [
    'query' => ['display' => 'Receção'],
]);
```

Para usar um caminho relativo à API sem consultar a especificação:

```php
$response = Xibo::connection('main')->request('GET', '/display', [
    'query' => ['display' => 'Receção'],
]);
```

### Enviar e descarregar ficheiros

Os nomes dos campos devem coincidir com os da especificação da sua instalação. Na operação `libraryAdd`, o campo do ficheiro chama-se `files`:

```php
$media = Xibo::connection('main')->library()->libraryAdd([
    'files' => ['files' => storage_path('app/imagem.png')],
    'body' => ['name' => 'Imagem da campanha'],
])->json();
```

Para guardar diretamente um CSV, indique um caminho gravável em `sink`:

```php
Xibo::connection('main')->call('dataSetExportCsv', [
    'path' => ['dataSetId' => 7],
    'sink' => storage_path('app/exports/dataset.csv'),
]);
```

### Tratar erros

Uma operação ausente da especificação da instalação lança `OperationUnavailable`. Problemas de autenticação lançam `AuthenticationFailed`. Se o CMS devolver uma resposta HTTP sem sucesso, o pacote lança `XiboRequestFailed` e mantém os detalhes da resposta:

```php
use SamuelOlavo\LaravelXibo\Exceptions\XiboRequestFailed;

try {
    $response = Xibo::connection('main')->display()->displaySearch();
} catch (XiboRequestFailed $error) {
    logger()->warning('Pedido ao Xibo falhou', [
        'status' => $error->status(),
        'details' => $error->response()->json(),
    ]);
}
```

Consulte o `/swagger.json` **da sua instalação** para confirmar os parâmetros, as permissões e as operações dessa versão. O pacote valida os campos obrigatórios descritos na especificação, mas a autorização de cada operação continua a depender do CMS.

## Testes e limites

Para executar os testes do pacote:

```bash
composer install
vendor/bin/phpunit
```

Os métodos gerados cobrem as **268 operações distintas** encontradas nas especificações oficiais Xibo 4.0–4.5 analisadas. `call()` pode usar operações futuras quando o CMS as publicar em `/swagger.json`, sem prometer compatibilidade antecipada com versões ainda não testadas.

O pacote é um cliente da API. Não cria rotas, interface administrativa, base de dados local nem sincronização de conteúdos. A aplicação Laravel decide como apresentar os dados e controlar o acesso. Os testes automatizados verificam o cliente e a cobertura das especificações; falta validar a integração de ponta a ponta com um CMS Xibo real e credenciais próprias.

## Licença

[MIT](LICENSE).
