<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-xl bg-[#c0343d] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#a82b33] focus:outline-none focus:ring-2 focus:ring-[#c0343d] focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60']) }}>
    {{ $slot }}
</button>
