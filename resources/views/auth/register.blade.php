@extends('layouts.dashboard')

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Ajouter Utlisateur</h3>
                </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
<div class="card-body">
    <div class="row">
        <div class="col-sm-4">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        </div>
        <div class="col-sm-4">
        <!-- Email Address -->
        <div >
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        </div>
        <div class="col-sm-4">
            <div >
                <x-input-label for="mle" :value="__('Matricule')" />
                <x-text-input id="mle" class="block mt-1 w-full" type="text" name="mle" :value="old('mle')" required autocomplete="mle" />
                <x-input-error :messages="$errors->get('mle')" class="mt-2" />
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-sm-5">
        <!-- Password -->
        <div >
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        </div>
        <div class="col-sm-5">
            
        <!-- Confirm Password -->
        <div >
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        </div>
        <div class="col-sm-2 mt-1">
            <div class="form-group">
                <label>Type de compte</label>
                <select class="form-control" id="acc_type" name="acc_type">
                    <option value="0">Standard</option>
                    <option value="1">Superviseur</option>
                    <option value="2">Administrateur</option>
                </select>
                </div>

        </div>
    </div>



        <div class="flex items-center justify-end mt-4">
            {{-- <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a> --}}

    
            {{-- <button class="btn btn-primary" style="color: #fff;background-color: #04aa6d;border-color: #04aa6d;box-shadow: none;display: inline-block;font-weight: 400;color: #212529;text-align: center;vertical-align: middle;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;border: 1px solid transparent;padding: 0.375rem 0.75rem;font-size: 1rem;line-height: 1.5;border-radius: 0.25rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;color: white;">
                {{ __('Log in') }}
             </button> --}}
        </div>
    </div>
    <div class="card-footer ">
        <x-primary-button class="ml-4 float-right">
            {{ __('Register') }}
        </x-primary-button>
    </div>
    </form>
            

    </div>
    </div>
@endsection
{{-- @section('register_script') --}}



