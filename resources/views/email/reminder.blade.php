@php
    $logo = 'login_logo.png';
@endphp

<style>
    .mdi-36px {
        font-size: 39px;
        margin-right: 10px;
    }


    .container {

        margin-top: 50px;
    }
</style>
<table align='center' bgcolor='#EFEEEA' border='0' cellpadding='0' cellspacing='0' height='100%' width='100%'
    style="background-color: #ffffff">
    <tbody>
        <tr>
            <td align='center' valign='top' style='padding-bottom:60px'>
                <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>
                    <tbody>
                        <tr>
                            <td align='center' valign='top'>
                                <table align='center' bgcolor='#FFFFFF' border='0' cellpadding='0' cellspacing='0'
                                    style=' border-top: 5px solid #134D80;border-bottom: 5px solid #134D80; background-color:#ffffff; color: #656565; max-width:700px; font-size: 15px;  font-family: system-ui;    border-radius: 10px; margin-top: 0px;'
                                    width='100%'>
                                    <tbody>
                                        <tr>
                                            <td align='center' valign='top' style='padding: 30px 0px 20px 0px;'>
                                                <a href='#' style='text-decoration:none' target='_blank'>
                                                    <img src="https://staging.ticketsdirector.com/assets/img/logo-black.png"
                                                        style='width: 150px;'>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign='top' bgcolor='#FFFFFF'
                                                style='padding-right:40px;padding-bottom:20px;padding-left:40px'>

                                                <p>Dear {{ $customer }},</p>

                                                <p style='margin: 10px auto;font-size: 14px;'>
                                                    We hope this message finds you well! This is a friendly reminder
                                                    that you have a ticket for {{ $event_title }} happening tomorrow,
                                                    {{ $event_date }}, at {{ $event_time }}. We’re excited to have
                                                    you join us for an unforgettable experience!
                                                </p>

                                                <p style='margin: 5px auto;font-size: 14px;'>
                                                    <strong>Event Details:</strong>
                                                </p>
                                                <ul>
                                                    <li><strong>Event:</strong> {{ $event_title }}</li>
                                                    <li><strong>Date:</strong> {{ $event_date }}</li>
                                                    <li><strong>Time:</strong> {{ $event_time }}</li>
                                                    <li><strong>Location:</strong> {{ $location }}</li>
                                                </ul>

                                                @if ($remarks)
                                                    <p style='margin: 10px auto;font-size: 14px;'>
                                                        <strong>Remarks - </strong> {{ $remarks }}
                                                    </p>
                                                @endif

                                                <p style='margin: 10px auto;font-size: 14px;'>
                                                    Please remember to bring your QR code for entry. If you have any
                                                    questions or need assistance, feel free to reach out to us at
                                                    <a href="http://wa.me/+94777483140">+94 (77) 748 3140</a> through whatsapp.
                                                </p>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td style='padding-right:40px;padding-bottom:20px;padding-left:40px'>
                                                <p style='margin:10px auto;font-size: 14px;'>
                                                    Thank you for choosing <a href="https://ticketsdirector.com/">ticketsdirector.com</a>
                                                </p>
                                                <p style='margin:10px auto;font-size: 14px;'>
                                                    We look forward to seeing you there!
                                                </p>
                                                <p style='margin:10px auto;font-size: 14px;'>Best regards
                                                    <br>
                                                    Team tickets director.
                                                </p>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
