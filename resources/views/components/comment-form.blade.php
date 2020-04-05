<div class="mt-2 mb-2">
    @auth
           <form method="POST" action="{{ $routeSlot }}">
               @csrf

               <div class="form-group">

                   <textarea type="text"
                   name="content"
                   class="form-control"
                   />

                   </textarea>
               </div>

               <button type="submit" class="btn btn-success">Add Comment</button>
           </form>
           <x-errors></x-errors>
       @else
       <a href="{{ route('login') }}">Please sign in to post comments!</a>

       @endauth
       <hr/>
   </div>
