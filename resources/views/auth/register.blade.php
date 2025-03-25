<x-guest-layout>
   
    <form method="POST" action="{{ route('register') }}" class="w-full max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        @csrf
    
        <!-- Nom -->
        <div class="mb-6">
            <x-input-label for="name" :value="__('Nom Complet')" 
                class="block text-gray-700 font-bold mb-2 text-sm tracking-wide"
            />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input 
                    id="name" 
                    class="block mt-1 w-full pl-10 pr-4 py-2 border rounded-lg 
                        @error('name') border-red-500 @else border-gray-300 @enderror
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 
                        transition duration-300 ease-in-out" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    required 
                    autofocus 
                    autocomplete="name" 
                    placeholder="Votre nom complet"
                />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
        </div>
    
        <!-- Email -->
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
                    autocomplete="username" 
                    placeholder="votre.email@exemple.com"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>
    
        <!-- Mot de passe -->
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
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>
    
        <!-- Confirmation du mot de passe -->
        <div class="mb-6">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" 
                class="block text-gray-700 font-bold mb-2 text-sm tracking-wide"
            />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input 
                    id="password_confirmation" 
                    class="block mt-1 w-full pl-10 pr-4 py-2 border rounded-lg 
                        border-gray-300
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 
                        transition duration-300 ease-in-out" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
        </div>
    
        <!-- Rôle -->
        <div class="mb-6">
            <x-input-label for="role" :value="__('Rôle')" 
                class="block text-gray-700 font-bold mb-2 text-sm tracking-wide"
            />
            <div class="relative">
                <select 
                    id="role" 
                    name="role" 
                    class="block mt-1 w-full pl-3 pr-10 py-2 border rounded-lg 
                        @error('role') border-red-500 @else border-gray-300 @enderror
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 
                        transition duration-300 ease-in-out"
                >
                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                    <option value="gestionnaire" {{ old('role') == 'gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-500 text-sm" />
        </div>
    
        <div class="flex flex-col space-y-4">
            <div class="flex items-center justify-between">
                <a 
                    href="{{ route('login') }}" 
                    class="text-sm text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline transition ease-in-out duration-150"
                >
                    {{ __('Déjà inscrit ?') }}
                </a>
    
                <x-primary-button class="ml-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 transition duration-300">
                    {{ __('S\'inscrire') }}
                </x-primary-button>
            </div>
        </div>
    </form>
    
</x-guest-layout>
