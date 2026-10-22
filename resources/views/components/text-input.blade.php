@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-xl border-gray-300 bg-white text-sm text-[#1f2937] shadow-sm transition focus:border-[#ffb600] focus:ring-[#ffb600] disabled:bg-gray-50']) }}>
