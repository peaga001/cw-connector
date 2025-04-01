# CW-Connector

**CW-Connector** é uma aplicação desenvolvida para facilitar a comunicação com o serviço de cálculo de horas ClockWise. <br>
A ferramenta foi projetada para ser simples, eficiente e altamente configurável.

## 🚀 Funcionalidades

- Envio de lote com retorno imediato.
- Envio de lote em background.
- Consulta pelo status de um determinado lote.
- Busca pelos resultados de um lote processado em fila.

---

## 🔧 Como Usar

### Comunicação via API

Para comunicação via API serão necessários 2 parâmetros, **API_KEY** e **BASE_URL**.

```php
use CwConnector\Infrastructure\Data\HTTP\Config\APIConfig;
use \CwConnector\Infrastructure\Data\HTTP\HTTPRepository;
use CwConnector\Infrastructure\Data\HTTP\Clients\Guzzle;

$HTTPRepository = new HTTPRepository(
    client: Guzzle::create(
        config: new APIConfig(
            baseUrl: env('CW_BASE_URL'), 
            apiKey: env('API_KEY')
        )
    )
);

```

### Criando um Batch (Lote)

```php
use CwConnector\Domain\ValueObjects\TimeEntry;
use CwConnector\Domain\ValueObjects\PersonId;
use CwConnector\Domain\Enums\DocumentTypes;
use CwConnector\Domain\Entities\TimeSheet;
use CwConnector\Domain\Entities\Config;
use CwConnector\Domain\Entities\Batch;

$personIdFoo = PersonId::create(
    documentType: DocumentTypes::EMPLOYEE_ID, documentNumber: '123456' 
);

$configFoo = Config::fill(properties: ['free_coffee' => true]);

$timeEntry1 = TimeEntry::create(date: '2025-01-01', hours: '08:00:00');
$timeEntry2 = TimeEntry::create(date: '2025-01-01', hours: '12:00:00');

$timeSheetFoo = TimeSheet::create(
    timeEntries: [$timeEntry1, $timeEntry2],
    person: $personIdFoo,
    config: $configFoo  
);

$personIdBxx = PersonId::create(
    documentType: DocumentTypes::CPF, documentNumber: '123456' 
);

$configBxx = Config::fill(properties: ['is_flexible' => false])

$timeSheetBxx = TimeSheet::create(
    timeEntries: [$timeEntry1, $timeEntry2],
    person: $personIdBxx,
    config: $configBxx
)

$batchBzz = Batch::create(timeSheets: [$timeSheetFoo, $timeSheetBxx])
```

### Utilizando o Manager

```php
use CwConnector\Infrastructure\Translators\FortimeTranslator;
use CwConnector\Infrastructure\Data\HTTP\HTTPRepository;
use CwConnector\Manager\ClockWiseManager;
use CwConnector\Domain\Entities\Batch;

$batchAbc = new Batch();
$repositoryEfg = new HTTPRepository();
$translatorGhf = new FortimeTranslator();

$manager = new ClockWiseManager(
    repository: $repositoryXwz,
    translator: $translator
);

$manager->send($batchAbc);
$manager->sendInBackground($batchAbc);
$manager->getCurrentStatus($batchAbc->batchId());
$manager->getResults($batchAbc->batchId());
```

---

## 🧪 Testes

Para rodar os testes unitários, use o PHPUnit:

```bash
composer test
```

Verificar o coverage do projeto:

```bash
composer coverage
```

>Certifique-se de que todos os testes passam antes de criar um pull request!

---

## 📄 Licença

Este projeto pertence a **For People Softwares**.

---

## 🤝 Autor

Desenvolvido por [Pedro Barros](https://github.com/peaga001).