@extends('layouts.app')

@section('title', 'Laporan - Restaurant POS')
@section('page-title', 'Laporan')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar me-2"></i>
                    Filter Periode
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('laporan.generate') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" 
                               class="form-control" 
                               id="start_date" 
                               name="start_date" 
                               value="{{ $data['start_date'] }}" 
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" 
                               class="form-control" 
                               id="end_date" 
                               name="end_date" 
                               value="{{ $data['end_date'] }}" 
                               required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>
                            Generate Laporan
                        </button>
                        <button type="button" class="btn btn-success" onclick="generatePdf()">
                            <i class="fas fa-file-pdf me-2"></i>
                            Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
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

<script>
function generatePdf() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    if (!startDate || !endDate) {
        alert('Silakan pilih tanggal mulai dan tanggal akhir terlebih dahulu.');
        return;
    }
    
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
    startDateInput.value = startDate;
    form.appendChild(startDateInput);
    
    // Add end date
    const endDateInput = document.createElement('input');
    endDateInput.type = 'hidden';
    endDateInput.name = 'end_date';
    endDateInput.value = endDate;
    form.appendChild(endDateInput);
    
    // Submit form
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
</script>
@endsection
