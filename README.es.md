ustream-api-client
==================

Cliente para API del ustream.tv para leer y renombrar los datos de los videos bajados

Más informaciones de la API estan disponibles en la documentación del Ustream [aquí](http://developer.ustream.tv/data_api/docs "Acceder la documentación")

### Requerimientos

PHP 5.3 >=

### Configuración

Cambiar el archivo ustream-api-client.class.php

```php
$this->origin       = 'path_origin';
$this->destination  = 'path_destination';
$this->path_data    = $this->origin . 'data.json';
$this->url_data     = 'http://api.ustream.tv/json/video/17343201/listAllVideos?key=laborautonomo&limit=100';
$this->format       = 'flv';
```

### Ejecutar

```sh
$ php ustream-api-client.php
```

### Conversión de flv para mp3 (opcional)

Los archivos almacenados en Ustream son bajados en lo formato FLV. Si quieres convertir para MP3 antes de ejecutar el script `ustream-api-client.php`, haga una copia del archivo `convert-flv-to-mp3.sh` y pongalo adentro del directório FLV. Después ejecute en la consola:

```sh
$ bash convert-flv-to-mp3.sh
```

##### Requerimientos
    
```
# apt-get install ffmpeg libavcodec-extra-53
```