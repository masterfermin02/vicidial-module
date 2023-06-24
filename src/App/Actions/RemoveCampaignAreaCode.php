<?php

namespace App\Actions;

use Illuminate\Database\DatabaseManager;

class RemoveCampaignAreaCode implements RemoveAction
{
    protected DatabaseManager $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    public function remove(string $phone): void
    {
        $sql="delete from  asterisk.vicidial_campaign_cid_areacodes where outbound_cid= '{$phone}'";
        echo 'affected: ' . $this->databaseManager->delete($sql);
    }
}
