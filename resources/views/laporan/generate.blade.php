@extends('layouts.app')

@section('title', 'Generate Laporan - Restaurant POS')
@section('page-title', 'Generate Laporan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Laporan Periode: {{ \Carbon\Carbon::parse($data['start_date'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($data['end_date'])->format('d/m/Y') }}
                </h5>
            </div>
            <div class="card-body">
                @if($data['user']->isWaiter())
                    @include('laporan.pesanan-report')
                @elseif($data['user']->isCashier())
                    @include('laporan.transaksi-report')
                @elseif($data['user']->isOwner())
                    @include('laporan.pendapatan-report')
                    @include('laporan.transaksi-report')
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Filter
            </a>
            <div class="btn-group">
                <button onclick="generatePdf()" class="btn btn-success">
                    <i class="fas fa-file-pdf me-2"></i>
                    Download PDF
                </button>
                <button onclick="window.print()" class="btn btn-info">
                    <i class="fas fa-print me-2"></i>
                    Print
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    @media print {
        .btn, .card-header {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
function generatePdf() {
    // Determine report type based on user role
    let reportType = 'pesanan'; // default for waiter
    @if($data['user']->isCashier())
        reportType = 'transaksi';
    @elseif($data['user']->isOwner())
        reportType = 'pendapatan';
    @endif
    
    // Create form for PDF generation
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("laporan.pdf") }}';
    
    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    // Add report type
    const reportTypeInput = document.createElement('input');
    reportTypeInput.type = 'hidden';
    reportTypeInput.name = 'report_type';
    reportTypeInput.value = reportType;
    form.appendChild(reportTypeInput);
    
    // Add start date
    const startDateInput = document.createElement('input');
    startDateInput.type = 'hidden';
    startDateInput.name = 'start_date';
    startDateInput.value = '{{ $data["start_date"] }}';
    form.appendChild(startDateInput);
    
    // Add end date
    const endDateInput = document.createElement('input');
    endDateInput.type = 'hidden';
    endDateInput.name = 'end_date';
    endDateInput.value = '{{ $data["end_date"] }}';
    form.appendChild(endDateInput);
    
    // Submit form
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
</script>
@endsection
