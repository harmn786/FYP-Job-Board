<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" integrity="sha512-Fm8kRNVGCBZn0sPmwJbVXlqfJmPC13zRsMElZenX6v721g/H7OukJd8XzDEBRQ2FSATK8xNF9UYvzsCtUpfeJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <title>Job-Board</title>
</head>
<style>
    html{
  height: 100%;
}
body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #ececec;
        min-height:100%;
        display: flex;
        flex-direction: column;
 }
    .wraper{
        display: flex;
        justify-content: center;
        flex-direction: column; 
        height: 500px;
 
        
    }
    table{
        background-color: #ffffff;
    }
 .list-circle{
        list-style-type: circle;
        padding-left: 20px;
    }
.list-circle >li >span{
    font-weight: 500;
}
.alert-success{
    width: 100% !important;
}
/* a:hover{
    color:seagreen !important;
} */
h6, .h6, h5, .h5, h4, .h4, h3, .h3, h2, .h2, h1, .h1 {
  margin-top: 0;
  margin-bottom: 0.5rem;
  font-weight: 500;
  line-height: 1.2;
}
h2:after {
  content: "";
  position: absolute;
  /* background-color: #A8DF8E; */
  background-color: seagreen;
  width: 70px;
  height: 4px;
  bottom: 0px;
  left: 0px;
}
h2 {
  font-size: 30px;
  position: relative;
  color: #414042;
}
h1, h2, h3, h4, h5, h6 {
  margin: 0;
  line-height: 1.2;
  padding: 0px 0 20px;
  font-family: 'Inter-Bold';
}
    .hero{
        background: linear-gradient(180deg,rgba(26, 25, 25, 0.8), rgba(56, 54, 54, 0.2)),url(./images/banner5.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        width: 100vw;
        /* margin-top: -50px; */
    }
    .customize-form{
        max-width: 400px;
        margin: 40px auto;
        background-color: #ffffff;
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        }
    form input,textarea,select{
       /* border: none !important; */
       background-color: #efefef !important;
       border-radius: 5px !important;
    }
   
    .user-img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    .log-condition{
        float: right;
    }
    .reset-password{
        float: left;
    }
    .heading{
        margin: 24px auto;
        text-align: center;
        font-size: 40px;
    }
    .hero-heading{

        font-size: 66px;
        font-weight: 600;
    }
    .hero-sub-heading{

    font-size: 20px;
    font-weight: 600;
    }
    footer{
        margin-top:auto;
    }
    .choice{
        padding-top: 20px;
    }
    @media(max-width:768px){
        .job-summery{
            padding-top: 20px;
        }
        p{
            font-size: 14px;
        }
    }
    h5.card-title{
        margin-bottom: 0 !important;
    }

    div.border-bottom{
        margin-bottom: 5px !important;
    }
</style>
<body>
    {{View::make('header')}}
    @yield('content')
    {{View::make('footer')}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" integrity="sha512-YJgZG+6o3xSc0k5wv774GS+W1gx0vuSI/kr0E0UylL/Qg/noNspPtYwHPN9q6n59CTR/uhgXfjDXLTRI+uIryg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.textarea').trumbowyg();
        $(document).ready(function(){
            $('.selectpicker select').selectpicker();
        });
        $(document).ready(function(){
            $('.alert').delay(3000).fadeOut();
        });

    </script>
</body>
</html>