@extends('layouts.app')

@section('content')
    <livewire:mobile-home-shell
        :headline="$headline"
        :supporting-text="$supportingText"
        :stats="$stats"
        :quick-actions="$quickActions"
    />
@endsection
