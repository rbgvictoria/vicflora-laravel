<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * @property integer $id
 * @property integer $taxon_name_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $vba_id
 * @property string $scientific_name
 * @property string $common_name
 * @property string $authority
 * @property string $ffg
 * @property string $ffg_desc
 * @property string $epbc
 * @property string $epbc_desc
 * @property string $vic_adv
 * @property string $vic_adv_desc
 * @property string $restriction
 * @property string $origin
 * @property string $taxon_type
 * @property string $vic_life_form
 * @property string $fire_response
 * @property string $nvis_growth_form
 * @property string $treaty
 * @property string $discipline
 * @property string $taxon_level
 * @property int $fis_species_number
 * @property string $taxon_modification_date
 * @property string $version_date
 * @property TaxonName $taxonName
 */
class VbaTaxon extends BaseModel
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['vba_id','taxon_name_id', 'created_at', 'updated_at', 
            'scientific_name', 'common_name', 'authority', 'ffg', 'ffg_desc', 
            'epbc', 'epbc_desc', 'vic_adv', 'vic_adv_desc', 'restriction', 
            'origin', 'taxon_type', 'vic_life_form', 'fire_response', 
            'nvis_growth_form', 'treaty', 'discipline', 'taxon_level', 
            'fis_species_number', 'record_modification_date', 'version_date'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonName()
    {
        return $this->belongsTo('App\Models\TaxonName');
    }

    /**
     * FFG
     *
     * @return array<mixed>|null
     */
    public function getFfgObjectAttribute()
    {
        if ($this->ffg) {
            return [
                'code' => $this->ffg,
                'description' => $this->ffg_desc
            ];
        }
        return null;
    }

    /**
     * EPBC
     *
     * @return array<mixed>|null
     */
    public function getEpbcObjectAttribute()
    {
        if ($this->epbc) {
            return [
                'code' => $this->epbc,
                'description' => $this->epbc_desc
            ];
        }
        return null;
    }

    /**
     * Vic. Advice
     *
     * @return array<mixed>|null
     */
    public function getVicAdvObjectAttribute()
    {
        if ($this->vic_adv) {
            return [
                'code' => $this->vic_adv,
                'description' => $this->vic_adv_desc
            ];
        }
        return null;
    }
}
