<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$aTraining = [];
for ($i=2000; $i<=2019; $i++) {
    $aTraining[$i] = $i;
}

return [
    'status' => [
        'active' => 1,
        'inactive' => 0
    ],
    'status_display' => [
        '1' => 'Active',
        '0' => 'On Hold'
    ],
    
    'tutor_type' => [
        '1' => 'Senior',
        '2' => 'Advanced',
        '3' => 'Foundation',
        '4' => 'Registered',
    ],
    
    
    'course_status_display' => [
        '1' => 'Draft',
        '2' => "Pending Approval",
        '3' => 'Rejected',
        '4' => "Future",
        '5' => 'Current',
        '6' => "Past",
        '7' => "Closed",
    ],
    
    'course_status' => [
        'draft' => 1,
        'pending_approval' => 2,
        'rejected' => 3,
        'future' => 4,
        'current' => 5,
        'past' => 6,
        'closed' => 7,
    ],
    
    'course_status_internal' => [
        'draft' => 1,
        'submit_for_approval' => 2,
        'rejected' => 3,
        'resubmit' => 4,
        'approved' => 5,
        'register_submit' => 6,
        'certificate_complete' => 7,
        'closed' => 8,
    ],
    
    'course_type' => [
        1 => 'Tutor Training',
        2 => 'Foundation Courses',
        3 => 'Introductory Courses',
        4 => 'Workshops',
    ],
    
    'training_year' => $aTraining,
];
