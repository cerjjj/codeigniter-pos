<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PosSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('users')->insert([
            'username' => 'admin',
            'full_name' => 'Store Administrator',
            'password' => password_hash('Admin123!', PASSWORD_DEFAULT),
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->db->table('customers')->insertBatch([
            ['full_name' => 'Walk-in Demo Customer', 'email' => 'customer@example.com', 'phone' => '0917 555 0101', 'created_at' => $now, 'updated_at' => $now],
            ['full_name' => 'Avery Santos', 'email' => 'avery@example.com', 'phone' => '0917 555 0102', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('products')->insertBatch([
            ['name' => 'Classic Milk Tea', 'price' => 95.00, 'stock_quantity' => 40, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Caramel Latte', 'price' => 135.00, 'stock_quantity' => 24, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Butter Croissant', 'price' => 85.00, 'stock_quantity' => 18, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Reusable Tumbler', 'price' => 299.00, 'stock_quantity' => 8, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
