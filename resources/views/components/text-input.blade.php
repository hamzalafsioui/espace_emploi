@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-200 focus:border-brand-primary focus:ring-brand-primary rounded-lg shadow-sm font-medium text-slate-800 placeholder-slate-400']) }}>