@extends('layouts.app')

@section('content')
    <h3>Add New Member</h3>
    @if($errors->any())
        {!! implode('', $errors->all('<div class="alert alert-danger alert-dismissible fade show" role="alert">:message <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')) !!}
    @endif
    <form method="POST" action="{{ route('members.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="school_id">School:</label>
            <select class="form-control" id="school-id" name="school_id[]" multiple required>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </div>
        <a href="{{ url('/') }}" class="btn mt-3 btn-danger">Back</a>
        <button type="submit" class="btn mt-3 btn-primary">Add Member</button>
    </form>

    <script>
        $( '#school-id' ).select2( {
            theme: 'bootstrap-5'
        } );
    </script>
@endsection


