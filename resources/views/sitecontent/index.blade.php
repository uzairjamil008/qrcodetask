@extends('layout.header')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@section('breadcrumb')
<h2 class="content-header-title float-left mb-0">Site Content</h2>
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('admin/site_content')}}">Site Content</a>
        </li>
        <li class="breadcrumb-item"><a href="#">{{$data['page_title']}}</a>
        </li>
    </ol>
</div>
@endsection
<div class="content-body">
    <section id="basic-input">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('admin/save_site_content') }}" class="" id="form_submit" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    Company Profile
                                </label>
                                <!-- <input class="form-control" name="company_profile" type="text" value="{{(isset($data['results']->company_profile) ? $data['results']->company_profile : '')}}" required> -->
                                <textarea class="form-control" name="company_profile" id="company_profile" rows="5">{{(isset($data['results']->company_profile) ? $data['results']->company_profile : '')}}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    What We Do
                                </label>
                                <textarea class="form-control" name="what_we_do" id="what_we_do" rows="5">{{(isset($data['results']->what_we_do) ? $data['results']->what_we_do : '')}}</textarea>
                                <!-- <input class="form-control" name="what_we_do" type="text" value="{{(isset($data['results']->what_we_do) ? $data['results']->what_we_do : '')}}" required> -->
                                </input>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    Our Goals
                                </label>
                                <textarea class="form-control" name="our_goals" id="our_goals" rows="5">{{(isset($data['results']->our_goals) ? $data['results']->our_goals : '')}}</textarea>
                                <!-- <input class="form-control" name="our_goals" type="text" value="{{(isset($data['results']->our_goals) ? $data['results']->our_goals : '')}}" required> -->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    Our Mission
                                </label>
                                <textarea class="form-control" name="our_mission" id="our_mission" rows="5">{{(isset($data['results']->our_mission) ? $data['results']->our_mission : '')}}</textarea>
                                <!-- <input class="form-control" name="our_mission" type="text" value="{{(isset($data['results']->our_mission) ? $data['results']->our_mission : '')}}" required> -->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    Our Ethics
                                </label>
                                <textarea class="form-control" name="our_ethics" id="our_ethics" rows="5">{{(isset($data['results']->our_ethics) ? $data['results']->our_ethics : '')}}</textarea>
                                <!-- <input class="form-control" name="our_ethics" type="text" value="{{(isset($data['results']->our_ethics) ? $data['results']->our_ethics : '')}}" required> -->
                            </div>
                        </div>



                    </div>
                    <input class="form-control" name="id" type="hidden" value="{{(isset($data['results']->id) ? $data['results']->id : '')}}">
                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                    </input>
                    </input>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection





@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="{{asset('/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.usermgt').addClass('sidebar-group-active');
        $('.sitecontent').addClass('active');
    });
    $(document).ready(function() {
        $('#company_profile').summernote();
        $('#what_we_do').summernote();
        $('#our_goals').summernote();
        $('#our_mission').summernote();
        $('#our_ethics').summernote();
    });
</script>
@endsection