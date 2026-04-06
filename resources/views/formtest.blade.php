<x-layout>

    
    @if (session('success'))
        <div class="mx-auto max-w-2xl mt-6 px-4">
            <div class="rounded-md bg-green-500/10 border border-green-500/30 px-4 py-3 text-sm text-green-400">
                ✓ {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div class="mx-auto max-w-2xl mt-6 px-4">
            <div class="rounded-md bg-yellow-500/10 border border-yellow-500/30 px-4 py-3 text-sm text-yellow-400">
                ⚠ {{ session('warning') }}
            </div>
        </div>
    @endif

    
    @if (count($emails) < 5)
        <form method="POST" action="/formtest">
            @csrf
            <div class="space-y-12">
                <div class="border-b border-white/10">
                    <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-12 p-10 bg-gray-800 rounded-lg">
                        <div class="sm:col-span-4">
                            <label for="email" class="block text-sm/6 font-medium text-white">Email</label>
                            <div class="mt-2">
                                <div class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="juandelacruz@umindanao.edu.ph"
                                        class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6 {{ $errors->has('email') ? 'outline outline-red-500' : '' }}"
                                    />
                                </div>

                                
                                @error('email')
                                    <p class="mt-1 text-xs text-red-400">✗ {{ $message }}</p>
                                @enderror

                                <div class="mt-3 flex items-center gap-x-6 justify-end">
                                    <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        
        <div class="mx-auto max-w-2xl mt-6 px-4">
            <div class="rounded-md bg-yellow-500/10 border border-yellow-500/30 px-4 py-3 text-sm text-yellow-400">
                ⚠ Maximum of 5 emails reached. Remove one before adding more.
            </div>
        </div>
    @endif

    
    <div class="mt-3 p-5">
        <h2 class="text-lg font-semibold text-white">
            Emails
            <span class="ml-2 text-sm font-normal text-gray-400">({{ count($emails) }}/5)</span>
        </h2>

        <ul>
            @forelse ($emails as $index => $email)
                <li class="text-sm p-1 flex items-center justify-between gap-x-4">
                    <span class="text-white">{{ $email }}</span>

                    {{-- Task 4: Per-email delete button --}}
                    <form method="POST" action="/formtest/{{ $index }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="rounded px-2 py-0.5 text-xs text-red-400 border border-red-400/30 hover:bg-red-500/10 transition"
                        >
                            Remove
                        </button>
                    </form>
                </li>
            @empty
                <li class="text-sm text-gray-500 p-1">No emails stored yet.</li>
            @endforelse
        </ul>

        
        @if (count($emails) > 0)
            <div class="mt-4">
                <a href="/delete-emails" class="text-xs text-gray-500 hover:text-red-400 transition">Clear all</a>
            </div>
        @endif
    </div>

</x-layout>