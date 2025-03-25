<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    
<form method="POST" action="{{ route('login') }}" class="w-full max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    @csrf

    <div class="mb-6">
        <x-input-label for="email" :value="__('Adresse Email')" 
            class="block text-gray-700 font-bold mb-2 text-sm tracking-wide"
        />
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <x-text-input 
                id="email" 
                class="block mt-1 w-full pl-10 pr-4 py-2 border rounded-lg 
                    @error('email') border-red-500 @else border-gray-300 @enderror
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 
                    transition duration-300 ease-in-out" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
                placeholder="votre.email@exemple.com"
            />
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
    </div>

    <div class="mb-6">
        <x-input-label for="password" :value="__('Mot de passe')" 
            class="block text-gray-700 font-bold mb-2 text-sm tracking-wide"
        />
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <x-text-input 
                id="password" 
                class="block mt-1 w-full pl-10 pr-4 py-2 border rounded-lg 
                    @error('password') border-red-500 @else border-gray-300 @enderror
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 
                    transition duration-300 ease-in-out" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password"
                placeholder="••••••••"
            />
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
    </div>

    <div class="flex items-center justify-between mb-6">
        <label for="remember_me" class="inline-flex items-center">
            <input 
                id="remember_me" 
                type="checkbox" 
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                name="remember"
            >
            <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
        </label>

        @if (Route::has('password.request'))
            <a 
                href="{{ route('password.request') }}" 
                class="text-sm text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline transition ease-in-out duration-150"
            >
                {{ __('Mot de passe oublié ?') }}
            </a>
        @endif
    </div>

    <div class="flex flex-col space-y-4">
        <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 transition duration-300">
            {{ __('Se connecter') }}
        </x-primary-button>

        @if (Route::has('register'))
            <div class="text-center">
                <span class="text-sm text-gray-600">{{ __('Pas de compte ?') }}</span>
                <a 
                    href="{{ route('register') }}" 
                    class="ms-2 text-sm text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline transition ease-in-out duration-150"
                >
                    {{ __('Créer un compte') }}
                </a>
            </div>
        @endif
    </div>
</form>

</x-guest-layout>