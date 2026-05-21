<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {

        $vehicle = Vehicle::create([
            'owner_name'    => 'Alexander Vanderwaal',
            'email'         => 'alexander@techcorp.com',
            'phone'         => '+1 (555) 012-3456',
            'brand'         => 'Porsche',
            'model'         => '911 GT3',
            'year'          => 2023,
            'license_plate' => 'P-911-GT3',
            'vin'           => 'WP0AC2A9XPS20XXXX',
            'color'         => 'Silver Metallic',
            'mileage'       => 12442,
        ]);

        $booking = Booking::create([
            'booking_code' => 'CRVX-8829-PRCSN',
            'vehicle_id'   => $vehicle->id,
            'service_type' => 'Annual Performance Inspection',
            'complaint'    => 'Annual performance check. DME report required.',
            'service_date' => now()->addDays(2),
            'specialist'   => 'Marcus Van-Dyke',
            'status'       => 'in_progress',
            'progress'     => 65,
        ]);

        $stages = [
            ['Vehicle Received',      'Initial intake protocol completed.', 'completed'],
            ['Diagnostic Inspection', 'Full system scan performed.',         'completed'],
            ['Parts & Service',       'Precision calibration underway.',     'in_progress'],
            ['Quality Check',         'Pending completion of service.',      'pending'],
            ['Ready for Pickup',      'Vehicle not yet ready.',              'pending'],
        ];

        foreach ($stages as $stage) {
            Service::create([
                'booking_id'   => $booking->id,
                'stage_name'   => $stage[0],
                'description'  => $stage[1],
                'status'       => $stage[2],
                'completed_at' => $stage[2] === 'completed' ? now()->subHours(rand(1, 12)) : null,
            ]);
        }

        Invoice::create([
            'invoice_number' => 'CX-88291',
            'booking_id'     => $booking->id,
            'subtotal'       => 1950.00,
            'tax'            => 195.00,
            'total'          => 2145.00,
            'payment_status' => 'paid',
            'issue_date'     => now()->subDays(3),
            'due_date'       => now()->subDays(3),
            'items'          => [
                ['description' => 'Full Engine Diagnostic',       'qty' => 1,   'unit_price' => 450.00,  'total' => 450.00],
                ['description' => 'Brake Fluid Replacement',      'qty' => 1,   'unit_price' => 185.00,  'total' => 185.00],
                ['description' => 'DME Calibration & Tune',       'qty' => 1,   'unit_price' => 895.00,  'total' => 895.00],
                ['description' => 'Labor (4.5 hrs @ $95/hr)',     'qty' => 4.5, 'unit_price' => 95.00,   'total' => 427.50],
            ],
        ]);

        // Add a few history entries
        $vehicle2 = Vehicle::create([
            'owner_name'    => 'Julian Blackwood',
            'email'         => 'julian@blackwood.com',
            'phone'         => '+49 172 444-5555',
            'brand'         => 'BMW',
            'model'         => 'M4 Competition',
            'year'          => 2022,
            'license_plate' => 'M4-COMP-22',
            'vin'           => 'WBSGF0C0XN',
            'color'         => 'Frozen Blue',
            'mileage'       => 9200,
        ]);

        Booking::create([
            'booking_code' => 'CRVX-1122-BMWM4',
            'vehicle_id'   => $vehicle2->id,
            'service_type' => 'Precision Performance Lab',
            'complaint'    => 'Suspension noise at low speed.',
            'service_date' => now()->subDays(15),
            'specialist'   => 'Erik Haas',
            'status'       => 'completed',
            'progress'     => 100,
        ]);
    }
}