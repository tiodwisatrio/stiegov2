<?php

namespace App\Observers;

use App\Models\ProductVariant;

class ProductVariantObserver
{
    /**
     * Handle the ProductVariant "created" event.
     */
    public function created(ProductVariant $productVariant): void
    {
        // Check product stock setelah variant baru dibuat
        $this->checkProductStock($productVariant);
    }

    /**
     * Handle the ProductVariant "updated" event.
     */
    public function updated(ProductVariant $productVariant): void
    {
        // Hanya check jika stock berubah
        if ($productVariant->wasChanged('stock')) {
            $this->checkProductStock($productVariant);
        }
    }

    /**
     * Handle the ProductVariant "deleted" event.
     */
    public function deleted(ProductVariant $productVariant): void
    {
        // Check product stock setelah variant dihapus
        $this->checkProductStock($productVariant);
    }

    /**
     * Handle the ProductVariant "restored" event.
     */
    public function restored(ProductVariant $productVariant): void
    {
        // Check product stock setelah variant di-restore
        $this->checkProductStock($productVariant);
    }

    /**
     * Handle the ProductVariant "force deleted" event.
     */
    public function forceDeleted(ProductVariant $productVariant): void
    {
        // Check product stock setelah variant force deleted
        $this->checkProductStock($productVariant);
    }

    /**
     * Check product stock dan auto archive/restore
     */
    private function checkProductStock(ProductVariant $productVariant): void
    {
        $product = $productVariant->product;

        if (!$product) {
            return;
        }

        // Auto-archive jika stock habis
        $product->autoArchiveIfOutOfStock();

        // Auto-restore jika ada stock lagi
        $product->autoRestoreIfHasStock();
    }
}
