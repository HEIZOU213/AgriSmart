<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Kode Verifikasi AgriSmart</title>
    <style type="text/css">
        /* Reset Styles */
        body { margin: 0; padding: 0; width: 100% !important; background-color: #ffffff; color: #334155; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; }
        a { color: #16a34a; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body style="background-color: #ffffff; margin: 0; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">

        <div style="padding-bottom: 30px; border-bottom: 1px solid #f1f5f9; margin-bottom: 30px;">
            <img src="https://agrismart.my.id/images/nav-logo.png" alt="AgriSmart" height="40" style="display: block; border: 0;" />
        </div>

        <div style="padding-bottom: 20px;">
            <p style="font-size: 16px; margin-top: 0; color: #0f172a;">
                Halo <strong>Partner AgriSmart</strong>,
            </p>
            
            <p style="font-size: 15px; color: #475569; margin-bottom: 20px;">
                Berikut adalah kode verifikasi Anda untuk masuk ke akun AgriSmart:
            </p>

            <h1 style="font-size: 48px; font-weight: 800; color: #16a34a; margin: 20px 0; letter-spacing: 2px; line-height: 1;">
                {{ $otp }}
            </h1>

            <p style="font-size: 14px; color: #64748b; margin-top: 30px;">
                Kode ini valid hingga <strong>{{ \Carbon\Carbon::now()->addMinutes(2)->format('d F Y, H:i') }} WIB</strong> dan hanya bisa digunakan sekali.
            </p>

            <p style="font-size: 14px; color: #64748b; margin-top: 10px;">
                Jika Anda tidak merasa melakukan permintaan login, mohon abaikan email ini.
            </p>
        </div>

        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #f1f5f9; font-size: 13px; color: #94a3b8;">
            <p style="margin: 0;">Best Regards,</p>
            <p style="margin: 5px 0 0 0; font-weight: bold; color: #475569;">AgriSmart Team</p>
        </div>

    </div>

</body>
</html>