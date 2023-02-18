@extends('layouts.app')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <!-- Overview -->
    <div class="row">
    <div class="col-sm-12 col-xl-12 col-md-12">
            <!-- Pending Orders -->
            <div class="row">
                <div class="col-md-12 text-danger">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                    @endif
                </div>
            </div>
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <div class="col-lg-12 col-xl-12">
                    <form action="{{route('institute.update', $institute->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="block-content font-size-sm row">

                        <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input">Institute Name</label>
                                    <input type="text" class="form-control" id="" value="{{$institute->name}}" required name="name">
                                </div>
                            </div>
                            
                            <div class="form-group text-right col-md-12">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                            </div>
                        </div>
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Overview -->

</div>
<!-- END Page Content -->

@endsection
