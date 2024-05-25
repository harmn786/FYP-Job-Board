<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" />
    <title>Job-Board</title>
</head>
<body onload="typeWriter();">
    {{View::make('front.app.header')}}
    @yield('content')
    {{-- JobSeeker Model --}}
    <div class="modal fade" id="ImageModal" tabindex="-1" aria-labelledby="ImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title pb-0" id="ImageModalLabel">Change Profile Picture</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="" id="UserProfilePicForm" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                      <input type="file" class="form-control @error('image') is-invalid  @enderror" id="image"  name="image">
                      <p class="text-danger" id="image-error"></p>
                      <p class="text-success" id="image-success"></p>
                    </span>
                  </div>
                  <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary mx-3">Update</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                  
              </form>
            </div>
          </div>
        </div>
      </div>
      {{-- Employer Model --}}

      {{-- <div class="modal fade" id="EmployerModal" tabindex="-1" aria-labelledby="employerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title pb-0" id="employerModalLabel">Change Profile Picture</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="" id="EmployerProfilePicForm" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                      <input type="file" class="form-control @error('image') is-invalid  @enderror" id="image"  name="image">
                      <p class="text-danger" id="employer-image-error"></p>
                      <p class="text-success" id="employer-image-success"></p>
                    </span>
                  </div>
                  <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary mx-3">Update</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                  
              </form>
            </div>
          </div>
        </div>
      </div> --}}

      {{-- Admin Model --}}
      {{-- <div class="modal fade" id="AdminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title pb-0" id="adminModalLabel">Change Profile Picture</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="" id="AdminProfilePicForm" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                      <input type="file" class="form-control @error('image') is-invalid  @enderror" id="image"  name="image">
                      <p class="text-danger" id="admin-image-error"></p>
                      <p class="text-success" id="admin-image-success"></p>
                    </span>
                  </div>
                  <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary mx-3">Update</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                  
              </form>
            </div>
          </div>
        </div>
      </div> --}}



    {{View::make('front.app.footer')}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script> --}}
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" ></script>
    @yield('customJs')
    <script>
      $('.textarea').trumbowyg();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    </script>
    <script>
        // jobSeekerUpdatePicCode
        $("#UserProfilePicForm").submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:'{{ route('user.updateImage') }}',
                type:'post',
                data: formData,
                dataType:'json',
                contentType:false,
                processData:false,
                success: function(response){
                    if(response.status == false){
                        var errors = response.errors;
                        if(errors.image){
                            $("#image-error").html(errors.image);
                        }
                    }
                    else{
                            window.location.href = '{{ url()->current() }}'
                        }
                }
            });
        });
        
        // $(document).ready(function(){
        //     $('.selectpicker select').selectpicker();
        // });
        $(document).ready(function(){
            $('.alert').delay(3000).fadeOut();
        });

    </script>
    
      
</body>
</html>