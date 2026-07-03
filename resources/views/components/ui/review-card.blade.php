@props(['review'])

<div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
    <div class="flex justify-between items-start mb-2">
        <div class="flex items-center gap-3">
            <x-profile-picture 
                class="w-10 h-10 border border-gray-200"
                avatarUrl="{{ $review->user && $review->user->pdp_path ? asset($review->user->pdp_path) : '' }}"
                altText="{{ $review->user ? $review->user->firstname ?? 'C' : 'C' }}"
            />
            <div>
                <span class="font-bold text-[#1B1B18] block">{{ $review->user ? $review->user->firstname . ' ' . $review->user->lastname : 'Client' }}</span>
                <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <span class="flex items-center text-[#F8B803] font-bold gap-1 bg-yellow-50 px-2 py-1 rounded-lg">
            {{ $review->rating }}/5
            <x-icon name="star" class="h-4 w-4" />
        </span>
    </div>
    {{ $slot }}
    <p class="text-[#706f6c] mt-2">{{ $review->comment }}</p>
</div>
