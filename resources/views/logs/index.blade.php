@extends('layouts.app')

@section('title', 'Xem Logs')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1 fw-bold">
                        <i class="bi bi-file-text-fill text-primary"></i> Application Logs
                    </h2>
                    <p class="text-muted mb-0">Monitor and debug your application logs</p>
                </div>
                <a href="{{ route('logs.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </a>
            </div>

            <!-- Filters Card -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('logs.index') }}" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="file" class="form-label fw-semibold">
                                    <i class="bi bi-file-earmark-text"></i> Log File
                                </label>
                                <select name="file" id="file" class="form-select form-select-lg" onchange="this.form.submit()">
                                    @foreach($logFiles as $file)
                                        <option value="{{ $file }}" {{ $selectedFile === $file ? 'selected' : '' }}>
                                            {{ $file }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="date" class="form-label fw-semibold">
                                    <i class="bi bi-calendar3"></i> Date
                                </label>
                                <select name="date" id="date" class="form-select form-select-lg" onchange="this.form.submit()">
                                    <option value="">All Dates</option>
                                    @foreach($availableDates as $date)
                                        <option value="{{ $date }}" {{ $selectedDate === $date ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="level" class="form-label fw-semibold">
                                    <i class="bi bi-funnel"></i> Level
                                </label>
                                <select name="level" id="level" class="form-select form-select-lg" onchange="this.form.submit()">
                                    <option value="all" {{ $level === 'all' ? 'selected' : '' }}>All Levels</option>
                                    <option value="debug" {{ $level === 'debug' ? 'selected' : '' }}>Debug</option>
                                    <option value="info" {{ $level === 'info' ? 'selected' : '' }}>Info</option>
                                    <option value="warning" {{ $level === 'warning' ? 'selected' : '' }}>Warning</option>
                                    <option value="error" {{ $level === 'error' ? 'selected' : '' }}>Error</option>
                                    <option value="critical" {{ $level === 'critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="search" class="form-label fw-semibold">
                                    <i class="bi bi-search"></i> Search
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="text" name="search" id="search" class="form-control" 
                                           value="{{ $search }}" placeholder="Search in logs...">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">&nbsp;</label>
                                <div class="d-grid">
                                    @if($selectedFile)
                                        <a href="{{ route('logs.download', $selectedFile) }}" class="btn btn-success btn-lg">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Logs Display by Date -->
            <div class="logs-container">
                @forelse($logsByDate as $date => $logs)
                    <div class="log-date-group mb-3">
                        <div class="card shadow-sm border-0 mb-2">
                            <div class="card-header bg-gradient-primary text-white p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-calendar-event-fill fs-4"></i>
                                        <div>
                                            <h5 class="mb-0 fw-bold">
                                                {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}
                                            </h5>
                                            <small class="opacity-75">
                                                {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                            </small>
                                        </div>
                                        <span class="badge bg-light text-dark fs-6 px-3 py-2">
                                            <i class="bi bi-list-ul"></i> {{ count($logs) }} logs
                                        </span>
                                    </div>
                                    <button class="btn btn-light btn-sm" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#date-{{ str_replace('-', '', $date) }}"
                                            aria-expanded="true">
                                        <i class="bi bi-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="collapse show" id="date-{{ str_replace('-', '', $date) }}">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0 logs-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 120px;" class="ps-4">Time</th>
                                                    <th style="width: 120px;">Level</th>
                                                    <th>Message</th>
                                                    <th style="width: 80px;" class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($logs as $log)
                                                    @php
                                                        $levelColors = [
                                                            'DEBUG' => ['bg' => 'bg-secondary', 'text' => 'text-white', 'icon' => 'bi-bug'],
                                                            'INFO' => ['bg' => 'bg-info', 'text' => 'text-white', 'icon' => 'bi-info-circle'],
                                                            'WARNING' => ['bg' => 'bg-warning', 'text' => 'text-dark', 'icon' => 'bi-exclamation-triangle'],
                                                            'ERROR' => ['bg' => 'bg-danger', 'text' => 'text-white', 'icon' => 'bi-x-circle'],
                                                            'CRITICAL' => ['bg' => 'bg-dark', 'text' => 'text-white', 'icon' => 'bi-exclamation-octagon'],
                                                        ];
                                                        $levelStyle = $levelColors[strtoupper($log['level'])] ?? $levelColors['DEBUG'];
                                                    @endphp
                                                    <tr class="log-row">
                                                        <td class="ps-4">
                                                            <span class="text-muted fw-medium">
                                                                <i class="bi bi-clock"></i> {{ $log['time'] }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ $levelStyle['bg'] }} {{ $levelStyle['text'] }} px-3 py-2">
                                                                <i class="bi {{ $levelStyle['icon'] }}"></i> {{ $log['level'] }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="log-message-wrapper">
                                                                <div class="log-message fw-medium">
                                                                    {{ Str::limit($log['message'], 150) }}
                                                                </div>
                                                                @if(!empty($log['context']))
                                                                    <button class="btn btn-link btn-sm text-decoration-none p-0 mt-1" 
                                                                            type="button" 
                                                                            data-bs-toggle="collapse" 
                                                                            data-bs-target="#context-{{ $date }}-{{ $loop->index }}">
                                                                        <i class="bi bi-chevron-right"></i> <small>View context</small>
                                                                    </button>
                                                                    <div class="collapse mt-2" id="context-{{ $date }}-{{ $loop->index }}">
                                                                        <div class="log-context">
                                                                            <pre class="mb-0">{{ $log['context'] }}</pre>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-sm btn-outline-primary" 
                                                                    onclick="copyToClipboard('{{ addslashes($log['message'] . "\n" . $log['context']) }}')"
                                                                    title="Copy to clipboard">
                                                                <i class="bi bi-clipboard"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                            <h5 class="mt-3 text-muted">No logs found</h5>
                            <p class="text-muted">Try adjusting your filters or select a different log file.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Actions -->
            @if($selectedFile)
                <div class="mt-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <form method="POST" action="{{ route('logs.clear', $selectedFile) }}" 
                                  onsubmit="return confirm('Are you sure you want to clear this log file? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Clear Log File
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show toast notification
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.innerHTML = '<i class="bi bi-check-circle"></i> Copied to clipboard!';
        document.body.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => document.body.removeChild(toast), 300);
        }, 2000);
    }, function(err) {
        console.error('Failed to copy: ', err);
        alert('Failed to copy to clipboard');
    });
}

// Auto-submit search on Enter
document.getElementById('search')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('filterForm').submit();
    }
});
</script>
@endpush

@push('styles')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --log-bg: #f8f9fa;
    --log-border: #e9ecef;
}

.logs-container {
    max-height: 75vh;
    overflow-y: auto;
    padding-right: 8px;
}

.logs-container::-webkit-scrollbar {
    width: 8px;
}

.logs-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.logs-container::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.logs-container::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.bg-gradient-primary {
    background: var(--primary-gradient) !important;
}

.log-date-group {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.logs-table {
    font-size: 0.9rem;
}

.log-row {
    transition: background-color 0.2s ease;
}

.log-row:hover {
    background-color: #f8f9fa !important;
}

.log-message-wrapper {
    max-width: 100%;
}

.log-message {
    font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
    font-size: 0.85rem;
    color: #212529;
    word-break: break-word;
    line-height: 1.6;
}

.log-context {
    background: #f8f9fa;
    border-left: 3px solid #007bff;
    padding: 12px;
    border-radius: 4px;
    margin-top: 8px;
}

.log-context pre {
    font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
    font-size: 0.8rem;
    color: #495057;
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.toast-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #28a745;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 9999;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.toast-notification.show {
    opacity: 1;
    transform: translateY(0);
}

.toast-notification i {
    margin-right: 8px;
}

.form-select-lg, .input-group-lg .form-control {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.form-select-lg:focus, .input-group-lg .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-lg {
    border-radius: 8px;
    font-weight: 500;
}

.table-light th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    color: #6c757d;
    border-bottom: 2px solid #dee2e6;
}

.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
}

.card-header {
    border-bottom: none;
}

@media (max-width: 768px) {
    .logs-container {
        max-height: 60vh;
    }
    
    .log-message {
        font-size: 0.75rem;
    }
}
</style>
@endpush
@endsection
