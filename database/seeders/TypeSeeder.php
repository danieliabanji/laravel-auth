<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Javascript', 'PHP', 'Laravel', 'Vue'];
        foreach($types as $type){
            $newtype = new type();
            $newtype->name = $type;
            $newtype->slug = Str::slug($newtype->name, '-');
            $newtype->save();
        }
    }
}
