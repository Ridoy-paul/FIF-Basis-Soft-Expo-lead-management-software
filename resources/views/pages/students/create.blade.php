@extends('layouts.app')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="mb-1">Register Student</h4>
        </div>
        <div class="row">
            <div class="col-md-12 text-danger">
                @if($errors->any())
                    {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                @endif
            </div>
        </div>

        <div class="px-2">
            <form action="{{route('student.store')}}" class="shadow rounded p-3" method="post">
                @csrf
                <div class="font-size-sm row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Student Name</label>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Address</label>
                            <textarea name="address" id="" class="form-control" cols="30" required rows="2">{{old('address')}}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Class or Semester</label>
                            <select name="class_or_semester" class="form-control" id="" required>
                                <option value="">-- Select One --</option>
                                <option value="SSC">SSC</option>
                                <option value="HSC">HSC</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                                <option value="1st Semester">1st Semester</option>
                                <option value="2nd Semester">2nd Semester</option>
                                <option value="3rd Semester">3rd Semester</option>
                                <option value="4th Semester">4th Semester</option>
                                <option value="5th Semester">5th Semester</option>
                                <option value="6th Semester">6th Semester</option>
                                <option value="7th Semester">7th Semester</option>
                                <option value="8th Semester">8th Semester</option>
                                <option value="9th Semester">9th Semester</option>
                                <option value="10th Semester">10th Semester</option>
                                <option value="11th Semester">11th Semester</option>
                                <option value="12th Semester">12th Semester</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Subject</label>
                            <select name="subject_id" class="form-control" id="" required>
                                <option value="">-- Select Subject --</option>
                                @foreach ($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" id="instutions_div">
                            <label for="example-text-input"><span class="text-danger">*</span>Institutoins</label>
                            <select name="institute_id" class="form-control" id="institute_id" required>
                                <option value="">-- Select Institute --</option>
                                @foreach ($institutes as $institute)
                                <option value="{{$institute->id}}">{{$institute->name}}</option>
                                @endforeach
                                <option value="add_new">Add New</option>
                            </select>
                        </div>
                        <div class="form-group" id="new_instutions_div" style="display: none;">
                            <label for="example-text-input"><span class="text-danger">*</span>Institutoins Name</label>
                            <input type="text" class="form-control" id="institute_name" name="institute_name">
                        </div>
                        
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Interested Course</label>
                            <select name="interested_course" class="form-control" id="" required>
                                <option value="">-- Interested Course --</option>
                                <option value="Graphics Design">Graphics Design</option>
                                <option value="Web Design & Advance Wordpress">Web Design & Advance Wordpress</option>
                                <option value="Digital Marketing">Digital Marketing</option>
                                <option value="Web Development With Laravel">Web Development With Laravel</option>
                                <option value="Basic Computer">Basic Computer</option>
                            </select>
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
