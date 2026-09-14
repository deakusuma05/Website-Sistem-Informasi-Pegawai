<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'name' => 'Budi Pratama',
                'gender' => 'Laki-laki',
                'education' => 'S1',
                'age' => 29,
                'work_duration' => 4,
                'phone' => '081234567890',
                'email' => 'budi.pratama@example.com',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'gender' => 'Perempuan',
                'education' => 'S2',
                'age' => 34,
                'work_duration' => 7,
                'phone' => '082198765432',
                'email' => 'siti.nurhaliza@example.com',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'gender' => 'Laki-laki',
                'education' => 'D3',
                'age' => 24,
                'work_duration' => 2,
                'phone' => '085233445566',
                'email' => 'ahmad.fauzi@example.com',
            ],
            [
                'name' => 'Dewi Anggraini',
                'gender' => 'Perempuan',
                'education' => 'S1',
                'age' => 27,
                'work_duration' => 3,
                'phone' => '087711223344',
                'email' => 'dewi.anggraini@example.com',
            ],
            [
                'name' => 'Rian Hidayat',
                'gender' => 'Laki-laki',
                'education' => 'SMA/SMK',
                'age' => 22,
                'work_duration' => 1,
                'phone' => '089855667788',
                'email' => 'rian.hidayat@example.com',
            ],
            [
                'name' => 'Fitri Wulandari',
                'gender' => 'Perempuan',
                'education' => 'S1',
                'age' => 41,
                'work_duration' => 14,
                'phone' => '081344556677',
                'email' => 'fitri.wulandari@example.com',
            ],
            [
                'name' => 'Hendra Gunawan',
                'gender' => 'Laki-laki',
                'education' => 'S2',
                'age' => 48,
                'work_duration' => 18,
                'phone' => '081299887766',
                'email' => 'hendra.gunawan@example.com',
            ],
            [
                'name' => 'Maya Kusuma',
                'gender' => 'Perempuan',
                'education' => 'D3',
                'age' => 31,
                'work_duration' => 6,
                'phone' => '082266778899',
                'email' => 'maya.kusuma@example.com',
            ],
            [
                'name' => 'Bambang Supriyanto',
                'gender' => 'Laki-laki',
                'education' => 'S3',
                'age' => 58,
                'work_duration' => 24,
                'phone' => '081122334455',
                'email' => 'bambang.supriyanto@example.com',
            ],
            [
                'name' => 'Nadia Rahmawati',
                'gender' => 'Perempuan',
                'education' => 'S1',
                'age' => 25,
                'work_duration' => 2,
                'phone' => '085712345678',
                'email' => 'nadia.rahma@example.com',
            ],
            [
                'name' => 'Eko Prasetyo',
                'gender' => 'Laki-laki',
                'education' => 'SMA/SMK',
                'age' => 38,
                'work_duration' => 12,
                'phone' => '087812349876',
                'email' => 'eko.prasetyo@example.com',
            ],
            [
                'name' => 'Ratna Sari',
                'gender' => 'Perempuan',
                'education' => 'S2',
                'age' => 52,
                'work_duration' => 20,
                'phone' => '081987654321',
                'email' => 'ratna.sari@example.com',
            ],
        ];

        foreach ($employees as $data) {
            Employee::firstOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}

