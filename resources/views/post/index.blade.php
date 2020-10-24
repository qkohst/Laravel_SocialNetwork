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
        <!-- Create Post -->
        <div class="box">
          <div class="box-header border-transparent">
            <div class="user-block">
              <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
              <span class="username">
                <a>Create Your Post</a>
              </span>
              <span class="description">Post as - {{ Auth::user()->name }}</span>
            </div>
          </div>
          <!-- /.box-header -->
          <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="box-body p-0">
              <div class="form-group mr-3 ml-3">
                <textarea class="form-control" id="post_content" name="post_content" rows="3" placeholder="White something .... " required>{{old('post_content')}}</textarea>
              </div>
              <div class="row mr-2 ml-2 mb-2">
                <div class="col-md-8">
                  <div class="custom-file custom-file-sm">
                    <input type="file" class="custom-file-input-sm" id="postImageName" name="postImageName" aria-describedby="inputGroupFileAddon04" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <button class="btn btn-primary btn-sm pull-right" type="submit"><i class="fa fa-paper-plane"></i> Post</button>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </form>
        </div>
        <!-- /.Create Post -->

        <!-- Posted -->
        @foreach($data_post as $post)
        <div class="box">
          <div class="box-header">
            <div class="user-block">
              <img class="img-circle img-bordered-sm" src="https://adminlte.io/themes/AdminLTE/dist/img/user7-128x128.jpg" alt="user image">
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
                <li><a class="link-black text-sm"><i class="fa fa-comment"></i> Comment ({{DB::table('comment_posts')->where('post_id', $post->id)->count()}})</a></li>
              </ul>
            </div>
          </div>
          <div class="box-footer">
            <form action="{{ route('post.comment.store', $post) }}" method="post">
              {{csrf_field()}}
              <img class="img-responsive img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="Alt Text">
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
            @foreach($post->commentPost()->orderByRaw('created_at DESC')->get() as $comment)
            <div class="box-comment">
              <!-- User image -->
              <img class="img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image">
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
        @endforeach
        <!-- /Posted -->
      </div>

      <!-- Right Colom  -->
      <div class="col-md-3">
        <!-- USERS LIST -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">New Followers</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <ul class="users-list clearfix">
              <li>
                <img src="dist/img/user1-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Alexander Pierce</a>
                <span class="users-list-date">Today</span>
              </li>
              <li>
                <img src="dist/img/user8-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Norman</a>
                <span class="users-list-date">Yesterday</span>
              </li>
              <li>
                <img src="dist/img/user7-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Jane</a>
                <span class="users-list-date">12 Jan</span>
              </li>
              <li>
                <img src="dist/img/user6-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">John</a>
                <span class="users-list-date">12 Jan</span>
              </li>
              <li>
                <img src="dist/img/user2-160x160.jpg" alt="User Image">
                <a class="users-list-name" href="#">Alexander</a>
                <span class="users-list-date">13 Jan</span>
              </li>
              <li>
                <img src="dist/img/user5-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Sarah</a>
                <span class="users-list-date">14 Jan</span>
              </li>
              <li>
                <img src="dist/img/user4-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Nora</a>
                <span class="users-list-date">15 Jan</span>
              </li>
              <li>
                <img src="dist/img/user3-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Nadia</a>
                <span class="users-list-date">15 Jan</span>
              </li>
            </ul>
            <!-- /.users-list -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer text-center">
            <a href="javascript:void(0)" class="uppercase">View All Followers</a>
          </div>
          <!-- /.box-footer -->
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Popular Post</h3>

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
                  <a href="javascript:void(0)" class="product-title">{{$lPost->user->name}}
                    <span class="label label-success pull-right">{{$lPost->created_at}}</span></a>
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