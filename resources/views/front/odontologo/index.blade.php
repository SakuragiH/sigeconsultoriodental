@extends('layouts.odontologo')

@section('title', 'Panel Odontólogo')

@section('content')
<div class="container my-5 text-center">
    <h2 style="color:#12403B;">Bienvenido, Dr. {{ Auth::user()->name }}</h2>
    <p class="mt-3" style="font-size:18px; color:#555;">
        Este es su panel principal. Aquí podrá gestionar su información, horarios y citas próximamente.
    </p>
</div>
@endsection
