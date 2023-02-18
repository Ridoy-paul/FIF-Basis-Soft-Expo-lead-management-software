@extends('layouts.app')
@section('body_content')
@php


@endphp
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="mb-1">Update Student Info</h4>
        </div>
        <div class="row">
            <div class="col-md-12 text-danger">
                @if($errors->any())
                    {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                @endif
            </div>
        </div>

        <div class="px-2">
            <form action="{{route('student.update', optional($studentInfo)->id)}}" class="shadow rounded p-3" method="post">
                @csrf
                <div class="font-size-sm row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Student Name</label>
                            <input type="text" class="form-control" id="" value="{{optional($studentInfo)->name}}" required name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Phone</label>
                            <input type="number" class="form-control" id="" value="{{optional($studentInfo)->phone}}" required name="phone">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input">Email</label>
                            <input type="email" class="form-control" id="" value="{{optional($studentInfo)->email}}" name="email">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Address</label>
                            <textarea name="address" id="" class="form-control" cols="30" required rows="2">{{optional($studentInfo)->address}}</textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Class or Semester</label>
                            <select name="class_or_semester" class="form-control" id="" required>
                                <option value="">-- Select One --</option>
                                <option @if(optional($studentInfo)->class_or_semester == 'SSC') selected class="text-light bg-success" @endif value="SSC">SSC</option>
                                <option @if(optional($studentInfo)->class_or_semester == 'HSC') selected class="text-light bg-success" @endif value="HSC">HSC</option>
                                <option @if(optional($studentInfo)->class_or_semester == '1st Year') selected class="text-light bg-success" @endif value="1st Year">1st Year</option>
                                <option @if(optional($studentInfo)->class_or_semester == '2nd Year') selected class="text-light bg-success" @endif value="2nd Year">2nd Year</option>
                                <option @if(optional($studentInfo)->class_or_semester == '3rd Year') selected class="text-light bg-success" @endif value="3rd Year">3rd Year</option>
                                <option @if(optional($studentInfo)->class_or_semester == '4th Year') selected class="text-light bg-success" @endif value="4th Year">4th Year</option>
                                <option @if(optional($studentInfo)->class_or_semester == '1st Semester') selected class="text-light bg-success" @endif value="1st Semester">1st Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '2nd Semester') selected class="text-light bg-success" @endif value="2nd Semester">2nd Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '3rd Semester') selected class="text-light bg-success" @endif value="3rd Semester">3rd Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '4th Semester') selected class="text-light bg-success" @endif value="4th Semester">4th Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '5th Semester') selected class="text-light bg-success" @endif value="5th Semester">5th Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '6th Semester') selected class="text-light bg-success" @endif value="6th Semester">6th Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '7th Semester') selected class="text-light bg-success" @endif value="7th Semester">7th Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '8th Semester') selected class="text-light bg-success" @endif value="8th Semester">8th Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '9th Semester') selected class="text-light bg-success" @endif value="9th Semester">9th Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '10th Semester') selected class="text-light bg-success" @endif value="10th Semester">10th Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '11th Semester') selected class="text-light bg-success" @endif value="11th Semester">11th Semester</option>
                                <option @if(optional($studentInfo)->class_or_semester == '12th Semester') selected class="text-light bg-success" @endif value="12th Semester">12th Semester</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Subject</label>
                            <select name="subject_id" class="form-control" id="" required>
                                <option value="">-- Select Subject --</option>
                                @foreach ($subjects as $subject)
                                <option @if(optional($studentInfo)->subject_id == $subject->id) selected class="text-light bg-success" @endif value="{{$subject->id}}">{{$subject->name}}</option>
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
                                <option @if(optional($studentInfo)->institute_id == $institute->id) selected class="text-light bg-light" @endif value="{{$institute->id}}">{{$institute->name}}</option>
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
                                <option  @if(optional($studentInfo)->interested_course == 'Graphics Design') selected class="text-light bg-light" @endif value="Graphics Design">Graphics Design</option>
                                <option  @if(optional($studentInfo)->interested_course == 'Web Design & Advance Wordpress') selected class="text-light bg-light" @endif  value="Web Design & Advance Wordpress">Web Design & Advance Wordpress</option>
                                <option  @if(optional($studentInfo)->interested_course == 'Digital Marketing') selected class="text-light bg-light" @endif  value="Digital Marketing">Digital Marketing</option>
                                <option  @if(optional($studentInfo)->interested_course == 'Web Development With Laravel') selected class="text-light bg-light" @endif  value="Web Development With Laravel">Web Development With Laravel</option>
                                <option  @if(optional($studentInfo)->interested_course == 'Basic Computer') selected class="text-light bg-light" @endif  value="Basic Computer">Basic Computer</option>
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
