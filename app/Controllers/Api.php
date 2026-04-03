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

    public function getStatistics()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('posyandu');
        $posyandus = $builder->get()->getResultArray();

        $childrenModel = new ChildrenModel();
        $allChildren = $childrenModel->findAll();

        $stats = [];
        $totalStunting = 0;
        $totalNormal = 0;
        $totalBerisiko = 0;

        foreach ($posyandus as $p) {
            $p_children = array_filter($allChildren, function($c) use ($p) {
                return $c['posyandu_id'] == $p['id'];
            });

            $stunting = 0;
            $normal = 0;
            $berisiko = 0;

            foreach ($p_children as $child) {
                // Simulasi logic status
                if ($child['gender'] == 'P') {
                    $berisiko++;
                    $totalBerisiko++;
                } else if ($child['name'] == 'Agus Pratama') { // just a dummy hardcode to show stunting
                    $stunting++;
                    $totalStunting++;
                } else {
                    $normal++;
                    $totalNormal++;
                }
            }

            $stats['posyandu_breakdown'][] = [
                'posyandu_name' => $p['name'],
                'normal' => $normal,
                'berisiko' => $berisiko,
                'stunting' => $stunting,
                'total' => count($p_children)
            ];
        }

        // Add overall
        $stats['overall'] = [
            'total_children' => count($allChildren),
            'total_normal' => $totalNormal,
            'total_berisiko' => $totalBerisiko,
            'total_stunting' => $totalStunting
        ];

        return $this->response->setJSON($stats);
    }
}
