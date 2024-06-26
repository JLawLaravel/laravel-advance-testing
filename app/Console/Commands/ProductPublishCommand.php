<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ProductPublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:product-publish-command {id : The id of the product}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the product';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $product = Product::find($this->argument('id'));
        if (!$product) {
            $this->error('Product not found');
            return -1;
        }
        if ($product->published_at) {
            $this->error('Product already published');
            return -1;
        }
        $product->update(['published_at' => now()]);
        $this->info('Product published successfully');
        return 0;
    }
}
