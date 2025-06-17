<?php
// $code = '';
?>
<table align='center' bgcolor='#EFEEEA' border='0' cellpadding='0' cellspacing='0' height='100%' width='100%'>
    <tbody>
        <tr>
            <td align='center' valign='top' style='padding-bottom:60px'>
                <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>
                    <tbody>
                        <tr>
                            <td align='center' valign='top'>
                                <table align='center' bgcolor='#FFFFFF' border='0' cellpadding='0' cellspacing='0'
                                    style='background-color:#ffffff; color: #656565; max-width:640px; font-size: 15px; font-family: Helvetica Neue,Helvetica,Arial,Verdana,sans-serif; margin-top: 30px;'
                                    width='100%'>
                                    <tbody>
                                        <tr>
                                            <td align='center' valign='top' style='padding: 30px 0px 20px 0px;'>
                                                <a href='#' style='text-decoration:none' target='_blank'>
                                                    <img src="{{ asset('https://staging.ticketsdirector.com/assets/img/logo-black.png') }}"
                                                        style='width: 200px;'>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign='top' bgcolor='#FFFFFF'
                                                style='padding-right:40px;padding-bottom:10px;padding-left:40px'>

                                                <p style="text-align: center;">Hello,</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align='center' valign='middle'
                                                style='padding-right:40px;padding-bottom:40px;padding-left:40px'>
                                                <p>There was a request to reset your Password. If you did not make this request, just ignore this email and check your account. Otherwise, please use this code to reset your password.</p>
                                                <p style="font-size:13px;">Reset Code : <strong>{{ $code }}</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align='center' valign='top'
                                                style='border-top:2px solid #efeeea;color:#008844; font-size:12px;font-weight:400;line-height:24px;padding-top:20px;padding-bottom:20px;text-align:center'>
                                                <p
                                                    style='color:#6a655f;font-size:12px;font-weight:400;line-height:24px;padding:0 20px;margin:0;text-align:center'>
                                                    © Tickets Director, All Rights Reserved.</p>

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
