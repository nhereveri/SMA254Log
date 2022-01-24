# SMA254Log

API para tabla de log para distribución SMA254.

## Instalación

Instalar paquete `airviro/sma254log`.

```sh
composer require airviro/sma254log
```

Agregar `SMA254LogServiceProvider` en la configuración de la aplicación `config/app.php`.

```php
'providers' => [
	…
	Airviro\SMA254Log\SMA254LogServiceProvider::class,
	…
]
```

Migrar la nueva tabla `SMA254LOG`.

```sh
php artisan migrate
```

Insertar registros en la tabla de logs mediante la distribución SMA254. _Requiere configurar una estación de distribución_. En el ejemplo existe la estación `ZZ0` ya configurada para registros cada minuto.

```sh
xprSMA254 /dev/null ZZ0 `date -d "25 minutes ago" +%y%m%d%H%M`
```

## Configuración

Opcionalmente puedes especificar la opción de paginación a la configuración de entorno `.env`.

```conf
SMA254LOG_PAGINATION=100
```

## Uso de la API para los logs

El API requiere al menos especificar los códigos de UF y proceso.

- `/api/sma254log/{ufID}/{procesoID}`
- `/api/sma254log/{ufID}/{procesoID}/{dispositivoID}`
- `/api/sma254log/{ufID}/{procesoID}/{dispositivoID}/{parametroNombre}`
- `/api/sma254log/{ufID}/{procesoID}/{dispositivoID}/{parametroNombre}/{fromTimestamp}`
- `/api/sma254log/{ufID}/{procesoID}/{dispositivoID}/{parametroNombre}/{fromTimestamp}/{toTimestamp}`
- `/api/sma254log/{ufID}/{procesoID}/{dispositivoID}/{parametroNombre}/{fromTimestamp}/{toTimestamp}/highcharts`

La API retorna un JSON con los datos disponibles a través de la propiedad `data`. Los datos están paginados y pueden ser consultados utilizando las propiedades `next_page_url` y `prev_page_url`.