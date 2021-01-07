<?php

namespace App\Console\Commands;

use App\Helpers\StorageHelper;
use App\Product;
use App\UploadProductDescriptionImageLog;
use Illuminate\Console\Command;

class CleanUselessProductDescriptionImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanUselessProductDescriptionImage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all image file which url is not included in product description text.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rows = UploadProductDescriptionImageLog::all();
        $dict = [];
        $storageHelper = new StorageHelper();
        foreach ($rows as $row) {
            $description = '';
            if(isset($dict[$row->sku])){
                $description = $dict[$row->sku];
            }else{
                if(!$product = Product::where('sku',$row->sku)->first()){
                    $dict[$product->sku] = '';
                }
                $dict[$product->sku] = $product->description;
                $description = $product->description;
            }

            if(strpos($description,$row->imageUrl) === false){
                $storageHelper->delete($row->imagePath);
                $row->forceDelete();
                $this->info('Product '. $row->sku .' Deleting image ' . $row->imageUrl);
            }

        }
        $this->info('Cleanning complete.');
    }
}
