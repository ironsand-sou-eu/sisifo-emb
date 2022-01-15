<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $nonRelationalTables = [
            "espaider_orgaos",
            "espaider_ufs",
            "espaider_comarcas",
            "espaider_juizos",
            "eselo_comarcas",
            "eselo_juizos",
            "sistemas_jud_juizos",
            "generos",
            "users",
            "tabelas",
            "eselo_configs",
            "tipos_permissoes"
        ];

        foreach ($nonRelationalTables as $tableName) {
            $this->seedTable($tableName);
        }
    }

    protected function seedTable($snakeCaseTableName) {
        $seederName = Str::studly($snakeCaseTableName) . "Seeder";
        $path = database_path("initial-data-seed" . DIRECTORY_SEPARATOR . $seederName . ".json");
        $dataArray = json_decode(file_get_contents($path), true);

        if (!empty($dataArray["relationalFields"])){
            foreach ($dataArray[$seederName] as &$entry) {
                foreach ($dataArray["relationalFields"] as $relationalField) {
                    extract($relationalField);
                    $entry[$originField] = DB::table($relatedTable)->where($relatedSearchingField, $entry[$originField])->value($relatedIdField);
                }
            }
        }

        try {
            DB::table($snakeCaseTableName)->insert($dataArray[$seederName]);
        } catch (Exception $e) {
            return $e;
        };
    }
}