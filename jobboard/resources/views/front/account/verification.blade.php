<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(session()->get('success'))
  <div class="alert alert-success" role="alert">
    <strong>Success: </strong>{{session()->get('success')}}
  </div>
  @endif
  @if(session()->get('error'))
  <div class="alert alert-danger" role="alert">
    <strong>Error: </strong>{{session()->get('error')}}
  </div>
  @endif
    Send Verification Mail to Verify Your Email
    <a href="{{ route('verificationEmailMessage') }}">Send Mail</a>
</body>
</html>