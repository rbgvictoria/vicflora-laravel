<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $id
 * @property integer $created_by_id
 * @property integer $modified_by_id
 * @property integer $taxon_name_id
 * @property integer $according_to_id
 * @property integer $taxon_tree_def_item_id
 * @property integer $accepted_id
 * @property integer $parent_id
 * @property integer $taxonomic_status_id
 * @property integer $occurrence_status_id
 * @property integer $establishment_means_id
 * @property integer $degree_of_establishment_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $rank_id
 * @property string $remarks
 * @property string $editor_notes
 * @property integer $version
 * @property string $guid
 * @property DegreeOfEstablishment $degreeOfEstablishment
 * @property EstablishmentMean $establishmentMean
 * @property OccurrenceStatus $occurrenceStatus
 * @property TaxonomicStatus $taxonomicStatus
 * @property TaxonTreeDefItem $taxonTreeDefItem
 * @property TaxonConcept $acceptedConcept
 * @property TaxonConcept $parent
 * @property Reference $accordingTo
 * @property TaxonName $taxonName
 * @property Agent $createdBy
 * @property Agent $modifiedBy
 * @property TaxonTreeItem[] $taxonTreeItem
 * @property TaxonRelationship[] $subjectOfTaxonRelationships
 * @property TaxonRelationship[] $objectOfTaxonRelationships
 * @property Profile[] $profiles
 * @property Profile[] $profilesAccepted
 * @property Image[] $images
 * @property Image[] $imagesAccepted
 * @property TaxonBioregion[] $bioregions
 * @property TaxonLocalGovernmentArea[] $localGovernmentAreas
 * @property TaxonParkReserve[] $parkReserves
 */
class TaxonConcept extends BaseModel
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
    protected $fillable = ['created_by_id', 'modified_by_id', 'taxon_name_id', 
            'according_to_id', 'taxon_tree_def_item_id', 'accepted_id', 'parent_id', 
            'taxonomic_status_id', 'occurrence_status_id', 'establishment_means_id', 
            'degree_of_establishment_id', 'created_at', 'updated_at', 'rank_id', 
            'remarks', 'editor_notes', 'version', 'guid'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function degreeOfEstablishment(): BelongsTo
    {
        return $this->belongsTo(DegreeOfEstablishment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establishmentMeans(): BelongsTo
    {
        return $this->belongsTo(EstablishmentMeans::class, 'establishment_means_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function occurrenceStatus(): BelongsTo
    {
        return $this->belongsTo(OccurrenceStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomicStatus(): BelongsTo
    {
        return $this->belongsTo(TaxonomicStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonTreeDefItem(): BelongsTo
    {
        return $this->belongsTo(TaxonTreeDefItem::class);
    }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function parent(): BelongsTo
    // {
    //     return $this->belongsTo(TaxonConcept::class, 'parent_id');
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acceptedConcept(): BelongsTo
    {
        return $this->belongsTo(TaxonConcept::class, 'accepted_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accordingTo(): BelongsTo
    {
        return $this->belongsTo(Reference::class, 'according_to_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonName(): BelongsTo
    {
        return $this->belongsTo(TaxonName::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taxonTreeItem(): HasOne
    {
        return $this->hasOne(TaxonTreeItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjectOfTaxonRelationships(): HasMany
    {
        return $this->hasMany(TaxonRelationship::class, 'object_taxon_concept_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objectOfTaxonRelationships(): HasMany
    {
        return $this->hasMany(TaxonRelationship::class, 'subject_taxon_concept_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profilesAccepted(): HasMany
    {
        return $this->hasMany(Profile::class, 'accepted_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imagesAccepted(): HasMany
    {
        return $this->hasMany(Image::class, 'accepted_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'taxon_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specimenImagesAccepted(): HasMany
    {
        return $this->hasMany(SpecimenImage::class, 'accepted_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specimenImages(): HasMany
    {
        return $this->hasMany(SpecimenImage::class, 'taxon_concept_id');
    }

    /**
     * @return \App\Models\Profile|null
     */
    public function getCurrentProfileAttribute()
    {
        if ($this->taxonomicStatus->name == 'accepted') {
            return Profile::where('taxon_concept_id', $this->id)
                    ->where('is_current', true)->first();
        }
        return null;
    }

    /**
     * @return void
     */
    public function getParentAttribute()
    {
        if ($this->taxonomicStatus->name == 'accepted') {
            return TaxonConcept::where('id', $this->parent_id)->first();
        }
        return null;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getChildrenAttribute(): Collection
    {
        if ($this->taxonomicStatus->name === 'accepted') {
            return TaxonConcept::where('parent_id', $this->id)
                    ->whereHas('taxonomicStatus', function (Builder $query) {
                        $query->where('name', 'accepted');
                    })
                    ->get();
        }
        return collect([]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSiblingsAttribute(): Collection
    {
        if ($this->taxonomicStatus->name === 'accepted') {
            return TaxonConcept::where('parent_id', $this->parent_id)
                    ->whereHas('taxonomicStatus', function (Builder $query) {
                        $query->where('name', 'accepted');
                    })
                    ->get();
        }
        return collect([]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getHigherClassificationAttribute(): Collection
    {
        if ($this->taxonomicStatus->name === 'accepted') {
            $node = TaxonTreeItem::where('taxon_concept_id', $this->id)
                    ->first();
            
            return TaxonTreeItem::where('node_number', '<', $node->node_number)
                    ->where('highest_descendant_node_number', '>=', 
                            $node->node_number)
                    ->get();
        }
        return collect([]);                    
    }

    /**
     * @return \App\Models\Image|null
     */
    public function getHeroImageAttribute()
    {
        $node = TaxonTreeItem::where('taxon_concept_id', $this->id)->first();

        if ($node) {
            return Image::whereHas('taxonConcept', function (Builder $query) use ($node) {
                $query->whereHas('taxonomicStatus', function(Builder $query) {
                            $query->where('name', 'accepted');
                        })
                        ->whereHas('taxonTreeItem', function (Builder $query) use ($node) {
                            $query->where('node_number', '>=', $node->node_number)
                                    ->where('node_number', '<=', $node->highest_descendant_node_number);
                        });
                    })
                    ->where('pixel_x_dimension', '>', 0)
                    ->orderBy('hero_image', 'desc')
                    ->orderBy('subtype', 'desc')
                    ->orderBy('rating', 'desc')
                    ->orderBy(DB::raw('random()'))
                    ->first();
        }
    }

    /**
     * @return \App\Models\VernacularName|null
     */
    public function getPreferredVernacularNameAttribute()
    {
        return VernacularName::where('taxon_concept_id', $this->id)
                ->where('is_preferred', true)->first();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSynonymsAttribute(): Collection
    {
        $usages = TaxonConcept::where('accepted_id', $this->id)
                ->whereHas('taxonomicStatus', function(Builder $query) {
                    $query->whereIn('name', ['synonym', 'heterotypicSynonym', 'homotypicSynonym']);
                })
                ->get();

        $synonyms = [];
        foreach ($usages as $usage) {
            $synonyms[] = $usage->taxonName;
        }
        return collect($synonyms);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMisapplicationsAttribute(): EloquentCollection
    {
        return TaxonConcept::where('accepted_id', $this->id)
                ->whereHas('taxonomicStatus', function(Builder $query) {
                    $query->whereIn('name', ['misapplication', 'misapplied']);
                })
                ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bioregions(): HasMany
    {
        return $this->hasMany(TaxonBioregion::class, 'taxon_concept_id', 'guid');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function localGovernmentAreas(): HasMany
    {
        return $this->hasMany(TaxonLocalGovernmentArea::class, 
                'taxon_concept_id', 'guid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parkReserves(): HasMany
    {
        return $this->hasMany(TaxonParkReserve::class, 'taxon_concept_id', 
                'guid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function occurrences(): HasMany
    {
        return $this->hasMany(TaxonOccurrence::class, 'taxon_concept_id', 
                'guid');
    }
}
