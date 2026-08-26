<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['telepone' => '081234567890'],
            [
                'username' => 'admin',
                'nama' => 'Admin RentAuto',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['telepone' => '081234567891'],
            [
                'username' => 'petugas1',
                'nama' => 'Petugas Satu',
                'password' => 'password',
                'role' => 'petugas',
            ]
        );

        User::updateOrCreate(
            ['telepone' => '081234567892'],
            [
                'username' => 'user1',
                'nama' => 'User Biasa',
                'password' => 'password',
                'role' => 'user',
            ]
        );

        $kelasData = ['MPV', 'SUV', 'Sedan', 'Hatchback'];
        foreach ($kelasData as $nama) {
            Kelas::firstOrCreate(['kelas' => $nama]);
        }

        $brandData = ['Toyota', 'Honda', 'Mitsubishi', 'Suzuki', 'Nissan', 'Daihatsu'];
        foreach ($brandData as $nama) {
            Brand::firstOrCreate(['brand' => $nama]);
        }

        $kelas = Kelas::pluck('id', 'kelas');
        $brand = Brand::pluck('id', 'brand');

        $mobilData = [
            ['MPV', 'Toyota', 'Avanza Veloz', 'Putih', 2024, 'Automatic', 7, 350000],
            ['MPV', 'Toyota', 'Innova Reborn', 'Hitam', 2023, 'Automatic', 7, 500000],
            ['MPV', 'Mitsubishi', 'Xpander', 'Abu-abu', 2024, 'Automatic', 7, 400000],
            ['MPV', 'Daihatsu', 'Xenia', 'Silver', 2024, 'Manual', 7, 330000],
            ['SUV', 'Toyota', 'Fortuner VRZ', 'Hitam', 2024, 'Automatic', 7, 750000],
            ['SUV', 'Honda', 'CR-V', 'Silver', 2024, 'Automatic', 5, 650000],
            ['SUV', 'Suzuki', 'Jimny', 'Kuning', 2023, 'Manual', 4, 400000],
            ['Sedan', 'Toyota', 'Vios', 'Putih', 2024, 'Automatic', 5, 380000],
            ['Sedan', 'Honda', 'Civic Turbo', 'Merah', 2024, 'Automatic', 5, 600000],
            ['Sedan', 'Nissan', 'Sylphy', 'Biru', 2023, 'Automatic', 5, 450000],
            ['Hatchback', 'Honda', 'Brio', 'Merah', 2024, 'Manual', 5, 250000],
            ['Hatchback', 'Suzuki', 'Baleno', 'Abu-abu', 2023, 'Automatic', 5, 300000],
        ];

        foreach ($mobilData as [$kls, $brd, $nama, $warna, $tahun, $transmisi, $kursi, $harga]) {
            Car::firstOrCreate(
                ['nama' => $nama],
                [
                    'id_kelas' => $kelas[$kls],
                    'id_brand' => $brand[$brd],
                    'warna' => $warna,
                    'tahun' => (string) $tahun,
                    'transmisi' => $transmisi,
                    'kursi' => $kursi,
                    'harga' => $harga,
                    'status' => 'tersedia',
                    'img' => null,
                ]
            );
        }
    }
}
