@extends('errors.template')

@section('title', 'Not Found 404')
@section('details', $exception->getMessage())
