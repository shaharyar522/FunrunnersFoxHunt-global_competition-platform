@extends('layouts.admin')

@section('title', 'Contestants List')
@section('page_title', 'Contestant Management')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">All Contestants (Women)</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">

                <tr>
                    <th class="px-8 py-4 font-medium">Name</th>
                    <th class="px-8 py-4 font-medium">Contact</th>
                    <th class="px-8 py-4 font-medium">Region</th>
                    <th class="px-8 py-4 font-medium">Profile Status</th>
                    <th class="px-8 py-4 font-medium">Status</th>
                    <th class="px-8 py-4 font-medium">Action</th>
                </tr>
                
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($contestants as $contestant)
                <tr class="hover:bg-gray-50 transition-all">
                    <td class="px-8 py-5 text-sm font-medium text-gray-900">{{ $contestant->name }}</td>
                    <td class="px-8 py-5 text-sm text-gray-600">{{ $contestant->contact ?? 'N/A' }}</td>
                    <td class="px-8 py-5 text-sm text-gray-600">{{ $contestant->region->name ?? 'N/A' }}</td>
                    <td class="px-8 py-5">
                        @if($contestant->profile_status == 1)
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Complete</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Incomplete</span>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <button
                            onclick="toggleStatus({{ $contestant->id }}, {{ $contestant->status }}, this)"
                            class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 hover:scale-105 cursor-pointer status-btn-{{ $contestant->id }}
                            @if($contestant->status == 1) bg-blue-100 text-blue-700 hover:bg-blue-200 @else bg-gray-100 text-gray-700 hover:bg-gray-200 @endif">
                            <span class="status-text-{{ $contestant->id }}">
                                @if($contestant->status == 1) Approved @else Pending @endif
                            </span>
                        </button>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button onclick="editContestant({{ $contestant->id }})" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Contestant Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Edit Contestant Profile</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <form id="editForm">
                <input type="hidden" id="edit_id">
                <div class="px-6 py-4 space-y-4">

                    <div>
                        
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="edit_name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">

                    </div>

                    <div>

                        <label class="block text-sm font-medium text-gray-700">Phone / Contact</label>
                        <input type="text" id="edit_contact" name="contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">

                    </div>

                    <div>

                        <label class="block text-sm font-medium text-gray-700">Region</label>

                        <select id="edit_region" name="region_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Profile Status</label>
                        <select id="edit_profile_status" name="profile_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                            <option value="0">Incomplete</option>
                                <option value="1">Complete</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" id="edit_dob" name="date_of_birth" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
                    <button type="submit" id="saveBtn" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  
$(document).ready(function() {
    // CSRF Token Setup for jQuery
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle Form Submit using jQuery
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        saveContestant();
    });
});

function toggleStatus(contestantId, currentStatus, button) {
    const newStatus = currentStatus === 1 ? 0 : 1;
    const $btn = $(button);

    $btn.prop('disabled', true).css('opacity', '0.6');

    $.post("{{ route('admin.contestants.toggle', ':id') }}".replace(':id', contestantId), { status: newStatus })
        .done(function(data) {
            if (data.success) {
                const $statusText = $btn.find(`.status-text-${contestantId}`);
                if (newStatus === 1) {
                    $btn.attr('class', `px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 hover:scale-105 cursor-pointer bg-blue-100 text-blue-700 hover:bg-blue-200`);
                    $statusText.text('Approved');
                } else {
                    $btn.attr('class', `px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 hover:scale-105 cursor-pointer bg-gray-100 text-gray-700 hover:bg-gray-200`);
                    $statusText.text('Pending');
                }
                $btn.attr('onclick', `toggleStatus(${contestantId}, ${newStatus}, this)`);
                showSuccessMessage('Status updated!');
            }
        })
        .fail(function() { alert('Error updating status'); })
        .always(function() { $btn.prop('disabled', false).css('opacity', '1'); });
}

function editContestant(id) {
    $('#editModal').removeClass('hidden');
    $('#edit_id').val(id);

    let url = "{{ route('admin.contestants.get', ':id') }}".replace(':id', id);

    $.get(url, function(data) {
        $('#edit_name').val(data.name);
        $('#edit_contact').val(data.contact || '');
        $('#edit_region').val(data.region_id);
        $('#edit_profile_status').val(data.profile_status);
        $('#edit_dob').val(data.date_of_birth);
    });
}

function closeModal() {
    $('#editModal').addClass('hidden');
}

function saveContestant() {
    const id = $('#edit_id').val();
    
    const $saveBtn = $('#saveBtn');

    $saveBtn.prop('disabled', true).text('Saving...');

    const formData = {
        name: $('#edit_name').val(),
        contact: $('#edit_contact').val(),
        region_id: $('#edit_region').val(),
        profile_status: $('#edit_profile_status').val(),
        date_of_birth: $('#edit_dob').val(),
    };

    let url = "{{ route('admin.contestants.update', ':id') }}".replace(':id', id);

    $.post(url, formData)
        .done(function(data) {
            if (data.success) {
                showSuccessMessage('Profile updated!');
                location.reload();
            }
        })
        .fail(function() { alert('Update failed'); })
        .always(function() { $saveBtn.prop('disabled', false).text('Save Changes'); });
}

function showSuccessMessage(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
}
</script>
@endsection
