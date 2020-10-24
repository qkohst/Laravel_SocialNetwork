@extends('layouts.master')
@section('content')
<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{URL::to('/')}}/profileImage/{{$data_userLogin->profile->profile_image}}" alt="User profile picture">

            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

            <p class="text-muted text-center">Member since {{ Auth::user()->created_at }}</p>

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
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">About Me</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <strong><i class="fa fa-id-card margin-r-5"></i>Full Name </strong>
            <p class="text-muted">
              {{$data_userLogin->profile->profile_fistName}} {{$data_userLogin->profile->profile_lastName}}
            </p>
            <hr>
            <strong><i class="fa fa-phone margin-r-5"></i> Telephone</strong>
            <p class="text-muted">{{$data_userLogin->profile->profile_phoneNumber}}</p>
            <hr>
            <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
            <p class="text-muted">{{$data_userLogin->profile->profile_address}}</p>
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
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab">My Post</a></li>
            <li><a href="#settings" data-toggle="tab">Edit My Profile</a></li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="activity">
              <!-- Post -->
              @foreach($my_post as $post)
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
            <!-- /.tab-pane -->

            <div class="tab-pane" id="settings">
              <form class="form-horizontal" action="{{route('profile.update', $data_userLogin->id)}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                @method('put')
                <div class="form-group">
                  <label for="profile_fistName" class="col-sm-2 control-label">Fist Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="profile_fistName" name="profile_fistName" placeholder="Fist Name" value="{{$data_userLogin->profile->profile_fistName}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="profile_lastName" class="col-sm-2 control-label">Last Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="profile_lastName" name="profile_lastName" placeholder="Fist Name" value="{{$data_userLogin->profile->profile_lastName}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="profile_phoneNumber" class="col-sm-2 control-label">Phone Number</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="profile_phoneNumber" name="profile_phoneNumber" placeholder="Phone Number" value="{{$data_userLogin->profile->profile_phoneNumber}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="profile_address" class="col-sm-2 control-label">Address</label>

                  <div class="col-sm-10">
                    <textarea class="form-control" id="profile_address" name="profile_address" rows="2" placeholder="Address ">{{$data_userLogin->profile->profile_address}}</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="profile_image" class="col-sm-2 control-label">Profile Image</label>

                  <div class="col-sm-10">
                    <input type="file" class="custom-file-input-sm" id="profile_image" name="profile_image" aria-describedby="inputGroupFileAddon04">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" required> I agree to the <a href="#">terms and conditions</a>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
</section>
@endsection