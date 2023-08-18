@extends('layout/thirdLayout')

@section('title', 'Maps')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?= $settings[3]->option_value ?>
                </div>
            </div>
        </div>
    </div>
@endsection
