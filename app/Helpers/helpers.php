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

if (!function_exists('imageToBase64')) {
    function imageToBase64($path) {
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return '';
    }
}