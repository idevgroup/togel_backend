@extends('backend.template.main')
@push('title', __('Forbidden'))
@section('content', __($exception->getMessage() ?: 'Forbidden'))
