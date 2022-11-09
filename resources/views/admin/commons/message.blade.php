<?php

/**
* Contains the notify plugin style
*
* @var string
*/
// $class = Session::get('messageClass') ? Session::get('messageClass') : 'alert alert-success';
// $class = is_array($class) ? implode('', $class) : $class;

/**
* Contains the notify plugin message.
*
* @var string / array
*/
$m = Session::get('success');
$m = $m ? (is_array($m) ? Html::ul($m ,['class' => 'm-0']) : '<p class="m-0">'.$m.'</p>') : '';

/**
* Laravel errors message controller
*
* @var array
*/
//   print_r($errors);
// $e = Session::get('errors');
// $e = $e ? (is_array($e) ? Html::ul($e,['class' => 'm-0']) : '<p class="m-0">'.$e.'</p>') : '';
$e = $errors->any() ? Html::ul($errors->all(),['class' => 'm-0']) : '';
//forgetting flash data to control app notify messages.
// Session::forget('message');
// Session::forget('messageClass');
// Session::save();

?>
@if($m!='' || $e!='')
  @if($m!='')
    <div class="alert alert-success alert-dismissible fade show" role="alert">{!! $m !!}
      {{-- <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button> --}}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>
  @endif
  @if($e!='')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">{!! $e !!}
      {{-- <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button> --}}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

@endif
@if (Session::has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {!!Session::get('error')!!}
    {{-- <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button> --}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

  </div>
@endif
