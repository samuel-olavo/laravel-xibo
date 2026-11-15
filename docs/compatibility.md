# Compatibilidade verificada

O gerador foi executado com as especificações oficiais de Xibo CMS 4.0–4.5. A união contém **268 operações** distribuídas por **29 recursos**. Os métodos gerados cobrem as operações de cada ficheiro; `call()` utiliza a especificação do CMS ligado em tempo de execução.

| Ramo Xibo | Formato | Operações | Fonte | SHA-256 do ficheiro usado |
| --- | --- | ---: | --- | --- |
| 4.0 | Swagger 2.0 | 216 | [release40](https://raw.githubusercontent.com/xibosignage/xibo-cms/release40/web/swagger.json) | `38042eea8a89839780d734a5c83827bb732b5013243c7038275037a28376016e` |
| 4.1 | Swagger 2.0 | 224 | [release41](https://raw.githubusercontent.com/xibosignage/xibo-cms/release41/web/swagger.json) | `37918a7cf088479d37cec834cf4bc88dc5c82df86708b20bd8af9f2d4149aeeb` |
| 4.2 | Swagger 2.0 | 229 | [release42](https://raw.githubusercontent.com/xibosignage/xibo-cms/release42/web/swagger.json) | `02a47f5c634543928b0c788727877447fb508788a9955bc2ce9198f1d22eeb14` |
| 4.3 | Swagger 2.0 | 229 | [release43](https://raw.githubusercontent.com/xibosignage/xibo-cms/release43/web/swagger.json) | `44e0d3069262c571df9609aacceb3d418cfa95476595ba0a9d3a053aeb5d4934` |
| 4.4 | Swagger 2.0 | 229 | [release44](https://raw.githubusercontent.com/xibosignage/xibo-cms/release44/web/swagger.json) | `f328dec6915d7e36124726a58dc6a3d15220bdcb1ea99cd46a8c9c596829cd12` |
| 4.5 | OpenAPI 3.0 | 263 | [master](https://raw.githubusercontent.com/xibosignage/xibo-cms/master/web/swagger.json) | `df3edd73b428dd8d3abe9e1fac2dce6bba279331b3e47e8e5dcbc9191df74272` |

O Xibo 4.4 repete dois `operationId` em caminhos distintos. Para não perder essas operações, o catálogo usa o identificador original para o primeiro caminho e `method:path` para o segundo. Por exemplo, `delete:/campaign/layout/remove/{campaignId}` continua acessível por `call()` e por um método gerado.

Estes valores medem a **cobertura da especificação**, não testes de ponta a ponta com um CMS em funcionamento. A versão concreta da instalação pode ter diferenças de patch ou uma especificação personalizada; o pacote lê o `/swagger.json` dessa instalação quando possível. Uma operação só pode ser executada se a versão a expuser e as credenciais tiverem permissão.

Para reproduzir o teste após descarregar os seis ficheiros:

```bash
XIBO_SPEC_FILES=/caminho/4.0.json:/caminho/4.1.json:/caminho/4.2.json:/caminho/4.3.json:/caminho/4.4.json:/caminho/4.5.json vendor/bin/phpunit tests/Feature/ResourceCoverageTest.php
```
