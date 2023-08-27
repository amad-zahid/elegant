<x-guest-layout>

    @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif


    <form method="POST" action="{{ route('web.contact') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autofocus autocomplete="phone_number" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Desired Budget -->
        <div class="mt-4">
            <x-input-label for="desired_budget" :value="__('Desired Budget')" />
            <x-text-input id="desired_budget" class="block mt-1 w-full" type="number" name="desired_budget" :value="old('desired_budget')" required autofocus autocomplete="desired_budget" />
            <x-input-error :messages="$errors->get('desired_budget')" class="mt-2" />
        </div>
        
        <!-- Message -->
        <div class="mt-4">
            <label for="message" class="block font-medium text-sm text-gray-700">{{ __('Message') }}</label>
            <textarea id="message" name="message" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="4" required autocomplete="off">{{ old('message') }}</textarea>
            @error('message')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ml-4">
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
