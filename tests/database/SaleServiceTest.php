<?php

namespace Tests\Database;

use App\Services\SaleService;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use DomainException;

class SaleServiceTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $namespace = 'App';
    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;

    private int $productId;
    private int $userId;

    protected function setUp(): void
    {
        parent::setUp();

        $now = date('Y-m-d H:i:s');
        $this->db->table('users')->insert([
            'username' => 'cashier',
            'full_name' => 'Test Cashier',
            'password' => password_hash('Password123!', PASSWORD_DEFAULT),
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $this->userId = (int) $this->db->insertID();

        $this->db->table('products')->insert([
            'name' => 'Test Product',
            'price' => 25.50,
            'stock_quantity' => 5,
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $this->productId = (int) $this->db->insertID();
    }

    public function testRecordCreatesSaleAndDecreasesStock(): void
    {
        $saleId = (new SaleService($this->db))->record($this->productId, null, $this->userId, 2);

        $this->assertGreaterThan(0, $saleId);
        $this->seeInDatabase('products', ['id' => $this->productId, 'stock_quantity' => 3]);
        $this->seeInDatabase('sales', [
            'id' => $saleId,
            'product_id' => $this->productId,
            'quantity' => 2,
            'total_price' => 51,
        ]);
    }

    public function testRecordRejectsQuantityAboveAvailableStock(): void
    {
        try {
            (new SaleService($this->db))->record($this->productId, null, $this->userId, 6);
            $this->fail('Expected the sale to be rejected.');
        } catch (DomainException $exception) {
            $this->assertSame('Not enough stock is available for this sale.', $exception->getMessage());
        }

        $this->seeInDatabase('products', ['id' => $this->productId, 'stock_quantity' => 5]);
        $this->dontSeeInDatabase('sales', ['product_id' => $this->productId]);
    }
}
