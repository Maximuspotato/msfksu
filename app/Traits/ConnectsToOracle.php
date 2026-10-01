<?php

namespace App\Traits;

trait ConnectsToOracle
{
    protected function fetchFromOracle($sql)
    {
        // Using your exact manual connection logic
        $conn = \ocilogon("msf", "msf", "10.210.168.40:1521/ORCL");
        
        if (!$conn) {
            $e = \oci_error();
            throw new \Exception("Unable to connect to Oracle: " . $e['message']);
        }

        $stid = \oci_parse($conn, $sql);
        \oci_execute($stid);

        // Fetch all rows into an associative array
        \oci_fetch_all($stid, $results, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);

        \oci_free_statement($stid);
        \oci_close($conn);

        // Convert the array to a Laravel Collection for the Excel package
        return collect($results);
    }
}