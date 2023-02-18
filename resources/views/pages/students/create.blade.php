@extends('layouts.app')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="mb-1">Register New Visitor</h4>
        </div>
        <div class="row">
            <div class="col-md-12 text-danger">
                @if($errors->any())
                    {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                @endif
            </div>
        </div>

        <div class="px-2">
            <form action="{{route('visitor.store')}}" class="shadow rounded p-3" method="post">
                @csrf
                <div class="font-size-sm row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Visitor Name</label>
                            <input type="text" class="form-control" id="" value="{{old('name')}}" required name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Phone</label>
                            <input type="number" class="form-control" id="" value="{{old('phone')}}" required name="phone">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input">Email</label>
                            <input type="email" class="form-control" id="" value="{{old('email')}}" name="email">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input">Company Name</label>
                            <input type="text" class="form-control" id="" value="{{old('company_name')}}" name="company_name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input">Designation</label>
                            <input type="text" class="form-control" id="" value="{{old('designation')}}" name="designation">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input">Interested Service</label>
                            <select name="interested_service" class="form-control" id="">
                                <option value="">-- Interested Service --</option>
                                <option value="Website Solution">Website Solution</option>
                                <option value="POS">POS</option>
                                <option value="School Management Software">School Management Software</option>
                                <option value="Digital Marketing">Digital Marketing</option>
                                <option value="Graphics Support">Graphics Support</option>
                                <option value="Customized Software">Customized Software</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input">Address</label>
                            <textarea name="address" id="" class="form-control" cols="30" rows="2">{{old('address')}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input">Note</label>
                            <textarea name="note" id="" class="form-control" cols="30" rows="2">{{old('note')}}</textarea>
                        </div>
                    </div>
                    
                    
                    
                </div>
                <div class="block-content block-content-full text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
        </div>
    </div>
    <!-- END Full Table -->

</div>
<!-- END Page Content -->



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>

    $('#institute_id').change(function() {
       var value = $(this).val();
       if(value == 'add_new') {
            $('#instutions_div').hide();
            $('#new_instutions_div').show();
            $("#institute_name").prop('required',true);
            $("#institute_id").prop('required',false);
       }
    });

    </script>
@endsection
