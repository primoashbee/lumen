@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', 'Error')
@section('message', __($exception->getMessage() ? 'You dont have access to this action':'Forbidden'))
