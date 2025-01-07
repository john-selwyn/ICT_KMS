<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PendingEntriesSeeder extends Seeder
{
    public function run()
    {
        // Create a test user if not exists
        $userId = DB::table('users')->insertGetId([
            'name' => 'Test Staff',
            'email' => 'stafsf@test.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Ensure categories exist
        $categories = [
            'Networks',
            'Hardware',
            'Printer',
            'Router',

        ];

        $categoryIds = [];
        foreach ($categories as $category) {
            $categoryIds[] = DB::table('categories')->insertGetId([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Pending entries data
        $pendingEntries = [
            [
                'title' => 'Network Switch Installation Guide',
                'description' => 'Detailed guide for installing and configuring enterprise-grade network switches, including physical setup and initial configuration steps.',
                'youtube_url' => 'https://youtube.com/watch?v=switch-install',
                'categories' => [0, 1] // Networks, Hardware
            ],
            [
                'title' => 'Printer Network Configuration',
                'description' => 'Step-by-step instructions for setting up network printers, including IP configuration and driver installation.',
                'youtube_url' => 'https://youtube.com/watch?v=printer-network',
                'categories' => [2, 0] // Printer, Networks
            ],
            [
                'title' => 'Router Firmware Update Protocol',
                'description' => 'Standard operating procedure for safely updating router firmware and backing up configurations.',
                'youtube_url' => 'https://youtube.com/watch?v=router-firmware',
                'categories' => [3, 4] // Router, 
            ],
            [
                'title' => 'Hardware Inventory System',
                'description' => 'Documentation for the new hardware inventory tracking system, including asset tagging procedures.',
                'youtube_url' => 'https://youtube.com/watch?v=inventory-system',
                'categories' => [1] // Hardware
            ],
            [
                'title' => 'Network Security Implementation',
                'description' => 'Comprehensive guide on implementing network security measures, including firewall configuration and access controls.',
                'youtube_url' => 'https://youtube.com/watch?v=network-security',
                'categories' => [0, 4] // Networks, 
            ],
            [
                'title' => 'Printer Maintenance Schedule',
                'description' => 'Annual maintenance schedule for all network printers, including cleaning and parts replacement guidelines.',
                'youtube_url' => 'https://youtube.com/watch?v=printer-maintenance',
                'categories' => [2] // Printer
            ],
            [
                'title' => 'VPN Setup Guide',
                'description' => 'Instructions for setting up and configuring VPN access for remote workers, including security best practices.',
                'youtube_url' => 'https://youtube.com/watch?v=vpn-setup',
                'categories' => [0, 3] // Networks, Router
            ],
            [
                'title' => 'Server Room Standards',
                'description' => 'Documentation of server room standards, including cooling requirements and rack organization protocols.',
                'youtube_url' => 'https://youtube.com/watch?v=server-standards',
                'categories' => [1, 0] // Hardware, Networks
            ],
            [
                'title' => 'Wireless Access Point Deployment',
                'description' => 'Guidelines for deploying and configuring wireless access points to optimize coverage and performance.',
                'youtube_url' => 'https://youtube.com/watch?v=wireless-deployment',
                'categories' => [0, 3, 4] // Networks, Router
            ],
            [
                'title' => 'Backup System Configuration',
                'description' => 'Detailed configuration guide for the enterprise backup system, including scheduling and retention policies.',
                'youtube_url' => 'https://youtube.com/watch?v=backup-config',
                'categories' => [1, 0] // Hardware, Networks
            ]
        ];

        foreach ($pendingEntries as $entry) {
            // Create pending entry
            $pendingEntryId = DB::table('pending_entries')->insertGetId([
                'title' => $entry['title'],
                'description' => $entry['description'],
                'youtube_url' => $entry['youtube_url'],
                'created_by' => $userId,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attach categories
            foreach ($entry['categories'] as $categoryIndex) {
                DB::table('category_entry')->insert([
                    'category_id' => $categoryIds[$categoryIndex],
                    'pending_entries_id' => $pendingEntryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Create a sample attachment for each entry
            DB::table('attachments')->insert([
                'pending_entry_id' => $pendingEntryId,
                'file_path' => 'uploads/' . Str::random(40) . '/documentation.pdf',
                'original_name' => 'documentation.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}