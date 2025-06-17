<table align='center' bgcolor='#EFEEEA' border='0' cellpadding='0' cellspacing='0' height='100%' width='100%'>
    <tbody>
        <tr>
            <td align='center' valign='top' style='padding-bottom:60px'>
                <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>
                    <tbody>
                        <tr>
                            <td align='center' valign='top'>
                                <table align='center' bgcolor='#FFFFFF' border='0' cellpadding='0' cellspacing='0'
                                    style='background-color:#ffffff;     border-bottom: 5px solid #3c7d8c; color: #656565; max-width:650px; border-top: 5px solid #3c7d8c;  border-radius: 10px; padding: 30px; font-size: 14px;     font-family: system-ui; margin-top: 30px;'
                                    width='100%'>
                                    <tbody>
                                        <tr>
                                            <td align='center' valign='top'>
                                                <div style='display: flex; flex-wrap: wrap;'>
                                                    <div style='    width: 65%;  text-align: left;'>
                                                        <img src="'https://staging.ticketsdirector.com/assets/img/logo-black.png'"
                                                            style='width: 150px;'>
                                                    </div>
                                                    <div
                                                        style='    text-align: right; width: 35%; font-size: 13px; line-height: 24px;'>
                                                        <strong>Invoice ID: {{$payment->payment_id}}</strong><br>
                                                        <strong>Booking ID: {{$booking->booking_code}}</strong><br>
                                                        <span>Date: {{$booking->created_at}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign='top' bgcolor='#FFFFFF'>
                                                <h1 style='color: #3c7d8c;
                                                        font-size: 22px;
                                                        font-style: normal;
                                                        line-height: 35px;
                                                        letter-spacing: normal;
                                                        margin: 13px 0px;
                                                        padding: 10px 0px 0px;
                                                        text-align: center;
                                                        border-top: 1px solid;'>Booking Confirmation</h1>
                                                <p style="margin: 25px 0 0;
                                                  font-weight: 700;">Hello {{$booking_user->first_name}},</p>
                                                <p style=' margin: 5px 0px 20px 0px;'>
                                                    Your tickets reservation has been successfully made. Please find the
                                                    details of your booking below.

                                                </p>


                                            </td>
                                        </tr>

                                        <tr>
                                            <td valign='top'>
                                                <div
                                                    style='display: flex; flex-wrap: wrap; line-height: 24px; margin-top:10px'>
                                                    <div
                                                        style=' text-align: left;  width:45%; font-size: 13px;  padding: 0px 30px 0px 0px;'>
                                                        <p
                                                            style='    display: table; margin: 0px 0px 10px 0px; font-size: 13px;font-weight: bold;  border-bottom: 1px solid #c1c1bf;'>
                                                            Billing Details: </p>
                                                        <span>Name: {{$booking_user->first_name}}
                                                            {{$booking_user->last_name}}</span> <br>
                                                        <span>E-mail: {{$booking_user->email}}</span> <br>
                                                        <span>Telephone: {{$booking_user->phone_no}}</span> <br>
                                                        <span>NIC: {{$booking_user->nic}}</span> <br>
                                                    </div>

                                                    <div style=' text-align: left;  width:45%; font-size: 13px; '>
                                                        <p
                                                            style='    display: table; margin: 0px 0px 10px 0px; font-size: 13px;font-weight: bold;  border-bottom: 1px solid #c1c1bf;'>
                                                            Event Details: </p>
                                                        <span>Event: <b
                                                                style="color: #3c7d8c;">{{$event_details->title}}</b></span>
                                                        <br>
                                                        <span>Date & Time: <b
                                                                style="color: #3c7d8c;"><?php echo (new DateTime($event_details->event_start_time))->format("d, F Y g:i A"); ?></b></span>
                                                        <br>
                                                        <span>Venue: {{$event_details->venue}}</span> <br>

                                                    </div>


                                                </div>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td align='center' valign='middle' style='padding: 20px 0px;'>
                                                <p
                                                    style='text-align: left; font-size: 13px;  font-weight: 600; margin: 0px 0px 5px 0px;'>
                                                    Tickets Details</p>
                                                <table border='1'
                                                    style='    color: #656565;    border-color: #dcdcdc;  border-collapse: collapse; text-align: left;   width: 100%;  font-size: 12px;'>
                                                    <tr style='background: #f4f5f7'>
                                                        <th style='text-align: left;padding:8px;'>Category</th>
                                                        <th style='text-align: center;padding:8px;'>Price (LKR)</th>
                                                        <th style='padding:8px; text-align: center;'>No. of Tickets</th>
                                                        <th style='text-align: right; padding:8px;'>Amount (LKR)</th>
                                                    </tr>

                                                    @foreach($ticketsDetails as $list)
                                                    <tr>
                                                        <td style='padding:8px; '> {{$list->category}}</td>

                                                        <td style='padding:8px; text-align: center;'>
                                                            {{number_format($list->amount)}}
                                                        </td>
                                                        <td style='text-align: center; padding:8px; '>
                                                            {{$list->tickets_count}}</td>

                                                        <td style='text-align: right; padding:8px;'>
                                                            {{number_format($list->tickets_count * $list->amount, 2)}}
                                                        </td>
                                                    </tr>

                                                    @endforeach

                                                    <tr style=" height: 30px; border-left: 0px solid white;
                                                    border-right: 0px solid white;">
                                                        <td colspan="4"></td>
                                                    </tr>





                                                    <tr style='font-size: 15px;   font-weight: bold;'>
                                                        <td style='padding:8px; ' colspan='3'>Total Amount (LKR)</td>
                                                        <td style='padding:8px; text-align: right'>
                                                            {{number_format($payment->amount, 2)}}</td>
                                                    </tr>

                                                </table>

                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <p><br><small>* For any questions related to the booking, you can
                                                        contact Tickets Director directly at: +94 777 405 049</small>
                                                </p>


                                                <br>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align='center' valign='top'
                                                style='border-top:2px solid #efeeea;color:#6a655f; font-size:12px;font-weight:400;line-height:24px;padding-top:20px;text-align:center'>
                                                <p
                                                    style='color:#6a655f;font-size:12px;font-weight:400;line-height:24px;padding:0 20px;margin:0;text-align:center'>
                                                    Note: This is auto-generated document & the emails replied to this
                                                    will not be responded <br><strong style='color: #3c7d8c;'>Thank you
                                                        for your Business!</strong><br>Tickets Director</p>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td align="center">
                                <table style="     background-color: #d4f7ff;
    color: #5d5d5d;
    max-width: 650px;
    border-radius: 10px;
    padding: 30px;
    font-size: 15px;
    font-family: system-ui;
    margin-top: 30px;
    font-weight: bold;">
                                    <tr>
                                        <td>
                                        "Your e-tickets are attached to this email. Please present the QR code at the event entrance for entry. Note that the same QR code will be used for all the tickets you purchase."
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
