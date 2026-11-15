# Verified compatibility

The resource generator was run against the official Xibo CMS 4.0–4.5 specifications. Together, they contain **268 distinct operations** across **29 resources**. Generated methods cover the operations in each specification; `call()` uses the connected CMS specification at runtime.

| Xibo branch | Format | Operations | Source | SHA-256 of the file used |
| --- | --- | ---: | --- | --- |
| 4.0 | Swagger 2.0 | 216 | [release40](https://raw.githubusercontent.com/xibosignage/xibo-cms/release40/web/swagger.json) | `38042eea8a89839780d734a5c83827bb732b5013243c7038275037a28376016e` |
| 4.1 | Swagger 2.0 | 224 | [release41](https://raw.githubusercontent.com/xibosignage/xibo-cms/release41/web/swagger.json) | `37918a7cf088479d37cec834cf4bc88dc5c82df86708b20bd8af9f2d4149aeeb` |
| 4.2 | Swagger 2.0 | 229 | [release42](https://raw.githubusercontent.com/xibosignage/xibo-cms/release42/web/swagger.json) | `02a47f5c634543928b0c788727877447fb508788a9955bc2ce9198f1d22eeb14` |
| 4.3 | Swagger 2.0 | 229 | [release43](https://raw.githubusercontent.com/xibosignage/xibo-cms/release43/web/swagger.json) | `44e0d3069262c571df9609aacceb3d418cfa95476595ba0a9d3a053aeb5d4934` |
| 4.4 | Swagger 2.0 | 229 | [release44](https://raw.githubusercontent.com/xibosignage/xibo-cms/release44/web/swagger.json) | `f328dec6915d7e36124726a58dc6a3d15220bdcb1ea99cd46a8c9c596829cd12` |
| 4.5 | OpenAPI 3.0 | 263 | [master](https://raw.githubusercontent.com/xibosignage/xibo-cms/master/web/swagger.json) | `df3edd73b428dd8d3abe9e1fac2dce6bba279331b3e47e8e5dcbc9191df74272` |

Xibo 4.4 repeats two `operationId` values on different paths. To preserve both operations, the catalog uses the original identifier for the first path and `method:path` for the second. For example, `delete:/campaign/layout/remove/{campaignId}` remains available through `call()` and a generated method.

These numbers measure **specification coverage**, not end-to-end tests against a running CMS. An installation may have patch-level differences or a customized specification. The package reads its `/swagger.json` when available. An operation can run only if that CMS exposes it and the credentials have permission.

To reproduce the coverage test after downloading the six specification files:

```bash
XIBO_SPEC_FILES=/path/to/4.0.json:/path/to/4.1.json:/path/to/4.2.json:/path/to/4.3.json:/path/to/4.4.json:/path/to/4.5.json vendor/bin/phpunit tests/Feature/ResourceCoverageTest.php
```
