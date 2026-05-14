@extends('layouts.app')
@section('title', 'Maintenance Board')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e]">Maintenance Board</h1>
    <button id="openAddReportBtn" class="bg-[#7c3a1e] hover:bg-[#6b3219] text-white px-4 py-2 rounded-lg font-medium text-[13px] flex items-center gap-2 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Add Report
    </button>
</div>

{{-- ── CONTENT GRID ─────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT: Toolbar + Table --}}
    <div class="col-span-1 lg:col-span-2 space-y-4">

        {{-- Toolbar --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
            <div class="flex items-center gap-2 bg-white border border-[#ede7df] rounded-lg px-3.5 py-2 text-[12px] sm:text-[13px] text-[#2d1a0e] font-medium whitespace-nowrap w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                <span id="monthDisplay">{{ $currentMonth }}</span>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('maintenance', ['month' => $previousMonth, 'year' => $previousYear]) }}" class="bg-white border border-[#ede7df] rounded-lg px-3 py-2 text-[#2d1a0e] hover:bg-[#faf7f4] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </a>
                <a href="{{ route('maintenance', ['month' => $nextMonth, 'year' => $nextYear]) }}" class="bg-white border border-[#ede7df] rounded-lg px-3 py-2 text-[#2d1a0e] hover:bg-[#faf7f4] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5L15.75 12l-7.5 7.5" />
                    </svg>
                </a>
            </div>

            <div class="relative flex-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[13px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
</span>
                <input type="text" id="searchInput" placeholder="  Search logs..."
                       class="w-full pl-8 pr-4 py-2 border border-[#e5e7eb] rounded-lg text-[12px] outline-none focus:border-[#7c3a1e] transition-colors bg-white text-gray-600">
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl border border-[#ede7df] overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-[#faf7f4]">
                    <tr>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3">Reference ID</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3">Subject / Issue</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden md:table-cell">Location / Unit</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden lg:table-cell">Assigned To</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden md:table-cell">Priority</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3">Status</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden md:table-cell">Reported</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody id="maintenanceTableBody">
                    @php $activeTickets = collect($tickets)->where('status', '!=', 'RESOLVED'); @endphp
                    @forelse ($activeTickets as $ticket)
                    <tr id="ticket-row-{{ $ticket['id'] }}" class="border-t border-[#f0ebe5] hover:bg-[#faf7f4] transition-colors ticket-row" data-ticket-id="{{ $ticket['id'] }}" data-subject="{{ $ticket['subject'] }}" data-location="{{ $ticket['location'] }}" data-status="{{ $ticket['status'] }}" data-assigned="{{ $ticket['assigned'] ? 'true' : 'false' }}">
                        <td class="px-4 py-3.5 font-mono text-[11px] text-gray-400">{{ $ticket['ref'] }}</td>
                        <td class="px-4 py-3.5 text-[13px] font-semibold text-[#2d1a0e]">{{ $ticket['subject'] }}</td>
                        <td class="px-4 py-3.5 hidden md:table-cell">
                            <span class="text-[11px] text-gray-400 mr-0.5"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
</span>
                            <span class="text-[12px] text-gray-500">{{ $ticket['location'] }}</span>
                        </td>
                        <td class="px-4 py-3.5 hidden lg:table-cell">
                            @if ($ticket['assigned'])
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-[#7c3a1e] flex items-center justify-center text-white text-[9px] font-bold">
                                        {{ $ticket['assignedInitials'] }}
                                    </div>
                                    <span class="text-[10px] text-gray-500">{{ $ticket['assignedName'] ?? 'Assigned' }}</span>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-[10px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
</div>
                                    <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">Unassigned</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 hidden md:table-cell">
                            @if ($ticket['priority'] === 'URGENT')
                                <span class="inline-block bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Urgent</span>
                            @elseif ($ticket['priority'] === 'NORMAL')
                                <span class="inline-block bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Normal</span>
                            @else
                                <span class="inline-block bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Medium</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5">
                            @if ($ticket['status'] === 'NEW')
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                    New
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-orange-50 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase whitespace-nowrap">
                                    In Progress
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-[11px] text-gray-400 whitespace-nowrap hidden md:table-cell">{{ $ticket['reported'] }}</td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="assignTechnician({{ $ticket['id'] }})" class="bg-[#f3f4f6] hover:bg-[#e5e7eb] text-[#374151] text-[10px] font-bold px-2.5 py-1.5 rounded transition-colors flex items-center gap-1 whitespace-nowrap" title="Assign technician">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h7.5M8.25 12h7.5M8.25 17.25h7.5" />
                                    </svg>
                                    Assign
                                </button>
                                <button onclick="resolveIssue({{ $ticket['id'] }})" class="bg-green-100 hover:bg-green-200 text-green-700 text-[10px] font-bold px-2.5 py-1.5 rounded transition-colors flex items-center gap-1 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Resolve
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="noReportsRow" class="border-t border-[#f0ebe5]">
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">No maintenance reports have been added yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- RIGHT: Calendar + Priority card + Summary --}}
    <div class="space-y-4">

        {{-- Calendar --}}
        <div class="bg-white rounded-xl border border-[#ede7df] p-4">
            <h3 class="text-[12px] font-bold text-[#2d1a0e] mb-3">Maintenance Calendar</h3>
            
            <div class="grid grid-cols-7 gap-1 text-center text-[10px]">
                {{-- Day headers --}}
                <div class="font-semibold text-gray-400 py-2">Mon</div>
                <div class="font-semibold text-gray-400 py-2">Tue</div>
                <div class="font-semibold text-gray-400 py-2">Wed</div>
                <div class="font-semibold text-gray-400 py-2">Thu</div>
                <div class="font-semibold text-gray-400 py-2">Fri</div>
                <div class="font-semibold text-gray-400 py-2">Sat</div>
                <div class="font-semibold text-gray-400 py-2">Sun</div>

                {{-- Calendar days --}}
                @foreach ($calendarDays as $day)
                    @if ($day === null)
                        <div></div>
                    @else
                        <div class="p-2 rounded @if($day['ticketCount'] > 0) bg-[#faf7f4] border @if($day['hasUrgent']) border-red-300 @else border-[#ede7df] @endif @else border border-transparent @endif">
                            <div class="font-medium text-[#2d1a0e]">{{ $day['day'] }}</div>
                            @if($day['ticketCount'] > 0)
                                <div class="text-[9px] @if($day['hasUrgent']) text-red-600 font-bold @else text-orange-600 @endif mt-0.5">
                                    {{ $day['ticketCount'] }} task{{ $day['ticketCount'] > 1 ? 's' : '' }}
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Summary Stats --}}
        <div class="bg-white rounded-xl border border-[#ede7df] p-5">
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-4">Summary</p>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">Open Tickets</span>
                    <span id="openTicketsCount" class="text-[13px] font-bold text-[#2d1a0e]">{{ $openTickets }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">In Progress</span>
                    <span id="inProgressCount" class="text-[13px] font-bold text-orange-600">{{ $inProgressTickets }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">Resolved This Month</span>
                    <span id="resolvedCount" class="text-[13px] font-bold text-green-600">{{ $resolvedTickets }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">Unassigned</span>
                    <span id="unassignedCount" class="text-[13px] font-bold text-red-600">{{ $unassignedTickets }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ADD MAINTENANCE REPORT MODAL --}}
<div id="addReportModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md">
        <div class="flex items-center justify-between p-6 border-b border-[#ede7df]">
            <h2 class="text-[18px] font-bold text-[#2d1a0e]">Add Maintenance Report</h2>
            <button onclick="closeAddReportModal()" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form id="addReportForm" onsubmit="handleAddReport(event)" class="p-6 space-y-4">
            <div>
                <label class="block text-[12px] font-semibold text-[#2d1a0e] mb-2">Issue Subject *</label>
                <input type="text" name="subject" required class="w-full px-3 py-2 border border-[#ede7df] rounded-lg text-[13px] focus:outline-none focus:border-[#7c3a1e]" placeholder="e.g., Water leak in bathroom">
            </div>

            <div>
                <label class="block text-[12px] font-semibold text-[#2d1a0e] mb-2">Location/Unit *</label>
                <select name="location" required class="w-full px-3 py-2 border border-[#ede7df] rounded-lg text-[13px] focus:outline-none focus:border-[#7c3a1e]">
                    <option value="">Select a unit...</option>
                    @foreach ($units as $unit)
                        <option value="Unit {{ $unit['number'] }}">
                            Unit {{ $unit['number'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[12px] font-semibold text-[#2d1a0e] mb-2">Date Reported *</label>
                <input type="date" name="report_date" required value="{{ now()->format('Y-m-d') }}" class="w-full px-3 py-2 border border-[#ede7df] rounded-lg text-[13px] focus:outline-none focus:border-[#7c3a1e]">
            </div>

            <div>
                <label class="block text-[12px] font-semibold text-[#2d1a0e] mb-2">Priority Level *</label>
                <select name="priority" required class="w-full px-3 py-2 border border-[#ede7df] rounded-lg text-[13px] focus:outline-none focus:border-[#7c3a1e]">
                    <option value="">Select priority...</option>
                    <option value="URGENT">🔴 Urgent</option>
                    <option value="NORMAL">🟠 Normal</option>
                    <option value="MEDIUM">🔵 Medium</option>
                </select>
            </div>

            <div>
                <label class="block text-[12px] font-semibold text-[#2d1a0e] mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-[#ede7df] rounded-lg text-[13px] focus:outline-none focus:border-[#7c3a1e]" placeholder="Provide more details about the issue..."></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeAddReportModal()" class="flex-1 px-4 py-2 border border-[#ede7df] text-[#2d1a0e] rounded-lg font-medium text-[13px] hover:bg-[#faf7f4] transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-[#7c3a1e] text-white rounded-lg font-medium text-[13px] hover:bg-[#6b3219] transition-colors">
                    Create Report
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.ticket-row');
    
    rows.forEach(row => {
        const subject = row.getAttribute('data-subject').toLowerCase();
        const location = row.getAttribute('data-location').toLowerCase();
        
        if (subject.includes(searchTerm) || location.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Modal functions
function openAddReportModal() {
    document.getElementById('addReportModal').classList.remove('hidden');
}

function closeAddReportModal() {
    document.getElementById('addReportModal').classList.add('hidden');
    document.getElementById('addReportForm').reset();
}

document.getElementById('openAddReportBtn').addEventListener('click', openAddReportModal);

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAddReportModal();
    }
});

// Handle form submission
function handleAddReport(e) {
    e.preventDefault();
    
    const formData = new FormData(document.getElementById('addReportForm'));
    const data = {
        subject: formData.get('subject'),
        location: formData.get('location'),
        report_date: formData.get('report_date'),
        priority: formData.get('priority'),
        description: formData.get('description'),
    };

    if (!data.subject || !data.location || !data.priority) {
        alert('Please complete all required fields.');
        return;
    }

    fetch("{{ route('maintenance.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            removeNoReportsPlaceholder();
            addTicketRow(result.ticket);
            updateSummaryCounts({ open: 1, unassigned: 1 });
            alert('Maintenance report added to the table.');
            closeAddReportModal();
        } else {
            alert('Error: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while creating the report.');
    });
}

function addTicketRow(ticket) {
    const tbody = document.getElementById('maintenanceTableBody');
    const row = document.createElement('tr');
    row.id = `ticket-row-${ticket.id}`;
    row.className = 'border-t border-[#f0ebe5] hover:bg-[#faf7f4] transition-colors ticket-row';
    row.dataset.ticketId = ticket.id;
    row.dataset.subject = ticket.subject;
    row.dataset.location = ticket.location;
    row.dataset.status = ticket.status;
    row.dataset.assigned = ticket.assigned ? 'true' : 'false';

    const statusLabel = ticket.status === 'NEW'
        ? '<span class="inline-flex items-center gap-1 bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase">New</span>'
        : '<span class="inline-flex items-center gap-1 bg-orange-50 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase whitespace-nowrap">In Progress</span>';

    const assignedCell = ticket.assigned
        ? `<div class="flex items-center gap-2"><div class="w-7 h-7 rounded-full bg-[#7c3a1e] flex items-center justify-center text-white text-[9px] font-bold">${ticket.assignedInitials || ''}</div><span class="text-[10px] text-gray-500">${ticket.assignedName || 'Assigned'}</span></div>`
        : `<div class="flex items-center gap-1.5"><div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-[10px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg></div><span class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">Unassigned</span></div>`;

    const priorityLabel = ticket.priority === 'URGENT'
        ? '<span class="inline-block bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Urgent</span>'
        : ticket.priority === 'NORMAL'
            ? '<span class="inline-block bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Normal</span>'
            : '<span class="inline-block bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Medium</span>';

    const reportedLabel = ticket.reported || 'just now';

    const assignButtonLabel = ticket.assigned ? 'Reassign' : 'Assign';

    row.innerHTML = `
        <td class="px-4 py-3.5 font-mono text-[11px] text-gray-400">${ticket.ref}</td>
        <td class="px-4 py-3.5 text-[13px] font-semibold text-[#2d1a0e]">${ticket.subject}</td>
        <td class="px-4 py-3.5 hidden md:table-cell">
            <span class="text-[11px] text-gray-400 mr-0.5"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg></span>
            <span class="text-[12px] text-gray-500">${ticket.location}</span>
        </td>
        <td class="px-4 py-3.5 hidden lg:table-cell">${assignedCell}</td>
        <td class="px-4 py-3.5 hidden md:table-cell">${priorityLabel}</td>
        <td class="px-4 py-3.5">${statusLabel}</td>
        <td class="px-4 py-3.5 text-[11px] text-gray-400 whitespace-nowrap hidden md:table-cell">${reportedLabel}</td>
        <td class="px-4 py-3.5">
            <div class="flex items-center gap-2">
                <button type="button" onclick="assignTechnician(${ticket.id})" class="bg-[#f3f4f6] hover:bg-[#e5e7eb] text-[#374151] text-[10px] font-bold px-2.5 py-1.5 rounded transition-colors flex items-center gap-1 whitespace-nowrap" title="Assign technician">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h7.5M8.25 12h7.5M8.25 17.25h7.5" />
                    </svg>
                    ${assignButtonLabel}
                </button>
                <button onclick="resolveIssue(${ticket.id})" class="bg-green-100 hover:bg-green-200 text-green-700 text-[10px] font-bold px-2.5 py-1.5 rounded transition-colors flex items-center gap-1 whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Resolve
                </button>
            </div>
        </td>
    `;

    tbody.prepend(row);
}

function updateSummaryCounts(changes) {
    const getNode = id => document.getElementById(id);

    if (changes.open) {
        getNode('openTicketsCount').textContent = Number(getNode('openTicketsCount').textContent) + changes.open;
    }
    if (changes.inProgress) {
        getNode('inProgressCount').textContent = Number(getNode('inProgressCount').textContent) + changes.inProgress;
    }
    if (changes.resolved) {
        getNode('resolvedCount').textContent = Number(getNode('resolvedCount').textContent) + changes.resolved;
    }
    if (changes.unassigned) {
        getNode('unassignedCount').textContent = Number(getNode('unassignedCount').textContent) + changes.unassigned;
    }
}

function removeNoReportsPlaceholder() {
    const placeholder = document.getElementById('noReportsRow');
    if (placeholder) {
        placeholder.remove();
    }
}

function showNoReportsPlaceholder() {
    const tbody = document.getElementById('maintenanceTableBody');
    if (!tbody.querySelector('tr')) {
        const row = document.createElement('tr');
        row.id = 'noReportsRow';
        row.className = 'border-t border-[#f0ebe5]';
        row.innerHTML = '<td colspan="8" class="px-4 py-8 text-center text-gray-500">No maintenance reports have been added yet.</td>';
        tbody.appendChild(row);
    }
}

function assignTechnician(ticketId) {
    const technician = prompt('Enter technician name to assign (e.g. Alex, Bella, Carlo):');
    if (!technician) {
        return;
    }

    const row = document.getElementById(`ticket-row-${ticketId}`);
    const assignedBefore = row && row.dataset.assigned === 'true';
    const oldStatus = row ? row.dataset.status : null;

    fetch(`/maintenance/${ticketId}/assign`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ technician })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && row) {
            row.dataset.assigned = 'true';
            row.dataset.assignedName = data.ticket.assignedName;
            row.dataset.assignedInitials = data.ticket.assignedInitials;
            row.dataset.status = data.ticket.status;

            const assignedCell = row.querySelector('td:nth-child(4)');
            if (assignedCell) {
                assignedCell.innerHTML = `<div class="flex items-center gap-2"><div class="w-7 h-7 rounded-full bg-[#7c3a1e] flex items-center justify-center text-white text-[9px] font-bold">${data.ticket.assignedInitials}</div><span class="text-[10px] text-gray-500">${data.ticket.assignedName}</span></div>`;
            }

            const statusCell = row.querySelector('td:nth-child(6)');
            if (statusCell) {
                statusCell.innerHTML = '<span class="inline-flex items-center gap-1 bg-orange-50 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase whitespace-nowrap">In Progress</span>';
            }

            if (!assignedBefore) {
                updateSummaryCounts({ unassigned: -1 });
            }
            if (oldStatus === 'NEW') {
                updateSummaryCounts({ open: -1, inProgress: 1 });
            }

            alert('Technician assigned successfully.');
        } else {
            alert('Could not assign technician: ' + (data.message || 'Unexpected error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Unable to assign technician at this time.');
    });
}

// Resolve issue function
function resolveIssue(ticketId) {
    if (!confirm('Mark this issue as resolved and remove from tracking?')) {
        return;
    }

    const row = document.getElementById(`ticket-row-${ticketId}`);
    if (row) {
        const status = row.dataset.status;
        row.remove();

        if (status === 'NEW') {
            updateSummaryCounts({ open: -1, unassigned: -1 });
        } else if (status === 'IN PROGRESS') {
            updateSummaryCounts({ inProgress: -1, unassigned: -1 });
        }

        if (document.getElementById('maintenanceTableBody').querySelectorAll('tr').length === 0) {
            showNoReportsPlaceholder();
        }
    }

    fetch(`/maintenance/${ticketId}/resolve`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload page to clear calendar and update utility tracking
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            alert('Resolved but issue updating: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Resolved but backend update failed.');
    });
}
</script>

@endsection
