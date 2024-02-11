{{-- Click the following link to reset your password: {{ $resetLink }} --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <b>
        <p>Hallo {{ $email }},</p>
    </b>

    <p>Kami menerima permintaan untuk mengatur ulang kata sandi Anda. Klik tautan di bawah untuk mengatur ulang :</p>

    <a href="{{ $resetLink }}">{{ $resetLink }}</a>

    <p>Jika Anda tidak meminta pengaturan ulang kata sandi, Anda dapat mengabaikan email ini dengan aman.</p>

    <p>Terima kasih!</p>
</body>
</html>