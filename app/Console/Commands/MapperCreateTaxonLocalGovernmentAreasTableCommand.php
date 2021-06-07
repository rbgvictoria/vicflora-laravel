<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MapperCreateTaxonLocalGovernmentAreasTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vicflora-mapper:create-local-government-areas-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create mapper.taxon_local_government_areas table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Delete existing mapper.taxon_local_government_areas table');
        DB::statement('DROP TABLE IF EXISTS mapper.taxon_local_government_areas');

        $this->info('Create new mapper.taxon_local_government_areas table');
        Schema::create('mapper.taxon_local_government_areas', function(Blueprint $table) {
            $table->id();
            $table->timestampsTz();
            $table->uuid('taxon_concept_id');
            $table->string('scientific_name', 128);
            $table->string('lga_pid', 16);    
            $table->string('lga_name', 64);
            $table->string('abbreviated_name', 64);
            $table->string('occurrence_status', 32)->nullable();
            $table->string('establishment_means', 32)->nullable();
            $table->string('degree_of_establishment', 32)->nullable();
            $table->multiPolygon('geom', 'GEOMETRY', 4326);
        });
    }
}
