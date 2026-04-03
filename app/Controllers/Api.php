<?php

namespace App\Controllers;

use App\Models\ChildrenModel;
use App\Models\MeasurementsModel;

class Api extends BaseController
{
    public function stuntingMap()
    {
        $childrenModel = new ChildrenModel();
        // Option to join with measurements here if we want real-time stunting status
        $children = $childrenModel->findAll();
        
        // For now, since we haven't built complex measurement calculations, we'll assign dummy status or read from a field
        // The stunting_status usually comes from `measurements` table's latest row.
        
        $data = [];
        foreach ($children as $child) {
            if (!empty($child['latitude']) && !empty($child['longitude'])) {
                $status = 'Normal'; // Placeholder for complex logic later
                $color = "#10B981"; // Green
                
                // Demo logic overriding based on gender for variety because we have no real measurements yet
                if ($child['gender'] == 'P') {
                    $status = 'Berisiko';
                    $color = "#F59E0B";
                }
                
                $data[] = [
                    'id' => $child['id'],
                    'name' => $child['name'],
                    'lat' => $child['latitude'],
                    'lng' => $child['longitude'],
                    'status' => $status,
                    'color' => $color
                ];
            }
        }
        
        return $this->response->setJSON($data);
    }
}
