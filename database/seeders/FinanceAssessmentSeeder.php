<?php

namespace Database\Seeders;

use App\Models\Assessment;
use Illuminate\Database\Seeder;

/**
 * Loads the "Finance Training Final Assessment" (v1.0, 40 questions, 100 marks)
 * so it can be managed from Dashboard > Assessments.
 *
 * Run once with: php artisan db:seed --class=FinanceAssessmentSeeder
 * Safe to re-run: it does nothing if the assessment already exists.
 */
class FinanceAssessmentSeeder extends Seeder
{
    public function run(): void
    {
        $title = 'Finance Training Final Assessment';
        if (Assessment::where('title', $title)->exists()) {
            $this->command?->info('Assessment already exists - skipped.');
            return;
        }

        $assessment = Assessment::create([
            'title' => $title,
            'version' => '1.0',
            'description' => 'Apply accounting knowledge to the decisions you make at work. Final assessment for the Finance team. All amounts are in Rwandan francs (RWF). Ignore tax unless a question states otherwise. A calculator is allowed.',
            'pass_mark' => 70,
            'marks_per_question' => 2.5,
            'suggested_minutes' => 60,
            'status' => 'Draft',
        ]);

        foreach ($this->content() as $moduleIndex => $moduleData) {
            $module = $assessment->modules()->create(['title' => $moduleData['title'], 'position' => $moduleIndex + 1]);

            foreach ($moduleData['questions'] as $i => $q) {
                $isChoice = isset($q['options']);
                $options = null;
                if ($isChoice) {
                    $options = [];
                    foreach ($q['options'] as $n => $text) {
                        $options[chr(65 + $n)] = $text;
                    }
                }

                $module->questions()->create([
                    'assessment_id' => $assessment->id,
                    'position' => $i + 1,
                    'type' => $isChoice ? 'choice' : 'number',
                    'body' => $q['q'],
                    'options' => $options,
                    'correct_answer' => (string) $q['answer'],
                    'tolerance' => $q['tolerance'] ?? 0.01,
                    'unit' => $q['unit'] ?? null,
                ]);
            }
        }

        $this->command?->info('Finance assessment loaded as Draft. Set it to Active when ready.');
    }

    private function content(): array
    {
        return [
            [
                'title' => 'Accounting fundamentals',
                'questions' => [
                    ['q' => 'Services worth RWF 600,000 were completed in September and paid in October. Under accrual accounting, when is revenue recognized?',
                        'options' => ['October', 'When the bank reconciles', 'September', 'At year-end only'], 'answer' => 'C'],
                    ['q' => 'An annual insurance policy costing RWF 1,200,000 starts on 1 January. What adjustment is required at 31 January?',
                        'options' => ['Debit insurance expense 100,000; credit prepaid insurance 100,000', 'Debit prepaid insurance 1,200,000; credit revenue 1,200,000', 'No adjustment', 'Debit insurance expense 1,200,000; credit cash 1,200,000 again'], 'answer' => 'A'],
                    ['q' => 'A business has assets of RWF 18,000,000 and liabilities of RWF 7,000,000. Calculate equity in RWF.',
                        'answer' => 11000000, 'unit' => 'RWF'],
                    ['q' => 'A RWF 2,000,000 bank loan is received. Which entry is correct?',
                        'options' => ['Debit loan expense; credit bank', 'Debit loan liability; credit bank', 'Debit bank; credit sales', 'Debit bank; credit loan liability'], 'answer' => 'D'],
                    ['q' => 'December electricity of RWF 150,000 is unpaid and not yet recorded. Which year-end entry is required?',
                        'options' => ['Debit bank; credit electricity expense', 'No entry until payment', 'Debit electricity expense; credit accrued liability', 'Debit prepaid expense; credit bank'], 'answer' => 'C'],
                    ['q' => 'The owner pays a private school fee using company cash. How should this be recorded for a sole proprietor?',
                        'options' => ['Office equipment', 'Drawings, not a business expense', 'Staff training expense', 'Sales discount'], 'answer' => 'B'],
                    ['q' => 'Which error can exist even when a trial balance balances?',
                        'options' => ['Only one side of an entry was doubled', 'An entire transaction was omitted', 'A debit was added to the credit total only', 'A debit was entered without its credit'], 'answer' => 'B'],
                    ['q' => 'Which is the strongest month-end closing practice?',
                        'options' => ['Delete unreconciled differences', 'Reconcile bank and subledgers, post supported adjustments, then review and close the period', 'Close immediately when debit and credit totals agree', 'Allow everyone to backdate entries after closing'], 'answer' => 'B'],
                ],
            ],
            [
                'title' => 'QuickBooks Online',
                'questions' => [
                    ['q' => 'Goods are delivered on credit; the customer will pay in 30 days. Which transaction should record the sale?',
                        'options' => ['Bill', 'Sales receipt', 'Invoice', 'Purchase order'], 'answer' => 'C'],
                    ['q' => 'A customer pays an invoice already recorded. What should you use to avoid recording revenue twice?',
                        'options' => ['Record a new sales receipt for the same sale', 'Credit revenue again using a journal', 'Create a second invoice', 'Receive payment linked to the invoice'], 'answer' => 'D'],
                    ['q' => 'A supplier invoice is received for goods accepted, payable next month. Which transaction records the amount owed?',
                        'options' => ['Sales receipt', 'Estimate', 'Bill', 'Customer credit note'], 'answer' => 'C'],
                    ['q' => 'An already recorded supplier bill is paid from the bank. What should you do?',
                        'options' => ['Enter the purchase again as a new expense', 'Create a customer invoice', 'Record a bill payment applied to that bill', 'Delete the bill'], 'answer' => 'C'],
                    ['q' => 'A bank-feed payment matches an expense already entered. What is the correct treatment?',
                        'options' => ['Ignore all bank-feed transactions', 'Add it again as a new expense', 'Record it as revenue', 'Match to the existing transaction after checking details'], 'answer' => 'D'],
                    ['q' => 'Which master-data arrangement is appropriate before entering regular transactions?',
                        'options' => ['Create a fresh account for every invoice', 'Set up customers, suppliers, products/services and suitable chart-of-accounts codes', 'Use revenue accounts for all bank payments', 'Use one supplier named All Suppliers'], 'answer' => 'B'],
                    ['q' => 'Which report best identifies overdue customer invoices for collection?',
                        'options' => ['Accounts payable aging', 'Accounts receivable aging', 'Purchase order list only', 'Fixed asset register'], 'answer' => 'B'],
                    ['q' => 'A supplier sends the same invoice twice. What should happen before entry and payment?',
                        'options' => ['Enter both because there are two documents', 'Change the number and pay both', 'Use a journal to hide the duplicate', 'Check supplier, invoice number, amount and existing records; reject the duplicate'], 'answer' => 'D'],
                ],
            ],
            [
                'title' => 'Financial reporting',
                'questions' => [
                    ['q' => 'Revenue is RWF 12,000,000 and cost of sales is RWF 7,200,000. Calculate gross profit in RWF.',
                        'answer' => 4800000, 'unit' => 'RWF'],
                    ['q' => 'Using revenue of RWF 12,000,000 and gross profit of RWF 4,800,000, calculate gross profit margin as a percentage. Enter 40 for 40%.',
                        'answer' => 40, 'unit' => '%'],
                    ['q' => 'Which report shows assets, liabilities and equity at a specific date?',
                        'options' => ['Statement of financial position', 'Statement of profit or loss', 'Cash forecast only', 'Supplier aging only'], 'answer' => 'A'],
                    ['q' => 'Which report most directly shows individual postings and movements in an account?',
                        'options' => ['Asset-location list', 'General ledger', 'Statement of changes in equity only', 'Customer contact list'], 'answer' => 'B'],
                    ['q' => 'Profit is positive, but customers have not paid and the business cannot meet payroll. Which conclusion is best?',
                        'options' => ['Profit does not guarantee cash availability; review receivables and cash flows', 'Unpaid invoices are cash in the bank', 'Positive profit proves cash is sufficient', 'Payroll should be treated as an asset'], 'answer' => 'A'],
                    ['q' => 'Opening inventory is RWF 2,000,000, net purchases are RWF 6,000,000 and closing inventory is RWF 1,500,000. Calculate cost of sales in RWF.',
                        'answer' => 6500000, 'unit' => 'RWF'],
                    ['q' => 'Trade receivables in the general ledger differ from the receivables aging total. What should happen before issuing financial statements?',
                        'options' => ['Investigate and reconcile the difference', 'Issue the reports without review', 'Delete old customer balances', 'Use whichever number is higher'], 'answer' => 'A'],
                    ['q' => 'Revenue increased by 20%, but the gross profit margin fell from 40% to 25%. What is the most useful next step?',
                        'options' => ['Classify purchases as assets to increase profit', 'Conclude performance improved based only on revenue', 'Stop preparing cost reports', 'Analyze selling prices, product mix and unit costs'], 'answer' => 'D'],
                ],
            ],
            [
                'title' => 'Asset management',
                'questions' => [
                    ['q' => 'A machine costs RWF 5,000,000 plus delivery of 200,000 and necessary installation of 300,000. Staff training costs 100,000. Ignore tax. What is the initial machine cost?',
                        'options' => ['RWF 5,000,000', 'RWF 5,200,000', 'RWF 5,500,000', 'RWF 5,600,000'], 'answer' => 'C'],
                    ['q' => 'A machine costs RWF 5,500,000, has residual value RWF 500,000 and a five-year useful life. Calculate annual straight-line depreciation in RWF.',
                        'answer' => 1000000, 'unit' => 'RWF'],
                    ['q' => 'The same machine is ready for use on 1 October. Use monthly depreciation and a 31 December year-end. Calculate first-year depreciation in RWF.',
                        'answer' => 250000, 'unit' => 'RWF'],
                    ['q' => 'Which set of fields makes an asset register useful for accounting and custody?',
                        'options' => ['Only depreciation expense total', 'Only asset name and purchase price', 'Only supplier phone number', 'Asset ID, description, cost, ready-for-use date, useful life, residual value, depreciation, location and custodian'], 'answer' => 'D'],
                    ['q' => 'An asset costs RWF 4,000,000 and accumulated depreciation is RWF 2,500,000. It is sold for RWF 1,200,000 with no disposal costs. Calculate the loss in RWF as a positive amount.',
                        'answer' => 300000, 'unit' => 'RWF'],
                    ['q' => 'An asset cannot be found during physical verification. What should the finance team do first?',
                        'options' => ['Stop all depreciation for every asset', 'Investigate with the custodian and review movement records, then document and approve any adjustment', 'Immediately delete it from the register', 'Assume it is still present'], 'answer' => 'B'],
                    ['q' => 'Routine repairs restore a vehicle to its previous condition and do not extend its useful life. How should they be treated?',
                        'options' => ['Expense as repairs and maintenance', 'Recognize revenue', 'Always add them to vehicle cost', 'Reduce loan liability'], 'answer' => 'A'],
                    ['q' => 'What is the best reconciliation control over fixed assets?',
                        'options' => ['Reconcile register cost and accumulated depreciation to the general ledger and investigate differences', 'Reconcile the register only to supplier phone numbers', 'Keep disposed assets in use forever', 'Use the purchase budget as the closing asset balance'], 'answer' => 'A'],
                ],
            ],
            [
                'title' => 'Working capital & purchasing',
                'questions' => [
                    ['q' => 'Inventory consists of 100 units at RWF 10,000 each, then a purchase of 50 units at RWF 12,000 each. Under FIFO, calculate the cost of issuing 120 units in RWF.',
                        'answer' => 1240000, 'unit' => 'RWF'],
                    ['q' => 'There are 100 units at RWF 10,000 each and 100 units at RWF 14,000 each, with no other inventory. Calculate weighted-average cost per unit in RWF.',
                        'answer' => 12000, 'unit' => 'RWF'],
                    ['q' => 'An inventory item costs RWF 30,000. Expected selling price is 28,000 and selling costs are 2,000. What amount should be used under lower of cost and net realizable value?',
                        'options' => ['RWF 26,000', 'RWF 28,000', 'RWF 30,000', 'RWF 32,000'], 'answer' => 'A'],
                    ['q' => 'Which sequence best represents a controlled purchase process?',
                        'options' => ['Supplier bill / automatic payment with no checks', 'Approved requisition / quotations/evaluation / approved purchase order / goods receipt / matched bill / approved payment', 'Goods receipt / delete purchase order / payment', 'Payment / requisition / receipt / quotation'], 'answer' => 'B'],
                    ['q' => 'Which three documents normally support a three-way match for purchased goods?',
                        'options' => ['Purchase order, goods received note and supplier invoice', 'Bank statement, customer invoice and payroll', 'Requisition, customer receipt and sales order', 'Quotation, bank loan and asset register'], 'answer' => 'A'],
                    ['q' => 'The supplier bills 120 units but the goods received note confirms only 100. What should finance do?',
                        'options' => ['Hold approval of the disputed amount and resolve the discrepancy with receiving and the supplier', 'Pay 120 units without inquiry', 'Record the difference as sales', 'Alter the receipt to 120 without verification'], 'answer' => 'A'],
                    ['q' => 'Current assets are RWF 9,000,000 and current liabilities RWF 6,000,000. Calculate the current ratio. Enter a number, not a percentage.',
                        'answer' => 1.5, 'unit' => 'ratio'],
                    ['q' => 'Opening cash is RWF 2,000,000. Expected receipts are 3,000,000 and planned payments are 6,500,000. Calculate the funding shortfall in RWF as a positive amount.',
                        'answer' => 1500000, 'unit' => 'RWF'],
                ],
            ],
        ];
    }
}
