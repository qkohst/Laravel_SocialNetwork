@extends('layouts.master')
@section('content')
<section class="content">
  <div class="container">
    <div class="row">
      <!-- Edit Post -->
      <div class="box">
        <div class="box-header border-transparent">
          <div class="user-block">
            <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
            <span class="username">
              <a>Edit Your Post</a>
            </span>
            <span class="description">Shared publicly - {{$data_post->created_at}}</span>
          </div>
          <div class="box-tools">
            <a href="/home" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
          </div>
        </div>
        <!-- /.box-header -->
        <form action="{{ route('post.update', $data_post->id) }}" method="POST">
          {{csrf_field()}}
          @method('put')
          <div class="box-body p-2">
            <img class="img-responsive center-block" src="{{URL::to('/')}}/postImage/{{$data_post->post_image}}" alt="Photo">
            <br>
            <div class="form-group mr-3 ml-3">
              <textarea class="form-control" id="post_content" name="post_content" rows="3" placeholder="White something .... " required>{{$data_post->post_content}}</textarea>
            </div>
            <div class="row mr-2 ml-2 mb-2">
              <div class="col-md-12">
                <button class="btn btn-primary btn-sm pull-right pr-3" type="submit"><i class="fa fa-save"></i> Update</button>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </form>
      </div>
      <!-- /.Edit Post -->
    </div>
  </div>
</section>
@endsection