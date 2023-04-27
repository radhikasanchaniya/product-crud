@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('content')
    <section id="dashboard-ecommerce">
        <div class="row match-height">
            <div class="col-xl-12 col-md-12 col-12">
                <div class="card card-congratulation-medal">
                    <div class="card-body">
                        <h5>Congratulations 🎉 {{ Auth::user()->name }}!</h5>
                        <p class="card-text font-small-3">You are successfull logged in</p>
                        <img src="{{ asset('assets/images/pages/badge.svg') }}" class="congratulation-medal"
                            alt="Medal Pic" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
