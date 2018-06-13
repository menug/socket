@extends('layouts.app')

@section('content')
  <div class="container" id='cool'>
    <h1>{{ $post->title }}</h1>
    {{ $post->updated_at->toFormattedDateString() }}
    @if ($post->published)
      <span class="label label-success" style="margin-left:15px;">Published</span>
    @else
      <span class="label label-default" style="margin-left:15px;">Draft</span>
    @endif
    <hr />
    <p class="lead">
      {{ $post->content }}
    </p>
    <hr />

    <h3>Comments:</h3>
    <div style="margin-bottom:50px;">
      <textarea v-model='commentBox' class="form-control" rows="3" name="body" placeholder="Leave a comment" ></textarea>
      <button class="btn btn-success" style="margin-top:10px" @click='storeComments()'>Save Comment</button>
    </div>
    <div>
      <h4>You must be logged in to submit a comment!</h4> <a href="/login">Login Now &gt;&gt;</a>
    </div>


    <div class="media" style="margin-top:20px;" v-for='comment in comments'>
      <div class="media-left">
        <a href="#">
          <img class="media-object" src="http://placeimg.com/80/80" alt="...">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading pl-3">@{{comment.user.name}}  said...</h4>
        <p class='pt-3 pl-3'>
          @{{comment.body}}
        </p>
        <span style="color: #aaa;"></span>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script>
const app = new Vue({
    el: '#app',

    data:{
      commentBox:'',
      comments:{},
      post:{!! $post->toJson() !!},
      user:{!! Auth::check() ? Auth::user()->toJson() : 'null' !!},

    },
    mounted(){
      this.getComments()
    },
    methods:{
      getComments(){
        axios.get(`http://localhost/socket/public/post/${this.post.id}/comments`)
        .then(res => {
            console.log(res)
            this.comments = res.data
        })
        .catch(error => console.log(error))
      },
      storeComments(){
        axios.post(`http://localhost/socket/public/posts/${this.post.id}/comment`, {
          api_token:this.user.api_token,
          body:this.commentBox,
          
        })
        .then( res => {
          this.comments.unshift(res.data)
          this.commentBox = ''
        })
        .catch(error => console.log(error))
      }
    }



});
  </script>
@endsection



 