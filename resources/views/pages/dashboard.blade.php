@extends('layouts.app')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">{{Auth::user()->name}} Dashboard</h4>
        </div>
        
        <div class="block-content">
            <div class="table-responsive">
                
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->

@endsection
