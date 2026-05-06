<?php

// Helper functions untuk aplikasi E-Surat Dinas

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('formatDollar')) {
    function formatDollar($angka) {
        return '$ ' . number_format($angka, 2, '.', ',');
    }
}