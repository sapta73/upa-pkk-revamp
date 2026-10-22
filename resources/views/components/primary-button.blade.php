<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-xl bg-[#ffb600] px-5 py-2.5 text-sm font-bold text-[#252525] shadow-sm transition hover:bg-[#e6a400] focus:outline-none focus:ring-2 focus:ring-[#ffb600] focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60']) }}>
    {{ $slot }}
</button>
