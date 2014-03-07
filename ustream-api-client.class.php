<?php
class UstreamApiClient {
    public $origin;
    public $destination;
    public $format;
    public $path_data;
    public $url_data;
    public $files;

    function __construct() {
        $this->origin       = '/home/fabio/Gravacoes/radio-da-juventude/programas-ustream/';
        $this->destination  = '/home/fabio/Gravacoes/radio-da-juventude/programas-ustream/renamed/';
        $this->path_data    = $this->origin . 'data.json';
        $this->url_data     = 'http://api.ustream.tv/json/video/17343201/listAllVideos?key=laborautonomo&limit=100';
        $this->format       = 'flv';

        $this->files        = $this->list_files();
    }
    
    public function read_data(){
        $data = file_get_contents($this->url_data);
        $json = json_decode($data);
        
        if(!isset($json->version)) return false;
        
        file_put_contents($this->path_data, $data);
        
        return $json;
    }

    public function list_files() {
        $dir = opendir($this -> origin);
        $files = array();

        while ($nome_itens = readdir($dir)) {
            if (in_array($nome_itens, array('.', '..')) || !preg_match('/\.' . $this -> format . '$/i', $nome_itens))
                continue;
            $files[] = $nome_itens;
        }

        return $files;
    }
    
    public function rename_file($file, $title){
        
        $dir = $this->destination . $title;
        if ((!is_dir($dir)))
            mkdir($dir, 0777, true);
        
        $new_file   = "{$dir}/{$title}.{$this->format}";
        
        return copy($this->origin . '/' . $file, $new_file);
    }
    
    public function save_image($url_img, $dest){
        $img = file_get_contents($url_img);
        file_put_contents($dest, $img);
    }

    public function export_files() {
               
        if(!$data = $this->read_data())
            throw new Exception("Can't read data. Please, verify the url data of json \n", 1);
        
        $count = 0;
        $total = count($data->results);
        foreach ($data->results as $video) {
            $count++;
            $percent = intval(($count * 100) / $total);
            
            $file_name = array_values(array_filter($this->files, 
                function($v) use ($video) {
                    return (preg_match('/.*' .$video->sourceChannel->id. '.*' .$video->id. '/i', $v)); 
                } 
            ));
            
            $title  = preg_replace('/(.*) (.*)/i', '$1', $video->createdAt) . '-' . $this->strip_accents(strtolower($video->title));
            
            if(!isset($title_prev)) $title_prev = $title;
            if($title == $title_prev) $title .= "-$count";
            $title_prev = $title; 
            
            echo "$percent% - copiando $title";
            
            if(!$file_name){
                echo " FAIL! \n";
                file_put_contents('error.log', "FAIL: copy({$this->origin}/{$file}, {$new_file});\r\n", FILE_APPEND);
                
                continue;
            }
            
            if(!$this->rename_file($file_name[0], $title)){
                echo " FAIL! \n";
                file_put_contents('error.log', "FAIL: copy({$this->origin}/{$file}, {$new_file});\r\n", FILE_APPEND);
                
                continue;
            }
            
            $dir = $this->destination . $title;
            file_put_contents("{$dir}/{$title}.txt", "title: {$video->title}\r\nyear: " . substr($video->createdAt, 0,4) . "\r\ncomment: $video->description");
            
            $this->save_image($video->imageUrl->medium, "{$dir}/{$title}." . preg_replace('/.*(jpg|jpeg|png|gif)$/i', '$1', $video->imageUrl->medium));
            
            echo " OK \n";
        }

        return true;
    }

    public function strip_accents($string) {
        return str_replace(
            array("&", "ñ", "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Ñ", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", "!", ":", "?", "'", "#", " "), 
            array("e", "n", "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "N", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "", "", "", "", "", "-"), 
            $string
        );
    }

}
