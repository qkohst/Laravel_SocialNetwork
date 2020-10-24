@extends('layouts.master')
@section('content')
<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-check"></i> Alert!</h4>
          {{session('success')}}
        </div>
        @endif
        <!-- Posted -->
        <div class="box">
          <div class="box-header">
            <div class="user-block">
              <img class="img-circle img-bordered-sm" src="{{URL::to('/')}}/profileImage/{{$data_post->user->profile->profile_image}}" alt="user image">
              <span class="username">
                <a href="#">{{$data_post->user->name}}</a>
              </span>
              <span class="description">Shared publicly - {{$data_post->created_at->diffForHumans()}}</span>
            </div>
            @if ($data_post->user_id == Auth::user()->id)
            <div class="box-tools">
              <button type="button" class="btn btn-tool">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="{{route('post.edit', $data_post->id)}}"><i class="fa fa-edit"></i>Edit This Post</a></li>
                  <li>
                    <a href="{{ route('post.destroy', $data_post->id) }}" onclick="event.preventDefault();
                      document.getElementById('delete').submit();">
                      <i class="fa fa-trash"></i>{{ __('Remove This Post')}}
                    </a>
                    <form id="delete" action="{{ route('post.destroy', $data_post->id) }}" method="POST" style="display: none;">
                      @csrf
                      @method('delete')
                    </form>
                  </li>
                </ul>
              </button>
            </div>
            @endif
          </div>
          <!-- /.user-block -->
          <div class="box-body">
            <div class="post">
              <img class="img-responsive center-block" src="{{URL::to('/')}}/postImage/{{$data_post->post_image}}" alt="Photo">
              <p>
                {{$data_post->post_content}}
              </p>
              <ul class="list-inline">
                <li><a href="{{route('post.like', ['id'=>$data_post->id])}}" class="link-black text-sm"><i class="fa fa-thumbs-up"></i> Like ({{DB::table('like_posts')->where('post_id', $data_post->id)->count()}})</a></li>
                <li><a href="{{route('post.show',$data_post->id)}}" class="link-black text-sm"><i class="fa fa-comment"></i> Comment ({{DB::table('comment_posts')->where('post_id', $data_post->id)->count()}})</a></li>
              </ul>
            </div>
          </div>
          <div class="box-footer">
            <form action="{{ route('post.comment.store', $data_post) }}" method="post">
              {{csrf_field()}}
              <img class="img-responsive img-circle img-sm" src="{{URL::to('/')}}/profileImage/{{Auth::user()->profile->profile_image}}" alt="Alt Text">
              <!-- .img-push is used to add margin to elements next to floating images -->
              <div class="img-push">
                <div class="input-group">
                  <input type="text" name="commenntPost_content" id="commenntPost_content" placeholder="Type comment ..." class="form-control" required>
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-success btn-flat">Send</button>
                  </span>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer box-comments">
            @foreach($data_post->commentPost()->orderByRaw('created_at DESC')->get() as $comment)
            <div class="box-comment">
              <!-- User image -->
              <img class="img-circle img-sm" src="{{URL::to('/')}}/profileImage/{{$comment->user->profile->profile_image}}" alt="User Image">
              <div class="comment-text">
                <span class="username">
                  {{$comment->user->name}}
                  <span class="text-muted pull-right">{{$comment->created_at->diffForHumans()}}</span>
                </span><!-- /.username -->
                {{$comment->commentPost_content}}
                <ul class="list-inline">
                  <li><a href="{{route('comment.like', ['id'=>$comment->id])}}" class="link-black text-sm"><i class="fa fa-thumbs-up"></i> Like ({{DB::table('like_comment_posts')->where('commentPost_id', $comment->id)->count()}})</a></li>
                </ul>
              </div>
              <!-- /.comment-text -->
            </div>
            @endforeach
            <!-- /.box-comment -->
          </div>
          <!-- /.box-footer -->
        </div>
        <!-- /Posted -->
      </div>

      <!-- Right Colom  -->
      <div class="col-md-3">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Latest Post</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
              @foreach($latest_post as $lPost)
              <li class="item">
                <div class="product-img">
                  <img src="{{URL::to('/')}}/postImage/{{$lPost->post_image}}" alt="Image">
                </div>
                <div class="product-info">
                  <a href="{{route('post.show',$lPost->id)}}" class="product-title">{{$lPost->user->name}}
                    <span class="label label-success pull-right">{{$lPost->created_at->diffForHumans()}}</span></a>
                  <span class="product-description">
                    {{$lPost->post_content}}
                  </span>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </div>
</section>
@endsection