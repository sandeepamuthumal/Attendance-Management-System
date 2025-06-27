@extends('layouts.app')


@section('title')
    Student Profile - {{ $student->full_name }}
@endsection

@section('content')
    <div class="container-fluid" style="padding-top:25px">
        <div class="row">
            <!-- Student Information Card -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Student Information</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.students.edit', $student->id) }}">
                                    <i class="bi bi-pencil-square"></i> Edit Student
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.students.download-qr', $student->id) }}">
                                    <i class="bi bi-download"></i> Download QR Code
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteStudent({{ $student->id }})">
                                   <i class="bi bi-trash"></i> Delete Student
                                </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- QR Code -->
                        <div class="text-center mb-3">
                            <div id="qr-code" class="mb-2">
                                <img src="{{ asset('qrcodes/' . $student->student_id . '.png') }}" alt="QR Code">
                            </div>
                            <small class="text-muted">QR Code for {{ $student->student_id }}</small>
                        </div>

                        <!-- Student Details -->
                        <div class="student-details">
                            <div class="detail-row">
                                <strong>Student ID:</strong>
                                <span class="badge bg-primary">{{ $student->student_id }}</span>
                            </div>
                            <div class="detail-row">
                                <strong>Name:</strong>
                                <span>{{ $student->full_name }}</span>
                            </div>
                            <div class="detail-row">
                                <strong>Email:</strong>
                                <span>{{ $student->email }}</span>
                            </div>
                            <div class="detail-row">
                                <strong>NIC:</strong>
                                <span>{{ $student->nic }}</span>
                            </div>
                            <div class="detail-row">
                                <strong>Contact:</strong>
                                <span>{{ $student->contact_no }}</span>
                            </div>
                            <div class="detail-row">
                                <strong>Parent Contact:</strong>
                                <span>{{ $student->parent_contact_no }}</span>
                            </div>
                            <div class="detail-row">
                                <strong>Address:</strong>
                                <span>{{ $student->address }}</span>
                            </div>
                            <div class="detail-row">
                                <strong>Status:</strong>
                                <span class="badge bg-{{ $student->status ? 'success' : 'danger' }}">
                                    {{ $student->status_text }}
                                </span>
                            </div>
                            <div class="detail-row">
                                <strong>Registered:</strong>
                                <span>{{ $student->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classes Information -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Enrolled Classes</h5>
                            <button class="btn btn-sm btn-primary" onclick="manageClasses()">
                               <i class="bi bi-plus-circle"></i> Manage Classes
                            </button>
                    </div>
                    <div class="card-body">
                        @if($classes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Subject</th>
                                            <th>Teacher</th>
                                            <th>Grade</th>
                                            <th>Year</th>
                                            <th>Enrolled Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($classes as $enrollment)
                                            <tr>
                                                <td>{{ $enrollment->class->class_name }}</td>
                                                <td>{{ $enrollment->class->subject->subject }}</td>
                                                <td>{{ $enrollment->class->teacher->user->full_name }}</td>
                                                <td>{{ $enrollment->class->grade->grade }}</td>
                                                <td>{{ $enrollment->class->year }}</td>
                                                <td>{{ $enrollment->enrolled_date->format('M d, Y') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $enrollment->status ? 'success' : 'danger' }}">
                                                        {{ $enrollment->status ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($enrollment->status)
                                                        <button class="btn btn-sm btn-danger"
                                                                onclick="unenrollFromClass({{ $student->id }}, {{ $enrollment->classes_id }})">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-sm btn-success"
                                                                onclick="enrollToClass({{ $student->id }}, {{ $enrollment->classes_id }})">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-mortarboard text-muted mb-3"></i>
                                <h5 class="text-muted">No Classes Enrolled</h5>
                                <p class="text-muted">This student is not enrolled in any classes yet.</p>
                                <button class="btn btn-primary" onclick="manageClasses()">
                                    <i class="bi bi-plus-circle"></i> Enroll in Classes
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row strong {
            color: #495057;
            min-width: 120px;
        }

        #qr-code {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            display: inline-block;
        }

        .student-details {
            margin-top: 15px;
        }
    </style>
@endpush

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <script>
        $(document).ready(function() {
            generateQRCode();
        });

        function generateQRCode() {
            const qrData = {!! json_encode($student->qr_code_data) !!};

            QRCode.toCanvas(document.createElement('canvas'), JSON.stringify(qrData), {
                width: 200,
                margin: 2,
                color: {
                    dark: '#000000',
                    light: '#FFFFFF'
                }
            }, function (error, canvas) {
                if (error) {
                    console.error('QR Code generation failed:', error);
                    $('#qr-code').html('<p class="text-danger">Failed to generate QR code</p>');
                } else {
                    $('#qr-code').html(canvas);
                }
            });
        }

        function manageClasses() {
            // Redirect to edit page or open modal for class management
            window.location.href = '{{ route("admin.students.edit", $student->id) }}#step-3';
        }

        function unenrollFromClass(studentId, classId) {
            Swal.fire({
                title: 'Unenroll from Class?',
                text: 'Student will be removed from this class.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, unenroll!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Implementation for unenrolling
                    toastr.info('Feature coming soon!');
                }
            });
        }

        function enrollToClass(studentId, classId) {
            Swal.fire({
                title: 'Re-enroll to Class?',
                text: 'Student will be re-enrolled in this class.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, enroll!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Implementation for enrolling
                    toastr.info('Feature coming soon!');
                }
            });
        }

        function deleteStudent(studentId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This student will be permanently deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("admin.students.index") }}';
                }
            });
        }
    </script>
@endsection
