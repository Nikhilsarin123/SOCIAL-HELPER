@extends('layouts.admin_main')

@section('content')
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">PUBLISH LINK TO YOUR FACEBOOK GROUPS</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
              <form role="form" action="{{ route('plink.store') }}" enctype="multipart/form-data" method="post">
                 @csrf
                <div class="card-body">
                  <div class="form-group @error('message') is-invalid @enderror">
                    <label for="exampleInputEmail1">Message</label>
                    <input type="Text" class="form-control" id="exampleInputEmail1" name="message" value=" " placeholder="Message Or Caption">

                  </div>

                   <div class="card-body">
                  <div class="form-group @error('message') is-invalid @enderror">
                    <label for="exampleInputEmail1">URL</label>
                    <input type="url" class="form-control" id="exampleInputEmail1" name="message" value=" " placeholder="Message Or Caption">

                  </div>


      

                   <div class="form-group @error('location') is-invalid @enderror">
                        <label>Select Group You Want To post</label>
                         <a href="#" class="btn btn-block btn-primary">
                         <i class="fab fa-facebook mr-2"></i> select The page you want to post
                            </a>
                        <select name="page_id" value="page_id" class="form-control">
                              <option value="">--- Select Group ---</option>
                            
                          @foreach($items_name as $id => $item)
                           <option value="{{$item}}" >{{$id}}</option>
                          @endforeach
        
                        @error('GroupName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </select>
                      </div>

                       <div class="form-group @error('message') is-invalid @enderror">
                   <a href="#" class="btn btn-block btn-primary">
                         <i class="fab fa-facebook mr-2"></i> select Time and date  you want to publish
                            </a><br>
                    
                    <input type="Time" class="form-control" id="exampleInputEmail1" name="time" value=" " placeholder="please enter time">
                    <input type="date" class="form-control" id="exampleInputEmail1" name="date" value=" " placeholder="Message Or Caption"><br>
                    <a href="#" class="btn btn-block btn-primary">
                         <i class="fab fa-facebook mr-2"></i> if you want to publish Now Click here on checkbox
                            </a><br>
                    <input type="checkbox" class="form-control" id="exampleInputEmail1" name="now" value="now" >

                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>

  @endsection