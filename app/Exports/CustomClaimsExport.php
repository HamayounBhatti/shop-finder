<?php

namespace App\Exports;

use App\Models\Claim;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomClaimsExport implements FromCollection, WithHeadings, WithMapping
{
    protected Carbon $startDate;
    protected Carbon $endDate;

    public function __construct(Carbon $startDate, Carbon $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Claim::whereBetween('created_at', [
                $this->startDate,
                $this->endDate
            ])
            ->with('shops')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Claim#',
            'Articles#',
            'Invoice#',
            'Shop Manager',
            'Shop Name',
            'Claim Date',
            'Status',
            'Received Date',
        ];
    }

    public function map($claim): array
    {
        return [
            $claim->id,
            $claim->article_number,
            $claim->invoice,
            $claim->shop_manager ?? 'N/A',
            $claim->shops->name ?? 'N/A',
            $claim->created_at,
            $this->getStatusText($claim->status),
            $claim->received_date_and_time ? Carbon::parse($claim->received_date_and_time)->format('Y-m-d') : 'N/A',
        ];
    }

    protected function getStatusText($status): string
    {
        $statusMap = [
            0 => 'Pending',
            1 => 'Submitted',
            2 => 'Rejected',
            3 => 'Repairing',
            4 => 'Replacing',
            5 => 'Received',
            6 => 'Locally Closed'
        ];
        
        return $statusMap[$status] ?? 'Unknown';
    }
}