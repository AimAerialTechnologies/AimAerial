@extends('layouts.master')

@section('title',"Feedback Form" )

@section('breadcrumb')
  <li class="breadcrumb-item">
    <a href="{{route('users.index')}}">
    All User</a>
  </li>
  <li class="breadcrumb-item active">Feedback Form</li>
@endsection

@section('content')

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="col-sm-4">
            <form>
              <div class="mb-3">
                  <label for="feedback" class="form-label">Type of Issue</label>
                  <select class="form-select" id="feedback">
                      <option>Design</option>
                      <option>Performance</option>
                      <option>Errors</option>
                      <option>Others</option>
                  </select>
              </div>
              <div class="mb-3">
                  <label for="example-textarea" class="form-label">Please Describe the issue</label>
                  <textarea class="form-control" id="feedback-text"
                      rows="5"></textarea>
              </div>
              <div class="mb-3 float-end">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
