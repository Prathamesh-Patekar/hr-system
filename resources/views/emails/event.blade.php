<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Event Invitation</title>

    <style type="text/css">
        /* Take care of image borders and formatting, client hacks */
        img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
        a img { border: none; }
        table { border-collapse: collapse !important;}
        #outlook a { padding:0; }
        .ReadMsgBody { width: 100%; }
        .ExternalClass { width: 100%; }
        .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
        table td { border-collapse: collapse; }
        .ExternalClass * { line-height: 115%; }
        .container-for-gmail-android { min-width: 600px; }


        /* General styling */
        * {
            font-family: 'Open Sans',Helvetica, Arial, sans-serif;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            margin: 0 !important;
            height: 100%;
            color: #7f828f;
        }

        td {
            font-family: 'Open Sans',Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #7f828f;
            text-align: center;
            line-height: 24px;
        }

        a {
            color: #7f828f;
            text-decoration: none !important;
        }

        .pull-left {
            text-align: left;
        }

        .pull-right {
            text-align: right;
        }

        .header-lg,
        .header-md,
        .header-sm {
            font-size: 36px;
            font-weight: 700;
            line-height: normal;
            padding: 25px 0 0;
            color: #4d4d4d;
        }

        .header-md {
            font-size: 24px;
        }

        .header-sm {
            color: #2a2f43;
            padding: 5px 0;
            font-size: 22px;
            line-height: 24px;
        }

        .price {
            color: #f5393d;
            font: 700 32px/36px 'Open Sans';
            padding: 23px 0 13px;
        }

        .content-padding {
            padding: 20px 0 30px;
        }
        .content-top {
            background: #67d3e0 url('{{env('APP_URL')}}/emails/top-bg.jpg') center center no-repeat;
            -webkit-border-radius: 3px 3px 0 0;
            border-radius: 3px 3px 0 0;
            color: #fff;
            padding: 65px 0 90px;
        }

        .content-top .btn a {
            background-color: #f5393d;
            border-bottom: 3px solid #e43539;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            color: #fff;
            display: inline-block;
            font:700 18px/20px 'Lato';
            margin-top: 50px;
            padding: 20px 45px;
            text-align: center;
            text-transform: uppercase;
        }

        .content-top .btn a:hover {
            background-color: #e43539;
        }

        .content-top .free-text,
        .content-top .header-lg {
            color: #fff;
            font-family: 'Open Sans';
        }

        .mobile-header-padding-right {
            width: 290px;
            text-align: right;
            padding-left: 10px;
        }

        .mobile-header-padding-left {
            width: 310px;
            text-align: left;
            padding-left: 10px;
            padding-bottom: 8px;
        }

        .free-text {
            width: 100% !important;
            padding: 10px 60px 0px;
        }

        .block-rounded {
            border-radius: 5px;
            box-shadow: 1px 2px 0 rgba(0,0,0,0.15);
            vertical-align: top;
        }

        .button {
            padding: 30px 0;
        }

        .info-block {
            padding: 0 30px;
            width: 310px;
        }

        .block-rounded {
            background: #ffffff;
            width: 310px;
        }

        .info-img {
            width: 310px;
            border-radius: 5px 5px 0 0;
        }

        .force-width-gmail {
            min-width:600px;
            height: 0px !important;
            line-height: 1px !important;
            font-size: 1px !important;
        }

        .button-width {
            -webkit-border-radius: 3px;
            border-radius: 3px;
            font: 700 0/57px 'Lato';
            display: block;
            height: 57px;
            width: 57px;
            background: #67d3e0 url('{{env('APP_URL')}}/emails/btn-bg.png') center center no-repeat;
            color: #67d3e0;
            margin: -29px auto 0;
            z-index: 15;
            position: relative;
        }
        .button-width:hover {background-color: #5bc7d4}

        .footer {
            background-color: #2a2f43;
            border-radius: 0 0 3px 3px;
            height: 100px;
        }
        .footer-content {
            padding: 45px 0;
            line-height:29px;
            color: #fff;
        }

    </style>

    <style type="text/css" media="screen">
        @import url(https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic);
        @import url(http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700);
    </style>

    <style type="text/css" media="screen">
        @media screen {
            /* Thanks Outlook 2013! http://goo.gl/XLxpyl */
            * {
                font-family: 'Lato', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
            }
        }
    </style>

    <style type="text/css" media="only screen and (max-width: 480px)">
        /* Mobile styles */
        @media only screen and (max-width: 480px) {

            table[class*="container-for-gmail-android"] {
                min-width: 290px !important;
                width: 100% !important;
            }

            table[class="w320"] {
                width: 320px !important;
            }

            img[class="force-width-gmail"] {
                display: none !important;
                width: 0 !important;
                height: 0 !important;
            }

            a[class="button-width"],
            a[class="button-mobile"] {
                width: 248px !important;
            }

            td[class*="mobile-header-padding-left"] {
                width: 160px !important;
                padding-left: 0 !important;
            }

            td[class*="mobile-header-padding-right"] {
                width: 160px !important;
                padding-right: 0 !important;
            }

            td[class="header-lg"] {
                font-size: 24px !important;
                padding-bottom: 5px !important;
            }

            td[class="header-md"] {
                font-size: 18px !important;
                padding-bottom: 5px !important;
            }

            td[class="content-padding"] {
                padding: 5px 0 30px !important;
            }

            td[class="button"] {
                padding: 5px !important;
            }

            td[class*="free-text"] {
                padding: 10px 18px 30px !important;
            }

            td[class="info-block"] {
                display: block !important;
                width: 280px !important;
                padding-bottom: 40px !important;
            }

            td[class="info-img"],
            img[class="info-img"] {
                width: 278px !important;
            }
        }
    </style>
</head>

<body bgcolor="#f7f7f7">
<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
    <tr>
        <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-top">
            <center>
                <table cellspacing="0" cellpadding="0" width="600" class="w320">
                    <tr>
                        <td class="header-lg">
                            {{$data['coordinator']}} has invited you for an event
                        </td>
                    </tr>
                    <tr>
                        <td class="free-text">
                            Dear {{$data['attendee_name']}} , {{$data['coordinator']}} has invited you to {{$data['name']}} on {{$data['date']}}.
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
    <tr>
        <td align="center" valign="top" width="100%" class="footer">
            <center>
                <table cellspacing="0" cellpadding="0" width="600" class="w320">
                    <tr>
                        <td class="footer-content">
                            <img src="{{env('APP_URL')}}/emails/footer-1.png" alt="" style="vertical-align: middle;"/>Techsevin Solution LLP, C-7, Sector 3, Noida 201301<img src="{{env('APP_URL')}}/emails/footer-2.png" alt="" style="vertical-align: middle;"/>+91-120-428-2484
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
</body>
</html>
