<div>
    {{-- ticket selection modal --}}
    <div class="modal fade bd-example-modal-lg" id="student-modal" role="dialog" aria-hidden="true"
        data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Student Details</h3>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-input">
                    @if ($student)
                        <table class="product-page-width mb-3" id="student-table" style="width: 100%">
                            <tr>
                                <td>Student ID : </td>
                                <th>{{ $student->student_id }}</th>
                            </tr>
                            <tr>
                                <td>Student Name : </td>
                                <th>{{ $student->first_name . ' ' . $student->last_name }}</th>
                            </tr>
                            <tr>
                                <td>Email : </td>
                                <th>{{ $student->email }}</th>
                            </tr>
                            <tr>
                                <td>Enrolled Date : </td>
                                <th>{{ \Carbon\Carbon::parse($enrollment->created_at)->format('M d, Y') }}</th>
                            </tr>
                        </table>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary float-end btn-shadow" id="scan-btn"
                        onclick="markAttendance()">
                        Mark Attendance
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- ticket scanner --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body" wire:ignore>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-sm-12">
                            <label class="form-label col-lg-3 col-sm-12" for="class_id">Select Class : </label>
                            <select class="single-select form-select" id="class_id" wire:change.live="loadStats"
                                onchange="ChangeClass()">
                                <option selected="" value="" hidden>Choose...</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ $class->id == $selected_class ? 'selected' : '' }}>
                                        {{ $class->class_name . ' (' . $class->subject->subject . '-' . $class->grade->grade . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <label class="form-label col-lg-3 col-sm-12" for="event">Select Date : </label>
                            <input type="date" wire:model="selected_date" value="{{ date('Y-m-d') }}"
                                class="form-control">
                        </div>
                    </div>
                    <div id="scan-section">
                        {{-- qr scan  --}}
                        <div class="row mb-2">
                            <div class="col-12">
                                {{-- add input group --}}
                                <div class="input-group">
                                    <input type="text" class="form-control" id="output_value"
                                        placeholder="Scan QR Code or Enter Student ID" wire:model="output_value">
                                    <button class="btn btn-primary" type="button" id="scan-btn"
                                        onclick="showStudent()">SCAN</button>
                                </div>
                            </div>
                        </div>
                        <section class="container" id="scan_page">
                            <center>
                                <div id="qr-reader" class="qr_card_res mb-3 scanner_qr"
                                    style="width: auto; max-width:700px; height: auto;  border-radius: 5px; box-shadow: 3px 12px 22px 0px #9BA8FF4D;">
                                </div>
                            </center>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <ol class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                            <h2>Total Students</h2><span
                                class="badge bg-primary rounded-pill p-2">{{ $totalStudents }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                            <h2>Present Students</h2><span
                                class="badge bg-warning text-white rounded-pill p-2">{{ $presentStudents }}</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            $wire.on('openStudentModal', () => {
                $('#student-modal').modal('show');
            });

            $wire.on('showError', (message) => {
                Swal.fire({
                    icon: "error",
                    title: message,
                });
            });

            $wire.on('showSuccess', (message) => {
                $('#student-modal').modal('hide');

                Swal.fire({
                    icon: "success",
                    title: message,
                });
            });

            $wire.on('showInvSuccess', (message) => {
                $('#invitation-modal').modal('hide');

                Swal.fire({
                    icon: "success",
                    title: message,
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
            $("#scan-btn").html('Please Wait...');
            $("#scan-btn").attr("disabled", true);
            @this.call('markAttendance');
        }
    </script>
</div>
