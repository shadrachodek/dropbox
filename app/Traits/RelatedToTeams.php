<?php


namespace App\Traits;


trait RelatedToTeams
{
    public function scopeForCurrentTeam($query) {
        $query->where('team_id', auth()->user()->currentTeam->id);
    }
}
