<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
class StorageHelper{
    
    public $storage;

    private $type;
    private $slug;
    public $path;

    
    public function __construct()
    {
        $this->storage = Storage::disk(config('app.file_driver'));
        
    }

    /**設定存放路徑 */
    public static function path(string $type,string $slug){
        
        $storageHelper = new static();

        $storageHelper->type = $type;
        $storageHelper->slug = $slug;
        $storageHelper->path = "/$type/$slug";

        return $storageHelper;
    }


    public function store($file){
        
        try {
            $path = $this->storage->putFile($this->path, $file);
        } catch (\Throwable $th) {
            return false;
        }
        
        return $path;
    }

    public function delete($file){
        $this->storage->delete($file);
    }
    
}

