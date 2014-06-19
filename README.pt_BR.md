ustream-api-client
==================

Cliente para API do ustream.tv para ler e renomear os dados dos vídeos já baixados

Para mais informações sobre a API, leia a documentação do Ustream [aqui](http://developer.ustream.tv/data_api/docs "Acesse a documentação")

### Requerimentos

PHP 5.3 >=

### Configuração

Altere o arquivo ustream-api-client.class.php

```php
$this->origin       = 'path_origin';
$this->destination  = 'path_destination';
$this->path_data    = $this->origin . 'data.json';
$this->url_data     = 'http://api.ustream.tv/json/video/17343201/listAllVideos?key=laborautonomo&limit=100';
$this->format       = 'flv';
```

### Executar

```sh
$ php ustream-api-client.php
```

### Conversão flv para mp3 (opcional)

Os arquivos armazenados no Ustream são baixados no formato FLV. Caso você queira convertê-los para MP3 antes de executar o script `ustream-api-client.php`, copie o arquivo `convert-flv-to-mp3.sh` dentro do diretório FLV e execute o comando:
    
```sh
$ bash convert-flv-to-mp3.sh
```

##### Requerimentos
    
```
# apt-get install ffmpeg libavcodec-extra-53
```