<?php

namespace App\Exports;

use App\Traits\ConnectsToOracle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlanningExport implements FromCollection, WithHeadings
{
    use ConnectsToOracle;

    protected $data;

    public function __construct()
    {
        $query = <<<'SQL'
SELECT 
    PFB_CCL_CCT_NO AS "DOC no",
    CCT_CLI_CODE_DISP AS "Dispatch",
    CCL_ART_CODE AS "Article",
    PFB_QTE_PLANIF AS "Quantity",
    COALESCE(SUM(SEM_QTE_STK),0) AS "Available",
    CCT_DT_FERM AS "RTS date",
    CCT_DT_AR AS "CDD" 
FROM TR_PLANIF_FAB@msfss, XN_CMDE_CLI_TETE@msfss, XN_CMDE_CLI_LIGNE@msfss, XN_STOCK_EMPLAC@msfss
WHERE PFB_DEP_CODE = 'NBO'
AND PFB_INDEX = '0'
AND CCT_NO = PFB_CCL_CCT_NO
AND CCL_CCT_NO = CCT_NO
AND CCL_CCT_NO = PFB_CCL_CCT_NO
AND PFB_CCL_NO_LIGNE = CCL_NO_LIGNE
AND SEM_ART_CODE(+) = CCL_ART_CODE 
AND SEM_BLOQUE(+) <> 'T' 
AND SEM_BLOQUE(+) <> 'S' 
AND SEM_DEP_CODE_STK(+) = 'NBO' 
GROUP BY PFB_CCL_CCT_NO, CCT_CLI_CODE_DISP, CCL_ART_CODE, PFB_QTE_PLANIF, CCT_DT_FERM, CCT_DT_AR
ORDER BY PFB_CCL_CCT_NO DESC
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