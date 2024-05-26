<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JobNotificationEmail</title>
</head>
<body>
    <h1>Hello! {{ $mailData['employer']->name}}</h1>
    <p>Your Job Posting Status has been change By Admin against </p>
    <h3>Job Title: {{$mailData['job']->title}}</h3>
    <p>Kindly visit website to check your job status </p>
    
</body>
</html>