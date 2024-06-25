<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class Helper {

    public static function formatAmount($amount)
    {
        // Remover el símbolo de dólar y el porcentaje
        $amount = str_replace(['$', '%'], '', $amount);

        // Remover espacios en blanco
        $amount = trim($amount);

        // Si hay más de un punto o coma, asumimos que es un separador de miles y lo removemos
        if (substr_count($amount, '.') > 1) {
            $amount = str_replace('.', '', $amount);
        } elseif (substr_count($amount, ',') > 1) {
            $amount = str_replace(',', '', $amount);
        }

        // Reemplazar coma por punto
        $amount = str_replace(',', '.', $amount);

        return $amount;
    }


    public static function formatSpanishDate($date)
    {
        return Carbon::parse($date)->locale('es')->isoFormat('LL');
    }

    public static function separeDates($dateRange)
    {
        $dates = explode(" - ", $dateRange);
        $startDate = $dates[0];
        $endDate = $dates[1];
        return [$startDate, $endDate];
    }

}
