<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Contact Submission</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2 style="margin-bottom: 16px;">New contact form submission</h2>

    <p><strong>Name:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Phone:</strong> {{ $contact->phone ?: 'Not provided' }}</p>
    <p><strong>Message:</strong></p>
    <div style="padding: 12px; background: #f3f4f6; border-radius: 6px; white-space: pre-line;">{{ $contact->message }}</div>

    <p style="margin-top: 20px; color: #6b7280;">
        This notification was sent from the website contact form.
    </p>
</body>
</html>
