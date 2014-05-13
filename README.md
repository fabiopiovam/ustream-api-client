ustream-api-client
==================

Client for ustream.tv API to read and rename data of downloaded videos

Read the Ustream API Documentation [here](http://developer.ustream.tv/data_api/docs "Access the documentation")

### Requeriments

PHP 5.3 >=

### Preparing to execution

Alter the ustream-api-client.class.php

    ``` php
    $this->origin       = 'path_origin';
    $this->destination  = 'path_destination';
    $this->path_data    = $this->origin . 'data.json';
    $this->url_data     = 'http://api.ustream.tv/json/video/17343201/listAllVideos?key=laborautonomo&limit=100';
    $this->format       = 'flv';
    ```

### Executing

    ``` sh
    $ php ustream-api-client.php
    ```

### Convert flv to mp3 (optional)

The ustream's downloaded files have flv format. If you want convert to mp3 before execute ustream-api-client, copy the file convert-flv-to-mp3.sh into FLVs folder and execute the bash script:
    
    ``` sh
    $ bash convert-flv-to-mp3.sh
    ```

##### Requeriments
    
    ``` sh
    # apt-get install ffmpeg libavcodec-extra-53
    ```