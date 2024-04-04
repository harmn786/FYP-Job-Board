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
    <p>Here is a new applicant for the </p>
    <h3>Job Title: {{$mailData['job']->title}}</h3>
    <p>Applicant Detail:</p>
    <p>Applicant Name: {{$mailData['jobseeker']->name}}</p>
    <p>Applicant Email: {{$mailData['jobseeker']->email}}</p>
    <p>Applicant CV/Resume:<a href="{{ asset('storage/' .$mailData['jobseeker']->cv_path) }}" class="btn btn-warning">ReviewCV</a></p>
    
    <p>Here is spplicant detail Kindly review the applicant detail on the website and update the status accordingly</p>
    
</body>
</html>