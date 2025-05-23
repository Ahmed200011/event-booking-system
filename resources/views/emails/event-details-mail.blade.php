{{-- <x-mail::message>
# Introduction --}}

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">

  <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px;">
    <tr>
      <td style="padding: 20px; text-align: center; background-color: #007BFF; color: white; border-top-left-radius: 8px; border-top-right-radius: 8px;">
        <h2>Booking Confirmation</h2>
      </td>
    </tr>

    <tr>
      <td style="padding: 20px;">
        <p>Hi {{ $user->name }},</p>
        <p>Thank you for booking with <strong>Event Booking System</strong>. Your reservation is confirmed!</p>

        <h3>Event Details:</h3>
        <p><strong>Event Name:</strong> {{ $event->event_name }}</p>
        <p><strong>Description:</strong> {{ $event->description }}</p>
        <p><strong>Date:</strong> {{ $event->date }}</p>
        <p><strong>Location:</strong> {{ $event->location }}</p>
        <p><strong>Price:</strong> ${{ $event->price }}</p>

        <p>If you have any questions, feel free to contact us.</p>
      </td>
    </tr>

    <tr>
      <td style="padding: 20px; text-align: center; background-color: #f1f1f1; font-size: 14px; color: #666; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
        &copy; 2025 Event Booking System. All rights reserved.
      </td>
    </tr>
  </table>

</body>
</html>


{{-- <x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}
