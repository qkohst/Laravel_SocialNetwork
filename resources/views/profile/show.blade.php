@extends('layouts.master')
@section('content')
<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{URL::to('/')}}/profileImage/{{$data_user->profile->profile_image}}" alt="User profile picture">

            <h3 class="profile-username text-center">{{ $data_user->name }}</h3>

            <p class="text-muted text-center">Member since {{ $data_user->created_at }}</p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Followers</b> <a class="pull-right">{{$count_follower}}</a>
              </li>
              <li class="list-group-item">
                <b>Following</b> <a class="pull-right">{{$count_following}}</a>
              </li>
              <li class="list-group-item">
                <b>Posted</b> <a class="pull-right">{{$count_posted}}</a>
              </li>
            </ul>
            <form action="{{route('profile.store')}}" method="POST">
              {{csrf_field()}}
              <input type="text" id="user_id_followed" name="user_id_followed" value="{{ $data_user->id }}" style="display: none;">
              @if (empty($is_followed))
              <button class="btn btn-primary btn-block" type="submit">Follow</button>
              @else
              <button class="btn btn-danger btn-block" type="submit">Unfollow</button>
              @endif
            </form>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-check"></i> Alert!</h4>
          {{session('success')}}
        </div>
        @endif
        <!-- Post -->
        @foreach($user_post as $post)
        <div class="box">
          <div class="box-header">
            <div class="user-block">
              <img class="img-circle img-bordered-sm" src="{{URL::to('/')}}/profileImage/{{$post->user->profile->profile_image}}" alt="user image">
              <span class="username">
                <a href="#">{{$post->user->name}}</a>
              </span>
              <span class="description">Shared publicly - {{$post->created_at->diffForHumans()}}</span>
            </div>
            @if ($post->user_id == Auth::user()->id)
            <div class="box-tools">
              <button type="button" class="btn btn-tool">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="{{route('post.edit', $post->id)}}"><i class="fa fa-edit"></i>Edit This Post</a></li>
                  <li>
                    <a href="{{ route('post.destroy', $post->id) }}" onclick="event.preventDefault();
                      document.getElementById('delete').submit();">
                      <i class="fa fa-trash"></i>{{ __('Remove This Post')}}
                    </a>
                    <form id="delete" action="{{ route('post.destroy', $post->id) }}" method="POST" style="display: none;">
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
              <img class="img-responsive" src="{{URL::to('/')}}/postImage/{{$post->post_image}}" alt="Photo">
              <p>
                {{$post->post_content}}
              </p>
              <ul class="list-inline">
                <li><a href="{{route('post.like', ['id'=>$post->id])}}" class="link-black text-sm"><i class="fa fa-thumbs-up"></i> Like ({{DB::table('like_posts')->where('post_id', $post->id)->count()}})</a></li>
                <li><a href="{{route('post.show',$post->id)}}" class="link-black text-sm"><i class="fa fa-comment"></i> Comment ({{DB::table('comment_posts')->where('post_id', $post->id)->count()}})</a></li>
              </ul>
            </div>
          </div>
          <div class="box-footer">
            <form action="{{ route('post.comment.store', $post) }}" method="post">
              {{csrf_field()}}
              <img class="img-responsive img-circle img-sm" src="{{URL::to('/')}}/profileImage/{{$post->user->profile->profile_image}}" alt="Alt Text">
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
        </div>
        @endforeach
        <!-- /.post -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
</section>
@endsection