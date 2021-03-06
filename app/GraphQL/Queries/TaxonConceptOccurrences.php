<?php

namespace App\GraphQL\Queries;

use App\Models\TaxonConcept;
use App\Models\TaxonOccurrence;

class TaxonConceptOccurrences
{
    /**
     * @param  \App\Models\TaxonConcept  $taxonConcept
     */
    public function __invoke(TaxonConcept $taxonConcept)
    {
        return TaxonOccurrence::where('taxon_concept_id', $taxonConcept->guid);
    }
}
