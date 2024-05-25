{{-- jobs/index.blade.php --}}

@extends('front.app.master')

@section('content')
   <!-- Contact Start -->
            @if(session()->get('message'))
                <div class="alert alert-success" role="alert">
                    <strong>Success: </strong>{{session()->get('message')}}
                </div>
                @endif
                @if(session()->get('error'))
                <div class="alert alert-danger" role="alert">
                    <strong>Error: </strong>{{session()->get('error')}}
                </div>
                @endif
    <div class="container">
        <h2 class="mt-4">Contact Us</h2>
        <h1 class="text-center mb-5 text-home">Contact For Any Query</h1>
        <div class="row g-4 mb-4 mt4 p3 bg-white">
            <div class="col-12">
                <div class="row gy-4">
                    <div class="col-md-4 " data-wow-delay="0.1s">
                        <div class="d-flex align-items-center bg-light rounded p-4">
                            <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                <i class="fa fa-map text-home"></i>
                            </div>
                            <span>Liaquat Pur, Rahim yar Khan</span>
                        </div>
                    </div>
                    <div class="col-md-4 wow fadeIn" data-wow-delay="0.3s">
                        <div class="d-flex align-items-center bg-light rounded p-4">
                            <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                <i class="fa fa-envelope text-home"></i>
                            </div>
                            <span>devbyabdulrehman.armn@gmail.com</span>
                        </div>
                    </div>
                    <div class="col-md-4 wow fadeIn" data-wow-delay="0.5s">
                        <div class="d-flex align-items-center bg-light rounded p-4">
                            <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                <i class="fa fa-phone text-home"></i>
                            </div>
                            <span>+923156575594</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13964.536634551607!2d70.87085617813048!3d28.953745033706205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x393a3cc9b0172907%3A0xaa8ac7c074714f9!2sAllah%20Abad%2C%20Rahim%20Yar%20Khan%2C%20Punjab%2C%20Pakistan!5e0!3m2!1sen!2s!4v1716616563915!5m2!1sen!2s" width="530" height="470" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6">
                <div class="wow fadeInUp" data-wow-delay="0.5s">
                    <p class="mb-4">Lorem ipsum dolor, sit amet consectetur adipisicing elit
                        Nequaperiam inventore, suscipit dolorem quae eius in omnis laboriosam consequuntur facilis consequatur! Obcaecati, placeat.
                          </a></p>
                          <form action="{{ route('addContactUsData') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" placeholder="Your Name">
                                        <label for="name">Your Name</label>
                                        <span class="text-danger">
                                            @error('name')
                                                {{$message}}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control @error('email') is-invalid  @enderror" id="email" name="email" placeholder="Your Email">
                                        <label for="email">Your Email</label>
                                        <span class="text-danger">
                                            @error('email')
                                                {{$message}}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('subject') is-invalid  @enderror" name="subject" id="subject" placeholder="Subject">
                                        <label for="subject">Subject</label>
                                        <span class="text-danger">
                                            @error('subject')
                                                {{$message}}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control @error('message') is-invalid  @enderror" name="message" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                        <label for="message">Message</label>
                                        <span class="text-danger">
                                            @error('message')
                                                {{$message}}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-success w-100 py-3" type="submit" name="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
<!-- Contact End -->
@endsection



