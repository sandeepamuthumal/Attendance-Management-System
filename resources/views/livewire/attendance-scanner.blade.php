<div>
    {{-- Student Details Modal --}}
    <div class="modal fade bd-example-modal-lg" id="student-modal" role="dialog" aria-hidden="true"
        data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Student Details</h3>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-input">
                    @if ($student && $enrollment)
                        <div class="student-details-table">
                            <table class="table table-borderless mb-3" id="student-table">
                                <tbody>
                                    <tr>
                                        <td class="fw-medium">Student ID:</td>
                                        <td>{{ $student->student_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Student Name:</td>
                                        <td>{{ $student->first_name . ' ' . $student->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Email:</td>
                                        <td>{{ $student->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Enrolled Date:</td>
                                        <td>{{ \Carbon\Carbon::parse($enrollment->created_at)->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Attendance Date:</td>
                                        <td>{{ \Carbon\Carbon::parse($selected_date)->format('M d, Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="mark-attendance-btn" onclick="markAttendance()"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="markAttendance">Mark Attendance</span>
                        <span wire:loading wire:target="markAttendance">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Processing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="row">
        {{-- Scanner Section --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Attendance Scanner</h5>
                </div>
                <div class="card-body" wire:ignore>
                    {{-- Class and Date Selection --}}
                    <div class="row mb-4">
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="class_id">Select Class <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="class_id" wire:change.live="loadStats"
                                onchange="ChangeClass()" wire:model="selected_class">
                                <option value="" selected>Choose a class...</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ $class->id == $selected_class ? 'selected' : '' }}>
                                        {{ $class->class_name . ' (' . $class->subject->subject . ' - ' . $class->grade->grade . ')' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selected_class')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="selected_date">Select Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" wire:model.live="selected_date" class="form-control"
                                id="selected_date" max="{{ date('Y-m-d') }}">
                            @error('selected_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Scanner Section --}}
                    <div id="scan-section" class="scan-section">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label" for="output_value">Student ID Scanner</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="output_value"
                                        placeholder="Scan QR Code or Enter Student ID manually"
                                        wire:model="output_value" autocomplete="off">
                                    <button class="btn btn-primary" type="button" id="scan-btn"
                                        onclick="showStudent()" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="loadStudent">
                                            <i class="fas fa-qrcode me-1"></i> SCAN
                                        </span>
                                        <span wire:loading wire:target="loadStudent">
                                            <span class="spinner-border spinner-border-sm me-1"></span>
                                            Loading...
                                        </span>
                                    </button>
                                </div>
                                @error('output_value')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- QR Scanner Area --}}
                        <section class="container-fluid" id="scan_page">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-10 col-lg-8">
                                    <section class="container" id="scan_page">
                                        <center>
                                            <div id="qr-reader" class="qr_card_res mb-3 scanner_qr"
                                                style="width: auto; max-width:700px; height: auto;  border-radius: 5px; box-shadow: 3px 12px 22px 0px #9BA8FF4D;">
                                            </div>
                                        </center>
                                    </section>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Section --}}
        <div class="col-lg-4">
            <div class="card" wire:poll="loadStats">
                <div class="card-header">
                    <h5 class="card-title mb-0">Attendance Statistics</h5>
                    @if ($selected_date)
                        <small
                            class="text-muted">{{ \Carbon\Carbon::parse($selected_date)->format('F d, Y') }}</small>
                    @endif
                </div>
                <div class="card-body">
                    @if ($selected_class)
                        <div class="list-group list-group-flush">
                            <div
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <div>
                                    <h6 class="mb-0">Total Students</h6>
                                    <small class="text-muted">Enrolled in class</small>
                                </div>
                                <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">
                                    {{ $totalStudents }}
                                </span>
                            </div>

                            <div
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <div>
                                    <h6 class="mb-0">Present Today</h6>
                                    <small class="text-muted">Marked attendance</small>
                                </div>
                                <span class="badge bg-success rounded-pill fs-6 px-3 py-2">
                                    {{ $presentStudents }}
                                </span>
                            </div>

                            <div
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <div>
                                    <h6 class="mb-0">Absent</h6>
                                    <small class="text-muted">Not marked</small>
                                </div>
                                <span class="badge bg-warning rounded-pill fs-6 px-3 py-2">
                                    {{ $totalStudents - $presentStudents }}
                                </span>
                            </div>

                            @if ($totalStudents > 0)
                                <div class="list-group-item border-0 px-0 pt-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>Attendance Rate</span>
                                        <span>{{ $totalStudents > 0 ? round(($presentStudents / $totalStudents) * 100, 1) : 0 }}%</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $totalStudents > 0 ? ($presentStudents / $totalStudents) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-chart-bar fa-3x mb-3 opacity-50"></i>
                            <p class="mb-0">Select a class to view statistics</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            @if ($selected_class)
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm" onclick="clearScanner()">
                                <i class="fas fa-refresh me-1"></i> Clear Scanner
                            </button>
                            <button class="btn btn-outline-info btn-sm" onclick="focusInput()">
                                <i class="fas fa-keyboard me-1"></i> Focus Input
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Loading Overlay --}}
    {{-- <div wire:loading.flex
        class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
        style="background: rgba(0,0,0,0.5); z-index: 9999;">
        <div class="bg-white p-4 rounded shadow">
            <div class="text-center">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <div>Processing...</div>
            </div>
        </div>
    </div> --}}




    @script
        <script>
            // Livewire event listeners
            $wire.on('openStudentModal', () => {
                $('#student-modal').modal('show');
            });

            $wire.on('showError', (message) => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: message,
                    confirmButtonColor: '#d33'
                });
            });

            $wire.on('showSuccess', (message) => {
                $('#student-modal').modal('hide');

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: message,
                    confirmButtonColor: '#28a745',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Clear the input after successful attendance
                $('#output_value').val('');
                $wire.set('output_value', '');
            });

            $wire.on('showWarning', (message) => {
                Swal.fire({
                    icon: "warning",
                    title: "Warning",
                    text: message,
                    confirmButtonColor: '#ffc107'
                });
            });
        </script>
    @endscript

    <script>
        function ChangeClass() {
            let class_id = $("#class_id").val();
            @this.call('changeClass', class_id);
        }

        // QR code
        var flag = true;

        function onScanSuccess(decodedText, decodedResult) {
            if (flag) {
                console.log(`Code scanned = ${decodedText}`, decodedResult);
                flag = false;
                setTimeout(() => flag = true, 3000);
                document.cookie = "decodedText = " + decodedText;
                $('#output_value').val(decodedText);
                showStudent();
            }
        }

        function showStudent() {
            let outputValue = $('#output_value').val();
            let class_id = $('#class_id').val();

            console.log("class_id " + class_id);

            if (class_id == null || class_id == undefined || class_id == "") {
                Swal.fire({
                    icon: "warning",
                    title: "Please select an Class!",
                });

                return;
            }

            if (outputValue === '' || outputValue === null || outputValue === undefined) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please scan a QR code or enter a Student ID!",
                });
            } else {
                console.log(outputValue);
                @this.call('loadStudent', outputValue);
            }
        }

        function markAttendance() {

            $("#scan-btn").attr("disabled", true);
            @this.call('markAttendance');

            setTimeout(() => {
                button.prop('disabled', false);
            }, 3000);
        }

        // Utility functions
        function clearScanner() {
            $('#output_value').val('');
            $wire.set('output_value', '');
            focusInput();
        }

        function focusInput() {
            $('#output_value').focus();
        }

        // Bootstrap modal event handlers
        $('#student-modal').on('hidden.bs.modal', function() {
            clearScanner();
            focusInput();
        });
    </script>
</div>
