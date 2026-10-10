<?php

namespace App\Services;

use CodeIgniter\Database\BaseConnection;
use DomainException;
use RuntimeException;

class SaleService
{
    public function __construct(private ?BaseConnection $db = null)
    {
        $this->db ??= db_connect();
    }

    public function record(int $productId, ?int $customerId, int $userId, int $quantity): int
    {
        if ($quantity < 1) {
            throw new DomainException('Quantity must be at least 1.');
        }

        $product = $this->db->table('products')
            ->where(['id' => $productId, 'is_active' => 1])
            ->get()
            ->getRowArray();

        if (! $product) {
            throw new DomainException('The selected product is unavailable.');
        }

        $this->db->transBegin();

        $this->db->table('products')
            ->set('stock_quantity', 'stock_quantity - ' . $quantity, false)
            ->where('id', $productId)
            ->where('stock_quantity >=', $quantity)
            ->update();

        if ($this->db->affectedRows() !== 1) {
            $this->db->transRollback();
            throw new DomainException('Not enough stock is available for this sale.');
        }

        $this->db->table('sales')->insert([
            'product_id' => $productId,
            'customer_id' => $customerId ?: null,
            'sold_by' => $userId,
            'quantity' => $quantity,
            'total_price' => round((float) $product['price'] * $quantity, 2),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if (! $this->db->transStatus()) {
            $this->db->transRollback();
            throw new RuntimeException('The sale could not be saved. Please try again.');
        }

        $saleId = (int) $this->db->insertID();
        $this->db->transCommit();

        return $saleId;
    }
}
