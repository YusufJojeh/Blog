 @extends('layouts.app')
 @section('title')
     Show
 @endsection
 @section('content')
     <div class="card mt-4">
         <div class="card-header">
             <h5 class="card-title">Title : {{ $post->title }}</h5>
         </div>
         <div class="card-body">
             <img src="{{ asset('storage/' . $post->image) }}" alt="image" class="col-md-4 card-img">
             <p class="card-text">DESCRIPTION : {{ $post->description }}</p>
         </div>
     </div>
     <div class="card mt-4">
         <div class="card-header">
             <h5 class="card-title">Post Creator Info</h5>
         </div>
         <div class="card-body">
             <h5 class="card-title">Name : {{ $post->user ? $post->user->name : 'Not Found Creator' }}</h5>
             <h5 class="card-title">Email : {{ $post->user ? $post->user->email : 'Not Found Creator' }}</h5>
             <h5 class="card-text">Created At: {{ $post->user->created_at->format('d F Y, h:i A') }}</h5>
         </div>
     </div>
 @endsection
