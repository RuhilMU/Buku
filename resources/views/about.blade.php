<!-- resources/views/about.blade.php -->

@extends('layout')

@section('title', 'About Page')

@section('content')
    <h2>About Me</h2>
    <p>This page tells you more about me.</p>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $name; ?></td>
                <td><?= $email; ?></td>
            </tr>
        </tbody>
    </table>
@endsection
