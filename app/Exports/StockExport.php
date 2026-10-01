<?php

namespace App\Exports;

use App\Traits\ConnectsToOracle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithHeadings
{
    use ConnectsToOracle;

    protected $data;

    public function __construct()
    {
        $query = <<<'SQL'
SELECT 
    SEM_NO_SEQ AS "Id Place",
    SEM_BFT_NO_BL AS "RC number",
    SEM_DEP_CODE_STK AS "Store",
    SEM_ART_CODE AS "Article",
    SEM_ART_VAR1 AS "Version",
    ARL_DES1 AS "Description",
    SEM_MAG_CODE AS "Aisle",
    SEM_ALLEE AS "Rack",
    CASE WHEN LENGTH(TO_CHAR(SEM_RANG)) = 1 THEN ('0' || TO_CHAR(SEM_RANG))
    ELSE TO_CHAR(SEM_RANG)
    END AS "Level",
    SEM_NIVEAU AS "Stack",
    TO_CHAR(SEM_QTE_STK) AS "Quantity",
    TO_CHAR(SEM_QTE_RESERV) AS "Quantity Not Available",
    CASE
        WHEN BFT_ZZ_CONFIRME_01 = 0 THEN TO_CHAR(SEM_QTE_STK-SEM_QTE_RESERV)
        WHEN SEM_BFT_NO_BL IS NULL THEN TO_CHAR(SEM_QTE_STK-SEM_QTE_RESERV)
        ELSE '0'
    END AS "Quantity Available",
    SEM_NO_SERIE_LOT AS "Batch/Series",
    TO_CHAR(SEM_DT_PEREMPTION,'DD/MM/YYYY') AS "Expiry",
    SEM_PX_UNIT*SEM_QTE_STK AS "Value(EUR)"                  
FROM XN_STOCK_EMPLAC@msfss, XN_ART@msfss, XN_ART_LANGUE@msfss, XN_BL_FOUR_TETE@msfss
WHERE SEM_QTE_STK > 0
AND ART_CODE(+) = SEM_ART_CODE
AND SEM_BLOQUE <> 'T'
AND SEM_DEP_CODE_STK = 'NBO'
AND SEM_ART_CODE = ARL_ART_CODE
AND SEM_ART_VAR1 = ARL_ART_VAR1
AND (ARL_LAN_CODE='E' OR ARL_LAN_CODE IS NULL)
AND BFT_NO_BL(+) = SEM_BFT_NO_BL
AND SEM_BLOQUE <> 'S'
AND ((SEM_BFT_NO_BL IS NULL)
OR(BFT_ZZ_CONFIRME_01 IN (0)))
GROUP BY SEM_NO_SEQ, SEM_BFT_NO_BL, SEM_DEP_CODE_STK, SEM_ART_CODE, SEM_ART_VAR1, ARL_DES1, SEM_MAG_CODE, SEM_ALLEE, SEM_RANG, SEM_NIVEAU, SEM_QTE_STK, SEM_NO_SERIE_LOT, SEM_DT_PEREMPTION, SEM_PX_UNIT, SEM_QTE_STK, SEM_QTE_RESERV, BFT_INDEX, BFT_ZZ_CONFIRME_01 
ORDER BY SEM_MAG_CODE, SEM_ALLEE, SEM_RANG, SEM_NIVEAU
SQL;
        $this->data = $this->fetchFromOracle($query);
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->data->isNotEmpty() ? array_keys((array) $this->data->first()) : [];
    }
}