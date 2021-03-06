<?php

namespace App\Services;

use App\Eloquents\Campaign;

class CampaignService
{
    public function index()
    {
        $query = Campaign::query();
        return $query->get();
    }

    public function findOrFail(int $campaignId)
    {
        return Campaign::findOrFail($campaignId);
    }

    public function create(array $attributes)
    {
        $campaign = new Campaign();
        $campaign->fill($attributes);
        $campaign->save();

        return $campaign;
    }

    public function update(Campaign $argCampaign, array $attributes)
    {
        $campaign = clone $argCampaign;
        $campaign->fill($attributes);
        $campaign->save();

        return $campaign;
    }

    public function delete(Campaign $campaign)
    {
        $campaign->delete();
    }
}
