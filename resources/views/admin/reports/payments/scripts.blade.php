@push('after_styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@push('after_scripts')
    <script src="{{ asset('/js/easepicker.js') }}"></script>
    <script>
        const picker = new easepick.create({
            element: "#datepicker",
            css: [
                `{{ asset('/css/easepicker.css') }}`
            ],
            zIndex: 10,
            grid: 2,
            calendars: 2,
            format: 'DD/MM/YYYY',
            inline: false,
            header: "Calendario",
            lang: 'es-MX',
            plugins: [
                "RangePlugin",
                "AmpPlugin",
                "LockPlugin",
                "PresetPlugin"
            ],
            PresetPlugin: {
                customLabels: ['Hoy', 'Ayer', 'Últimos 7 días', 'Últimos 30 días', 'Este mes', 'Mes pasado']
            },
        });
        picker.setStartDate(`{{ $from }}`);
        picker.setEndDate(`{{ $to }}`);
    </script>
@endpush