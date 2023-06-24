<?php

namespace App\Actions;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;

class AddCampaignAreaCode implements CreateAction
{
    protected DatabaseManager $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    public function create(array $params): void
    {
        $phone = $params['phone'];
        $areacode=substr($phone,0,3);

        $sql="INSERT IGNORE INTO asterisk.vicidial_campaign_cid_areacodes
                                SELECT DISTINCT
                                            101 AS campaign_id,
                                            areacode,
                                            '$phone' AS outbound_cid,
                                            'Y' AS active,
                                            state AS cid_description,
                                            0 AS call_count_today
                                                   FROM asterisk.vicidial_phone_codes
                                                   WHERE country_code = 1 AND country = 'USA'
                                                   and state in (SELECT DISTINCT state
                                                                  FROM asterisk.vicidial_phone_codes
                                                                       WHERE country_code = 1 AND country = 'USA'
                                                                      and areacode='$areacode')";
        echo 'Rows affected: ' . $this->databaseManager->insert($sql);
    }
}
