<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;

class StudentImport implements ToModel, WithGroupedHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'password' => bcrypt($row['password']),
            'gender' => $row['gender'],
            'disability' => $row['disability'],
            'national_id' => $row['national_id'],
            'university_id' => $row['university_id'],
            'phone' => $row['phone'],
            'university' => $row['university'],
            'faculty' => $row['faculty'],
            'department' => $row['department'],
            'specialization' => $row['specialization'],
            'current_year' => $row['current_year'],
            'expected_graduation_year' => $row['expected_graduation_year'],
            'address' => $row['address'],
            'birth_date' => $row['birth_date'],
        ]);
    }
}
