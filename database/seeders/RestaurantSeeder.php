<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Meja;
use Illuminate\Support\Facades\Hash;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo users
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@restaurant.com',
                'password' => Hash::make('password'),
                'role' => 'administrator',
            ],
            [
                'name' => 'Waiter Demo',
                'email' => 'waiter@restaurant.com',
                'password' => Hash::make('password'),
                'role' => 'waiter',
            ],
            [
                'name' => 'Kasir Demo',
                'email' => 'kasir@restaurant.com',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ],
            [
                'name' => 'Owner Demo',
                'email' => 'owner@restaurant.com',
                'password' => Hash::make('password'),
                'role' => 'owner',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Create demo menus
        $menus = [
            ['idmenu' => 'M001', 'namamenu' => 'Nasi Goreng Spesial', 'harga' => 25000],
            ['idmenu' => 'M002', 'namamenu' => 'Mie Ayam', 'harga' => 18000],
            ['idmenu' => 'M003', 'namamenu' => 'Gado-gado', 'harga' => 15000],
            ['idmenu' => 'M004', 'namamenu' => 'Sate Ayam (10 tusuk)', 'harga' => 30000],
            ['idmenu' => 'M005', 'namamenu' => 'Soto Ayam', 'harga' => 20000],
            ['idmenu' => 'M006', 'namamenu' => 'Bakso Spesial', 'harga' => 22000],
            ['idmenu' => 'M007', 'namamenu' => 'Es Teh Manis', 'harga' => 5000],
            ['idmenu' => 'M008', 'namamenu' => 'Es Jeruk', 'harga' => 8000],
            ['idmenu' => 'M009', 'namamenu' => 'Kopi Hitam', 'harga' => 10000],
            ['idmenu' => 'M010', 'namamenu' => 'Jus Alpukat', 'harga' => 15000],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        // Create demo customers
        $pelanggans = [
            [
                'idpelanggan' => 'P001',
                'namapelanggan' => 'Budi Santoso',
                'jeniskelamin' => true,
                'nohp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            ],
            [
                'idpelanggan' => 'P002',
                'namapelanggan' => 'Siti Aminah',
                'jeniskelamin' => false,
                'nohp' => '081234567891',
                'alamat' => 'Jl. Sudirman No. 456, Jakarta',
            ],
            [
                'idpelanggan' => 'P003',
                'namapelanggan' => 'Ahmad Wijaya',
                'jeniskelamin' => true,
                'nohp' => '081234567892',
                'alamat' => 'Jl. Thamrin No. 789, Jakarta',
            ],
        ];

        foreach ($pelanggans as $pelanggan) {
            Pelanggan::create($pelanggan);
        }

        // Create demo tables
        $mejas = [
            ['nomor_meja' => 'A1', 'kapasitas' => 4, 'status' => 'kosong'],
            ['nomor_meja' => 'A2', 'kapasitas' => 4, 'status' => 'kosong'],
            ['nomor_meja' => 'A3', 'kapasitas' => 6, 'status' => 'kosong'],
            ['nomor_meja' => 'B1', 'kapasitas' => 2, 'status' => 'kosong'],
            ['nomor_meja' => 'B2', 'kapasitas' => 2, 'status' => 'kosong'],
            ['nomor_meja' => 'C1', 'kapasitas' => 8, 'status' => 'kosong'],
            ['nomor_meja' => 'C2', 'kapasitas' => 8, 'status' => 'kosong'],
        ];

        foreach ($mejas as $meja) {
            Meja::create($meja);
        }
    }
}
