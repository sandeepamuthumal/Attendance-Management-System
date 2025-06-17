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

                                                <p>Hi {{ $inviter }},</p>

                                                <p style='margin: 10px auto;font-size: 14px;'>
                                                    We are thrilled to invite you to {{ $event_title }}, hosted by
                                                    {{ $organizer }}. Join us for an exciting and memorable
                                                    experience!
                                                </p>

                                                <p style='margin: 5px auto;font-size: 14px;'>
                                                    Event Details:
                                                </p>
                                                <ul>
                                                    <li><strong>Event:</strong> {{ $event_title }}</li>
                                                    <li><strong>Date:</strong> {{ $event_date }}</li>
                                                    <li><strong>Time:</strong> {{ $event_time }}</li>
                                                    <li><strong>Location:</strong> {{ $location }}</li>
                                                </ul>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td align='center' valign='middle'
                                                style='padding-right:40px;padding-bottom:20px;padding-left:40px'>

                                                <p>
                                                    <a href="{{ url('download/invitation/Qr', $invitation_id) }}"
                                                        style='width:  180px;
                                                       background-color: #134D80;
                                                       padding: 11px 20px;
                                                       display: block;
                                                       border-radius: .25rem;
                                                       font-size: 14px;

                                                       color: white;
                                                       cursor: pointer;
                                                       text-decoration: none;'>
                                                        Download Your QR Code
                                                    </a>
                                                </p>
                                                <div class="page-content page-container" id="page-content">
                                                    <div class="padding">
                                                        <div class="row container d-flex justify-content-center">
                                                            <div class="template-demo"
                                                                style="display: flex;padding: 0 200px;">
                                                                <a href=""
                                                                    target="_blank" style="text-decoration: none;">
                                                                    <div style="width: 130px;">
                                                                        <img src="https://manage.ticketsdirector.com/email/appstore.png"
                                                                            alt="App Store"
                                                                            style="vertical-align: middle; width: 130px;height:40px; margin-right: 10px;">
                                                                    </div>
                                                                </a>
                                                                <a href=""
                                                                    target="_blank" style="text-decoration: none;">
                                                                    <div style="width: 130px;margin-left:5px">
                                                                        <img src="https://manage.ticketsdirector.com/email/googleplay.png"
                                                                            alt="App Store"
                                                                            style="vertical-align: middle; width: 130px;height:40px; margin-right: 10px;">
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p style='margin:10px auto;font-size: 14px;'>If you have any questions, feel free to contact us at {{ $organizer_contact_no }}. We look forward to seeing you there!</p>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding-right:40px;padding-bottom:20px;padding-left:40px'> <p style='margin:10px auto;font-size: 14px;'>Best regards</p></td>
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
