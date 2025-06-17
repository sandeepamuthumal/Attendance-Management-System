<div>
    {{-- ticket selection modal --}}
    <div class="modal fade bd-example-modal-lg" id="booking-modal" role="dialog" aria-hidden="true"
        data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Booking Details</h3>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-input">
                    @if ($booking)
                        <table class="product-page-width mb-3" id="booking-table" style="width: 100%">
                            <tr>
                                <td>Booking Code : </td>
                                <th>{{ $booking->booking_code }}</th>
                            </tr>
                            <tr>
                                <td>Customer Name : </td>
                                <th>{{ $booking_customer }}</th>
                            </tr>
                            <tr>
                                <td>Booking Date : </td>
                                <th>{{ \Carbon\Carbon::parse($booking->created_at)->format('j, F Y, g:i A') }}</th>
                            </tr>
                            <tr>
                                <td>Total Amount : </td>
                                <th>{{ 'LKR ' . number_format($booking->total_price, 2) }}</th>
                            </tr>
                            <tr>
                                <td>Total Tickets : </td>
                                <th>{{ $booking->total_tickets }} <span
                                        class="text-danger">{{ ' (' . $booking_scanned . ')' }}</span></th>
                            </tr>
                            <tr>
                                <td>Payment Status : </td>
                                <th>
                                    @switch($booking->payment_status)
                                        @case('cancelled')
                                            <span class="badge bg-danger">CANCELLED</span>
                                        @break

                                        @case('success')
                                            <span class="badge bg-success">SUCCESS</span>
                                        @break

                                        @case('pending')
                                            <span class="badge bg-warning">PENDING</span>
                                        @break

                                        @default
                                    @endswitch
                                </th>
                            </tr>
                        </table>

                        <div class="col-12 mb-3">
                            @if (count($booked_tickets) > 0)
                                <label class="form-label fw-bold text-black" for="">Select Ticket : </label>
                                <select class="form-select" id="ticket" wire:model="selected_ticket">
                                    @foreach ($booked_tickets as $ticket)
                                        <option value="{{ $ticket->id }}">{{ $ticket->category }}</option>
                                    @endforeach
                                </select>
                            @else
                                <span class="text-danger">All Tickets are scanned!</span>
                            @endif
                        </div>

                        <div class="col-12 mb-3">
                            @if (count($guest_users) > 0)
                                <label class="form-label fw-bold text-black" for="">Select User : </label>
                                <select class="form-select" id="guest_user" wire:model="selected_guest_user">
                                    @foreach ($guest_users as $user)
                                        <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name . ' - ' . $user->nic . ' (' . $user->token . ')' }}</option>
                                    @endforeach
                                </select>
                            @else
                                <span class="text-danger">All Users are scanned!</span>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if (count($booked_tickets) > 0)
                        <button type="button" class="btn btn-primary float-end btn-shadow" id="scan-btn"
                            onclick="scanTicket()">
                            SCAN TICKET
                        </button>
                    @else
                        <button type="button" class="btn btn-primary float-end btn-shadow" data-bs-dismiss="modal"
                            aria-label="Close">Close</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ticket selection modal --}}
    <div class="modal fade bd-example-modal-lg" id="invitation-modal" role="dialog" aria-hidden="true"
        data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Invitation</h3>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-input">
                    @if ($invitation)
                        <table class="product-page-width mb-3" id="invitation-table" style="width: 100%">
                            <tr>
                                <td>Inviter : </td>
                                <th>{{ $invitation->first_name . ' ' . $invitation->last_name }}</th>
                            </tr>
                            <tr>
                                <td>Ticket : </td>
                                <th>{{ $invitation->category }}</th>
                            </tr>
                            <tr>
                                <td>Invited Date : </td>
                                <th>{{ \Carbon\Carbon::parse($invitation->created_at)->format('j, F Y, g:i A') }}</th>
                            </tr>
                        </table>

                        <div class="col-12 mb-3">
                            @if ($invitation->is_scanned == 1)
                                <span class="text-danger">Ticket is already scanned!</span>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if ($invitation)
                        @if ($invitation->is_scanned == 0)
                            <button type="button" class="btn btn-primary float-end btn-shadow" id="invitation-scan-btn"
                                onclick="scanInvitationTicket()">
                                SCAN TICKET
                            </button>
                        @else
                            <button type="button" class="btn btn-primary float-end btn-shadow" data-bs-dismiss="modal"
                                aria-label="Close">Close</button>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- ticket scanner --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <label class="form-label col-lg-3 col-sm-12" for="event">Select Event : </label>
                    <div class="col-lg-9 col-sm-12 event-selection" wire:ignore>
                        <select class="single-select form-select" id="event" wire:change.live="loadTickets"
                            onchange="ChangeEvent()">
                            <option selected="" value="">Choose...</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" {{ $event->id == $event_id ? 'selected' : '' }}>
                                    {{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body" wire:ignore>
                    <div id="scan-section">
                        {{-- qr scan  --}}
                        <input name="output_value" id="output_value" type="text" class="form-control" hidden>
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
            <div class="card mb-4">
                <div class="card-header text-center">
                    <h3 class="card-title text-center ">Tickets Scanned Summary</h3>
                </div>
                <div class="card-body">
                    <ol class="list-group list-group-numbered">
                        @foreach ($event_tickets as $ticket)
                            <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                                <div>{{ $ticket->category }}</div><span
                                    class="badge bg-danger rounded-pill p-2">{{ $ticket->scanned_count }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <ol class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                            <h2>Total Tickets</h2><span
                                class="badge bg-primary rounded-pill p-2">{{ $total }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                            <h2>Sold Tickets</h2><span
                                class="badge bg-warning text-white rounded-pill p-2">{{ $sold }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                            <h2>Gift Tickets</h2><span
                                class="badge bg-success text-white rounded-pill p-2">{{ $gift }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                            <h2>Available Tickets</h2><span
                                class="badge bg-info text-white rounded-pill p-2">{{ $available }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                            <h2>Scanned Tickets</h2><span
                                class="badge bg-danger text-white rounded-pill p-2">{{ $scanned }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                            <h2>Invitation Scanned </h2><span
                                class="badge bg-danger text-white rounded-pill p-2">{{ $invitation_scanned }}</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            $wire.on('openBookingModal', () => {
                $('#booking-modal').modal('show');
            });

            $wire.on('openInvitationModal', () => {
                $('#invitation-modal').modal('show');
            });

            $wire.on('showError', (message) => {
                Swal.fire({
                    icon: "error",
                    title: message,
                });
            });

            $wire.on('showSuccess', (message) => {
                $('#booking-modal').modal('hide');

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
        function ChangeEvent() {
            let event_id = $("#event").val();
            @this.call('changeEvent', event_id);
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
                showItem();
            }
        }

        function showItem() {
            let outputValue = $('#output_value').val();
            let event = $('#event').val();

            console.log("Event " + event);

            if (event == null || event == undefined || event == "") {
                Swal.fire({
                    icon: "warning",
                    title: "Please select an event!",
                });

                return;
            }

            if (outputValue === '' || outputValue === null || outputValue === undefined) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                });
            } else {
                console.log(outputValue);
                @this.call('loadBooking', outputValue);

            }
        }

        function scanTicket() {
            $("#scan-btn").html('Please Wait...');
            $("#scan-btn").attr("disabled", true);
            @this.call('scanTicket');
        }

        function scanInvitationTicket() {
            $("#invitation-scan-btn").html('Please Wait...');
            $("#invitation-scan-btn").attr("disabled", true);
            @this.call('scanInvitationTicket');
        }
    </script>
</div>
