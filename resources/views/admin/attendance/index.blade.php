@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            @if(isset($filterDate))
                Attendance: {{ \Carbon\Carbon::parse($filterDate)->format('d M, Y') }}
            @else
                Attendance Overview
            @endif
        </h2>
        <div class="d-flex gap-2">
            @if(isset($filterDate))
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Dates
                </a>
            @endif
            <form action="{{ route('admin.attendance.index') }}" method="GET" class="d-flex gap-2">
                <input type="date" name="date" class="form-control" value="{{ $filterDate ?? '' }}" required>
                <button type="submit" class="btn btn-primary">Go</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    @if(isset($attendances))
                        {{-- Detailed View --}}
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Employee</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $att)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-light text-primary rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold"
                                                style="width: 35px; height: 35px;">
                                                {{ substr($att->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $att->user->name }}</div>
                                                <div class="small text-muted">{{ $att->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $att->check_in }}</td>
                                    <td>{{ $att->check_out ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success px-3">Present</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No attendance records found for this date.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    @else
                        {{-- Grouped View --}}
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Total Present</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceDates as $dateRecord)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">
                                        {{ \Carbon\Carbon::parse($dateRecord->date)->format('d M, Y') }}
                                        <span class="text-muted small fw-normal ms-2">({{ $dateRecord->date }})</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-2">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <span class="fw-bold text-dark fs-5">{{ $dateRecord->total_present }}</span>
                                            <span class="text-muted ms-2">Employees</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.attendance.index', ['date' => $dateRecord->date]) }}"
                                            class="btn btn-sm btn-primary px-3 fw-bold shadow-sm">
                                            View Details <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            @if(isset($attendanceDates))
                {{ $attendanceDates->links() }}
            @endif
        </div>
    </div>
@endsection