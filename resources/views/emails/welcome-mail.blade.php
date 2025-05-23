
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to Event Booking System</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      padding: 30px;
      color: #333;
    }
    .email-container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .header {
      text-align: center;
      border-bottom: 1px solid #ddd;
      padding-bottom: 20px;
    }
    .header h1 {
      color: #4CAF50;
    }
    .content {
      margin-top: 20px;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      background-color: #4CAF50;
      color: white;
      padding: 12px 24px;
      text-decoration: none;
      border-radius: 5px;
    }
    .footer {
      margin-top: 30px;
      font-size: 14px;
      color: #777;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h1>Welcome to Event Booking System!</h1>
    </div>
    <div class="content">
      <p>Hi [{{$user->name}}],</p>
      <p>Thank you for creating an account with <strong>Event Booking System</strong>. We're excited to have you on board!</p>
      <p>With your new account, you can:</p>
      <ul>
        <li>Browse and book upcoming events</li>
        <li>Manage your reservations</li>
        <li>Receive notifications and updates</li>
      </ul>
      <p>To get started, click the button below:</p>
      {{-- <a href="{{route('apilogin')}}" class="btn">Login to Your Account</a> --}}
    </div>
    <div class="footer">
      <p>If you did not create this account, please ignore this email.</p>
      <p>&copy; 2025 Event Booking System. All rights reserved.</p>
    </div>
  </div>
</body>
</html>

