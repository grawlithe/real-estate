<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Lease;
use App\Models\MaintenanceRequest;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Remittance;
use App\Models\Unit;
use App\Models\UnitOwner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Create Companies (PMC Tenants)
        $apexCompany = Company::create([
            'name' => 'Apex Management',
            'slug' => 'apex-management',
        ]);

        $greenhillsCompany = Company::create([
            'name' => 'Greenhills Agency',
            'slug' => 'greenhills-agency',
        ]);

        // 1. Create Staff Members (Admins)
        $superAdmin = User::create([
            'name' => 'Super Admin User',
            'email' => 'admin@realestate.test',
            'password' => Hash::make('password'),
            'role' => UserRole::SuperAdmin,
            'kyc_status' => 'verified',
            'kyc_data' => ['id_type' => 'Passport', 'id_number' => 'N12345678'],
        ]);

        $manager = User::create([
            'name' => 'Property Manager User',
            'email' => 'manager@realestate.test',
            'password' => Hash::make('password'),
            'role' => UserRole::PropertyManager,
            'kyc_status' => 'verified',
            'kyc_data' => ['id_type' => 'UMID', 'id_number' => '111-222-333'],
        ]);

        $accountant = User::create([
            'name' => 'Accountant User',
            'email' => 'accountant@realestate.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Accountant,
            'kyc_status' => 'verified',
            'kyc_data' => ['id_type' => 'PRC License', 'id_number' => '0098765'],
        ]);

        $agent = User::create([
            'name' => 'Agent User',
            'email' => 'agent@realestate.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Agent,
            'kyc_status' => 'verified',
            'kyc_data' => ['id_type' => 'Drivers License', 'id_number' => 'D01-23-456789'],
        ]);

        // Associate staff with companies
        $apexCompany->users()->attach([$superAdmin->id, $manager->id, $accountant->id, $agent->id]);
        $greenhillsCompany->users()->attach([$superAdmin->id]);

        // 2. Create Clients - Owners
        $owner1 = User::create([
            'name' => 'Enrique Zobel',
            'email' => 'owner1@realestate.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Owner,
            'kyc_status' => 'verified',
            'kyc_data' => ['id_type' => 'Passport', 'id_number' => 'O00000001'],
        ]);

        $owner2 = User::create([
            'name' => 'Maria Ayala',
            'email' => 'owner2@realestate.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Owner,
            'kyc_status' => 'verified',
            'kyc_data' => ['id_type' => 'UMID', 'id_number' => '222-444-666'],
        ]);

        // Associate owners with companies
        $apexCompany->users()->attach([$owner1->id, $owner2->id]);

        // 3. Create Clients - Tenants
        $tenant1 = User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'tenant1@realestate.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Tenant,
            'kyc_status' => 'verified',
            'kyc_data' => ['id_type' => 'SSS ID', 'id_number' => '33-4444444-5'],
        ]);

        $tenant2 = User::create([
            'name' => 'Jose Rizal',
            'email' => 'tenant2@realestate.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Tenant,
            'kyc_status' => 'verified',
            'kyc_data' => ['id_type' => 'Passport', 'id_number' => 'T00000002'],
        ]);

        $tenant3 = User::create([
            'name' => 'Andres Bonifacio',
            'email' => 'tenant3@realestate.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Tenant,
            'kyc_status' => 'pending',
            'kyc_data' => ['id_type' => 'Postal ID', 'id_number' => 'POSTAL-9988'],
        ]);

        // Associate tenants with companies
        $apexCompany->users()->attach([$tenant1->id, $tenant2->id]);
        $greenhillsCompany->users()->attach([$tenant3->id]);

        // 4. Create Properties
        $prop1 = Property::create([
            'name' => 'Ayala Heights Condominium',
            'address' => 'Ayala Avenue, Makati City, Metro Manila',
            'description' => 'A luxury high-rise condominium complex in the heart of Makati CBD.',
            'company_id' => $apexCompany->id,
        ]);

        $prop2 = Property::create([
            'name' => 'Greenhills Residences',
            'address' => 'Ortigas Ave, San Juan, Metro Manila',
            'description' => 'Elegant townhouse enclave with active security and beautiful green parks.',
            'company_id' => $greenhillsCompany->id,
        ]);

        // 5. Create Units
        // Unit 1: Ayala Heights - 101, Condo, vacant, company owned
        $unit1 = Unit::create([
            'property_id' => $prop1->id,
            'unit_number' => '101',
            'type' => 'condo',
            'status' => 'vacant',
            'ownership_type' => 'company_owned',
            'rent_amount' => 45000.00,
            'security_deposit' => 90000.00,
            'company_id' => $apexCompany->id,
        ]);

        // Unit 2: Ayala Heights - 102, Condo, occupied, managed, Owner: Enrique Zobel
        $unit2 = Unit::create([
            'property_id' => $prop1->id,
            'unit_number' => '102',
            'type' => 'condo',
            'status' => 'occupied',
            'ownership_type' => 'managed',
            'rent_amount' => 55000.00,
            'security_deposit' => 110000.00,
            'company_id' => $apexCompany->id,
        ]);
        UnitOwner::create([
            'unit_id' => $unit2->id,
            'user_id' => $owner1->id,
            'share_percentage' => 100.00,
            'payout_terms' => '10% management fee. Remit by 28th of each month.',
        ]);

        // Unit 3: Ayala Heights - 103, Condo, occupied, managed, Owner: Maria Ayala
        $unit3 = Unit::create([
            'property_id' => $prop1->id,
            'unit_number' => '103',
            'type' => 'condo',
            'status' => 'occupied',
            'ownership_type' => 'managed',
            'rent_amount' => 60000.00,
            'security_deposit' => 120000.00,
            'company_id' => $apexCompany->id,
        ]);
        UnitOwner::create([
            'unit_id' => $unit3->id,
            'user_id' => $owner2->id,
            'share_percentage' => 100.00,
            'payout_terms' => '10% management fee. Remit by 28th of each month.',
        ]);

        // Unit 4: Greenhills Residences - Unit A, House, vacant, company owned
        $unit4 = Unit::create([
            'property_id' => $prop2->id,
            'unit_number' => 'Unit A',
            'type' => 'house',
            'status' => 'vacant',
            'ownership_type' => 'company_owned',
            'rent_amount' => 120000.00,
            'security_deposit' => 240000.00,
            'company_id' => $greenhillsCompany->id,
        ]);

        // Unit 5: Greenhills Residences - Unit B, House, occupied, company owned
        $unit5 = Unit::create([
            'property_id' => $prop2->id,
            'unit_number' => 'Unit B',
            'type' => 'house',
            'status' => 'occupied',
            'ownership_type' => 'company_owned',
            'rent_amount' => 130000.00,
            'security_deposit' => 260000.00,
            'company_id' => $greenhillsCompany->id,
        ]);

        // Unit 6: Greenhills Residences - Unit C, House, under_maintenance, company owned
        $unit6 = Unit::create([
            'property_id' => $prop2->id,
            'unit_number' => 'Unit C',
            'type' => 'house',
            'status' => 'under_maintenance',
            'ownership_type' => 'company_owned',
            'rent_amount' => 110000.00,
            'security_deposit' => 220000.00,
            'company_id' => $greenhillsCompany->id,
        ]);

        // 6. Create Leases
        // Lease 1: Unit 2 occupied by Tenant 1 (Juan)
        $lease1 = Lease::create([
            'unit_id' => $unit2->id,
            'tenant_id' => $tenant1->id,
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'rent_amount' => 55000.00,
            'security_deposit' => 110000.00,
            'status' => 'active',
            'move_in_date' => '2026-01-01',
            'terms' => 'Standard residential lease agreement. Pet friendly.',
            'company_id' => $apexCompany->id,
        ]);

        // Lease 2: Unit 3 occupied by Tenant 2 (Jose)
        $lease2 = Lease::create([
            'unit_id' => $unit3->id,
            'tenant_id' => $tenant2->id,
            'start_date' => '2026-02-01',
            'end_date' => '2027-01-31',
            'rent_amount' => 60000.00,
            'security_deposit' => 120000.00,
            'status' => 'active',
            'move_in_date' => '2026-02-01',
            'terms' => 'Two months security deposit, one month advance.',
            'company_id' => $apexCompany->id,
        ]);

        // Lease 3: Unit 5 occupied by Tenant 3 (Andres)
        $lease3 = Lease::create([
            'unit_id' => $unit5->id,
            'tenant_id' => $tenant3->id,
            'start_date' => '2026-03-01',
            'end_date' => '2027-02-28',
            'rent_amount' => 130000.00,
            'security_deposit' => 260000.00,
            'status' => 'active',
            'move_in_date' => '2026-03-01',
            'terms' => 'Corporate lease agreement.',
            'company_id' => $greenhillsCompany->id,
        ]);

        // 7. Invoices, Payments, & Remittances
        // --- Lease 1 (Rent = 55k. Jan, Feb, Mar, Apr paid. May unpaid.)
        $months1 = [
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
        ];

        foreach ($months1 as $num => $name) {
            $isPaid = ($name !== 'May');
            $invoice = Invoice::create([
                'lease_id' => $lease1->id,
                'tenant_id' => $tenant1->id,
                'invoice_number' => "INV-2026-{$num}-102",
                'due_date' => "2026-{$num}-05",
                'amount_due' => 55000.00,
                'amount_paid' => $isPaid ? 55000.00 : 0.00,
                'status' => $isPaid ? 'paid' : 'unpaid',
                'type' => 'rent',
                'notes' => "{$name} 2026 Monthly Rent Invoice",
                'company_id' => $apexCompany->id,
            ]);

            if ($isPaid) {
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'amount' => 55000.00,
                    'payment_date' => "2026-{$num}-02",
                    'payment_method' => $num % 2 === 0 ? 'bank_transfer' : 'gcash',
                    'transaction_reference' => 'TXN'.rand(1000000, 9999999),
                    'status' => 'approved',
                    'company_id' => $apexCompany->id,
                ]);

                // Create Remittance for Enrique Zobel
                // Jan has a deduction of 3.5k repair
                $repairs = ($num === '01') ? 3500.00 : 0.00;
                $remitAmount = 55000.00 * 0.90 - $repairs; // 10% fee

                Remittance::create([
                    'owner_id' => $owner1->id,
                    'unit_id' => $unit2->id,
                    'remittance_date' => "2026-{$num}-28",
                    'amount' => $remitAmount,
                    'status' => 'transferred',
                    'company_id' => $apexCompany->id,
                ]);
            }
        }

        // --- Lease 2 (Rent = 60k. Feb, Mar, Apr paid. May overdue!)
        $months2 = [
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
        ];

        foreach ($months2 as $num => $name) {
            $isPaid = ($name !== 'May');
            $isOverdue = ($name === 'May');

            $invoice = Invoice::create([
                'lease_id' => $lease2->id,
                'tenant_id' => $tenant2->id,
                'invoice_number' => "INV-2026-{$num}-103",
                'due_date' => "2026-{$num}-05",
                'amount_due' => 60000.00,
                'amount_paid' => $isPaid ? 60000.00 : 0.00,
                'status' => $isPaid ? 'paid' : 'overdue',
                'type' => 'rent',
                'late_fee_applied' => $isOverdue ? 1500.00 : 0.00,
                'notes' => "{$name} 2026 Monthly Rent Invoice",
                'company_id' => $apexCompany->id,
            ]);

            if ($isPaid) {
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'amount' => 60000.00,
                    'payment_date' => "2026-{$num}-03",
                    'payment_method' => $num % 2 === 0 ? 'bank_transfer' : 'maya',
                    'transaction_reference' => 'TXN'.rand(1000000, 9999999),
                    'status' => 'approved',
                    'company_id' => $apexCompany->id,
                ]);

                // Create Remittance for Maria Ayala
                // Feb has deduction of 5k repair
                $repairs = ($num === '02') ? 5000.00 : 0.00;
                $remitAmount = 60000.00 * 0.90 - $repairs; // 10% fee

                Remittance::create([
                    'owner_id' => $owner2->id,
                    'unit_id' => $unit3->id,
                    'remittance_date' => "2026-{$num}-28",
                    'amount' => $remitAmount,
                    'status' => 'transferred',
                    'company_id' => $apexCompany->id,
                ]);
            }
        }

        // --- Lease 3 (Rent = 130k. Mar, Apr paid. May unpaid.)
        $months3 = [
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
        ];

        foreach ($months3 as $num => $name) {
            $isPaid = ($name !== 'May');
            Invoice::create([
                'lease_id' => $lease3->id,
                'tenant_id' => $tenant3->id,
                'invoice_number' => "INV-2026-{$num}-B",
                'due_date' => "2026-{$num}-05",
                'amount_due' => 130000.00,
                'amount_paid' => $isPaid ? 130000.00 : 0.00,
                'status' => $isPaid ? 'paid' : 'unpaid',
                'type' => 'rent',
                'notes' => "{$name} 2026 Monthly Rent Invoice",
                'company_id' => $greenhillsCompany->id,
            ]);
        }

        // 8. Create Expenses
        Expense::create([
            'unit_id' => $unit2->id,
            'expense_type' => 'repairs',
            'amount' => 3500.00,
            'expense_date' => '2026-01-15',
            'description' => 'Repaired kitchen pipe leak and replaced faucet fittings.',
            'paid_by' => 'company', // will be deducted from owner's remittance
            'company_id' => $apexCompany->id,
        ]);

        Expense::create([
            'unit_id' => $unit3->id,
            'expense_type' => 'repairs',
            'amount' => 5000.00,
            'expense_date' => '2026-02-20',
            'description' => 'Repaired bedroom circuit breaker and light switch replacement.',
            'paid_by' => 'owner',
            'company_id' => $apexCompany->id,
        ]);

        Expense::create([
            'unit_id' => $unit6->id,
            'expense_type' => 'maintenance',
            'amount' => 25000.00,
            'expense_date' => '2026-05-10',
            'description' => 'Interior repainting and general floor polishing under maintenance.',
            'paid_by' => 'company',
            'company_id' => $greenhillsCompany->id,
        ]);

        // 9. Maintenance Request Tickets
        MaintenanceRequest::create([
            'unit_id' => $unit2->id,
            'tenant_id' => $tenant1->id,
            'assigned_to' => $agent->id,
            'title' => 'Leaking kitchen pipe',
            'description' => 'Water is pooling under the kitchen sink. Please send a plumber.',
            'priority' => 'medium',
            'status' => 'completed',
            'estimated_cost' => 4000.00,
            'actual_cost' => 3500.00,
            'resolved_at' => Carbon::parse('2026-01-15 14:00:00'),
            'company_id' => $apexCompany->id,
        ]);

        MaintenanceRequest::create([
            'unit_id' => $unit3->id,
            'tenant_id' => $tenant2->id,
            'assigned_to' => null,
            'title' => 'Master bedroom aircon not cooling',
            'description' => 'The split type aircon runs but only blows fan air. It might need a cleaning or freon refill.',
            'priority' => 'high',
            'status' => 'pending',
            'company_id' => $apexCompany->id,
        ]);
    }
}
